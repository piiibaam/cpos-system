<?php

namespace App\Controllers;

use CodeIgniter\Exceptions\PageNotFoundException;

class Sale extends BaseController
{
    private function requireLogin()
    {
        if (! session()->get('isLoggedIn')) {
            return redirect()->to('/login');
        }

        return null;
    }

    public function create()
    {
        if ($redirect = $this->requireLogin()) {
            return $redirect;
        }

        $db = \Config\Database::connect();

        $products = $db->table('products')
            ->select('id, name, price, stock_quantity')
            ->orderBy('name', 'ASC')
            ->get()
            ->getResultArray();

        $customers = $db->table('customers')
            ->select('id, full_name, email')
            ->orderBy('full_name', 'ASC')
            ->get()
            ->getResultArray();

        return view('sales/create', [
            'title' => 'Record Sale',
            'products' => $products,
            'customers' => $customers,
            'errors' => session()->getFlashdata('errors') ?? [],
            'success' => session()->getFlashdata('success'),
        ]);
    }

    public function store()
    {
        if ($redirect = $this->requireLogin()) {
            return $redirect;
        }

        $rules = [
            'product_id' => 'required|is_natural_no_zero',
            'quantity'   => 'required|integer|greater_than[0]',
            'customer_id' => 'permit_empty|is_natural_no_zero',
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()
                ->withInput()
                ->with('errors', $this->validator->getErrors());
        }

        $db = \Config\Database::connect();

        $productId = (int) $this->request->getPost('product_id');
        $quantity = (int) $this->request->getPost('quantity');
        $customerInput = $this->request->getPost('customer_id');
        $customerId = ($customerInput === '' || $customerInput === null)
            ? null
            : (int) $customerInput;
        $userId = (int) session()->get('user_id');

        if ($userId < 1) {
            session()->destroy();
            return redirect()->to('/login');
        }

        // Confirm the selected customer exists, if one was provided.
        if ($customerId !== null) {
            $customerExists = $db->table('customers')
                ->where('id', $customerId)
                ->countAllResults();

            if (! $customerExists) {
                return redirect()->back()
                    ->withInput()
                    ->with('errors', [
                        'customer_id' => 'The selected customer does not exist.',
                    ]);
            }
        }

        // Confirm the logged-in staff account still exists.
        $staffExists = $db->table('users')
            ->where('id', $userId)
            ->countAllResults();

        if (! $staffExists) {
            session()->destroy();
            return redirect()->to('/login');
        }

        $db->transBegin();

        try {
            // Lock the product row while checking and updating stock.
            $product = $db->query(
                'SELECT id, name, price, stock_quantity
                 FROM products
                 WHERE id = ?
                 FOR UPDATE',
                [$productId]
            )->getRowArray();

            if (! $product) {
                $db->transRollback();

                return redirect()->back()
                    ->withInput()
                    ->with('errors', [
                        'product_id' => 'The selected product was not found.',
                    ]);
            }

            if ($quantity > (int) $product['stock_quantity']) {
                $available = (int) $product['stock_quantity'];
                $db->transRollback();

                return redirect()->back()
                    ->withInput()
                    ->with('errors', [
                        'quantity' => "Insufficient stock. Only {$available} item(s) available.",
                    ]);
            }

            $totalPrice = round(
                (float) $product['price'] * $quantity,
                2
            );

            // Deduct stock only if enough stock remains.
            $db->table('products')
                ->set(
                    'stock_quantity',
                    'stock_quantity - ' . $quantity,
                    false
                )
                ->where('id', $productId)
                ->where('stock_quantity >=', $quantity)
                ->update();

            if ($db->affectedRows() !== 1) {
                $db->transRollback();

                return redirect()->back()
                    ->withInput()
                    ->with('errors', [
                        'quantity' => 'Stock changed while processing. Please try again.',
                    ]);
            }

            $db->table('sales')->insert([
                'product_id'  => $productId,
                'customer_id' => $customerId,
                'sold_by'     => $userId,
                'quantity'    => $quantity,
                'total_price' => $totalPrice,
            ]);

            if ($db->transStatus() === false) {
                throw new \RuntimeException('Unable to save the sale.');
            }

            $db->transCommit();

            return redirect()->to('/sales/create')
                ->with('success', 'Sale recorded successfully! Stock has been updated.');
        } catch (\Throwable $e) {
            $db->transRollback();

            log_message('error', 'Record sale failed: {message}', [
                'message' => $e->getMessage(),
            ]);

            return redirect()->back()
                ->withInput()
                ->with('errors', [
                    'general' => 'The sale could not be saved. Please check the product and try again.',
                ]);
        }
    }

    public function history()
    {
        if ($redirect = $this->requireLogin()) {
            return $redirect;
        }

        $db = \Config\Database::connect();
        $search = trim((string) $this->request->getGet('q'));

        $builder = $db->table('sales s')
            ->select([
                's.id',
                's.quantity',
                's.total_price',
                's.created_at',
                'p.name AS product_name',
                'c.full_name AS customer_name',
                'u.full_name AS staff_name',
            ])
            ->join('products p', 'p.id = s.product_id', 'left')
            ->join('customers c', 'c.id = s.customer_id', 'left')
            ->join('users u', 'u.id = s.sold_by', 'left');

        if ($search !== '') {
            $builder->groupStart()
                ->like('p.name', $search)
                ->orLike('c.full_name', $search)
                ->orLike('u.full_name', $search)
                ->orLike('s.created_at', $search)
                ->groupEnd();
        }

        $sales = $builder
            ->orderBy('s.created_at', 'DESC')
            ->orderBy('s.id', 'DESC')
            ->get()
            ->getResultArray();

        $totalSales = 0;

        foreach ($sales as $sale) {
            $totalSales += (float) $sale['total_price'];
        }

        return view('sales/history', [
            'title' => 'Sales History',
            'sales' => $sales,
            'search' => $search,
            'totalSales' => $totalSales,
        ]);
    }
}