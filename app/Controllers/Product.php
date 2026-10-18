<?php

namespace App\Controllers;

class Product extends BaseController
{
    protected $db;

    public function __construct()
    {
        $this->db = \Config\Database::connect();
    }

    private function requireLogin()
    {
        if (! session()->get('isLoggedIn')) {
            return redirect()->to('/login');
        }

        return null;
    }

    private function uploadImage($file)
    {
        if (! $file || ! $file->isValid() || $file->hasMoved()) {
            return null;
        }

        $allowedTypes = ['image/jpeg', 'image/png', 'image/webp'];

        if (! in_array($file->getMimeType(), $allowedTypes, true)) {
            return null;
        }

        if ($file->getSizeByUnit('mb') > 2) {
            return null;
        }

        $uploadPath = FCPATH . 'uploads/products/';

        if (! is_dir($uploadPath)) {
            mkdir($uploadPath, 0755, true);
        }

        $newName = $file->getRandomName();

        if ($file->move($uploadPath, $newName)) {
            return $newName;
        }

        return null;
    }

    private function removeImage($filename)
    {
        if (empty($filename)) {
            return;
        }

        $path = FCPATH . 'uploads/products/' . basename($filename);

        if (is_file($path)) {
            unlink($path);
        }
    }

    public function index()
    {
        if ($redirect = $this->requireLogin()) {
            return $redirect;
        }

        $products = $this->db->table('products')
            ->orderBy('id', 'DESC')
            ->get()
            ->getResultArray();

        return view('products/index', [
            'title' => 'Products',
            'products' => $products,
        ]);
    }

    public function create()
    {
        if ($redirect = $this->requireLogin()) {
            return $redirect;
        }

        return view('products/create', [
            'title' => 'Add Product',
            'errors' => session()->getFlashdata('errors') ?? [],
            'formData' => session()->getFlashdata('formData') ?? [],
        ]);
    }

    public function store()
    {
        if ($redirect = $this->requireLogin()) {
            return $redirect;
        }

        $rules = [
            'name' => 'required|min_length[2]|max_length[100]',
            'price' => 'required|decimal|greater_than_equal_to[0]',
            'stock_quantity' => 'required|integer|greater_than_equal_to[0]',
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()
                ->withInput()
                ->with('errors', $this->validator->getErrors());
        }

        $imageName = null;
        $image = $this->request->getFile('image');

        if ($image && $image->getError() !== UPLOAD_ERR_NO_FILE) {
            if (! $image->isValid()) {
                return redirect()->back()
                    ->withInput()
                    ->with('error', 'Image upload failed. Please try again.');
            }

            $imageName = $this->uploadImage($image);

            if ($imageName === null) {
                return redirect()->back()
                    ->withInput()
                    ->with('error', 'Use a JPG, PNG, or WebP image up to 2 MB.');
            }
        }

        $this->db->table('products')->insert([
            'name' => trim($this->request->getPost('name')),
            'price' => $this->request->getPost('price'),
            'stock_quantity' => $this->request->getPost('stock_quantity'),
            'image' => $imageName,
        ]);

        if ($this->db->affectedRows() < 1) {
            $this->removeImage($imageName);

            return redirect()->back()
                ->withInput()
                ->with('error', 'Unable to save the product.');
        }

        return redirect()->to('/products')
            ->with('success', 'Product added successfully.');
    }

    public function edit($id = null)
    {
        if ($redirect = $this->requireLogin()) {
            return $redirect;
        }

        $product = $this->db->table('products')
            ->where('id', (int) $id)
            ->get()
            ->getRowArray();

        if (! $product) {
            return redirect()->to('/products')
                ->with('error', 'Product not found.');
        }

        // Important: render the PRODUCTS edit view, not the Staff view.
        return view('products/edit', [
            'title' => 'Edit Product',
            'product' => $product,
            'errors' => session()->getFlashdata('errors') ?? [],
        ]);
    }

    public function update($id = null)
    {
        if ($redirect = $this->requireLogin()) {
            return $redirect;
        }

        $id = (int) $id;

        $product = $this->db->table('products')
            ->where('id', $id)
            ->get()
            ->getRowArray();

        if (! $product) {
            return redirect()->to('/products')
                ->with('error', 'Product not found.');
        }

        $rules = [
            'name' => 'required|min_length[2]|max_length[100]',
            'price' => 'required|decimal|greater_than_equal_to[0]',
            'stock_quantity' => 'required|integer|greater_than_equal_to[0]',
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()
                ->withInput()
                ->with('errors', $this->validator->getErrors());
        }

        $imageName = $product['image'] ?? null;
        $image = $this->request->getFile('image');
        $newImageName = null;

        if ($image && $image->getError() !== UPLOAD_ERR_NO_FILE) {
            if (! $image->isValid()) {
                return redirect()->back()
                    ->withInput()
                    ->with('error', 'Image upload failed. Please try again.');
            }

            $newImageName = $this->uploadImage($image);

            if ($newImageName === null) {
                return redirect()->back()
                    ->withInput()
                    ->with('error', 'Use a JPG, PNG, or WebP image up to 2 MB.');
            }

            $imageName = $newImageName;
        }

        $updated = $this->db->table('products')
            ->where('id', $id)
            ->update([
                'name' => trim($this->request->getPost('name')),
                'price' => $this->request->getPost('price'),
                'stock_quantity' => $this->request->getPost('stock_quantity'),
                'image' => $imageName,
            ]);

        if ($updated === false) {
            $this->removeImage($newImageName);

            return redirect()->back()
                ->withInput()
                ->with('error', 'Unable to update the product.');
        }

        if ($newImageName !== null && ! empty($product['image'])) {
            $this->removeImage($product['image']);
        }

        return redirect()->to('/products')
            ->with('success', 'Product updated successfully.');
    }

    public function delete($id = null)
    {
        if ($redirect = $this->requireLogin()) {
            return $redirect;
        }

        $id = (int) $id;

        $product = $this->db->table('products')
            ->where('id', $id)
            ->get()
            ->getRowArray();

        if (! $product) {
            return redirect()->to('/products')
                ->with('error', 'Product not found.');
        }

        try {
            $this->db->table('products')
                ->where('id', $id)
                ->delete();

            if ($this->db->affectedRows() < 1) {
                return redirect()->to('/products')
                    ->with('error', 'Product could not be deleted.');
            }

            $this->removeImage($product['image'] ?? null);

            return redirect()->to('/products')
                ->with('success', 'Product deleted successfully.');
        } catch (\Throwable $e) {
            log_message('error', 'Product deletion failed: {message}', [
                'message' => $e->getMessage(),
            ]);

            return redirect()->to('/products')
                ->with('error', 'This product may be linked to existing sales and cannot be deleted.');
        }
    }
}