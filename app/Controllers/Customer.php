<?php

namespace App\Controllers;

use CodeIgniter\Exceptions\PageNotFoundException;

class Customer extends BaseController
{
    private function requireLogin()
    {
        if (! session()->get('isLoggedIn')) {
            return redirect()->to(site_url('login'));
        }

        return null;
    }

    public function index()
    {
        if ($redirect = $this->requireLogin()) {
            return $redirect;
        }

        $db = db_connect();
        $search = trim((string) $this->request->getGet('q'));

        $builder = $db->table('customers');

        if ($search !== '') {
            $builder
                ->groupStart()
                ->like('full_name', $search)
                ->orLike('email', $search)
                ->orLike('phone', $search)
                ->groupEnd();
        }

        $customers = $builder
            ->orderBy('id', 'DESC')
            ->get()
            ->getResultArray();

        return view('customers/index', [
            'title'     => 'Customers',
            'customers' => $customers,
            'search'    => $search,
        ]);
    }

    public function create()
    {
        if ($redirect = $this->requireLogin()) {
            return $redirect;
        }

        return view('customers/create', [
            'title' => 'Add Customer',
        ]);
    }

    public function store()
    {
        if ($redirect = $this->requireLogin()) {
            return $redirect;
        }

        $rules = [
            'full_name' => 'required|max_length[100]',
            'email'     => 'required|valid_email|max_length[100]',
            'phone'     => 'permit_empty|max_length[20]',
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()
                ->withInput()
                ->with('errors', $this->validator->getErrors());
        }

        $db = db_connect();

        $db->table('customers')->insert([
            'full_name' => trim((string) $this->request->getPost('full_name')),
            'email'     => trim((string) $this->request->getPost('email')),
            'phone'     => trim((string) $this->request->getPost('phone')) ?: null,
        ]);

        return redirect()->to(site_url('customers'))
            ->with('success', 'Customer added successfully.');
    }

    public function edit($id)
    {
        if ($redirect = $this->requireLogin()) {
            return $redirect;
        }

        $customer = db_connect()
            ->table('customers')
            ->where('id', (int) $id)
            ->get()
            ->getRowArray();

        if (! $customer) {
            throw PageNotFoundException::forPageNotFound('Customer not found.');
        }

        return view('customers/edit', [
            'title'    => 'Edit Customer',
            'customer' => $customer,
        ]);
    }

    public function update($id)
    {
        if ($redirect = $this->requireLogin()) {
            return $redirect;
        }

        $db = db_connect();

        $customer = $db->table('customers')
            ->where('id', (int) $id)
            ->get()
            ->getRowArray();

        if (! $customer) {
            throw PageNotFoundException::forPageNotFound('Customer not found.');
        }

        $rules = [
            'full_name' => 'required|max_length[100]',
            'email'     => 'required|valid_email|max_length[100]',
            'phone'     => 'permit_empty|max_length[20]',
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()
                ->withInput()
                ->with('errors', $this->validator->getErrors());
        }

        $db->table('customers')
            ->where('id', (int) $id)
            ->update([
                'full_name' => trim((string) $this->request->getPost('full_name')),
                'email'     => trim((string) $this->request->getPost('email')),
                'phone'     => trim((string) $this->request->getPost('phone')) ?: null,
            ]);

        return redirect()->to(site_url('customers'))
            ->with('success', 'Customer updated successfully.');
    }

    public function delete($id)
    {
        if ($redirect = $this->requireLogin()) {
            return $redirect;
        }

        $db = db_connect();

        $customer = $db->table('customers')
            ->where('id', (int) $id)
            ->get()
            ->getRowArray();

        if (! $customer) {
            return redirect()->to(site_url('customers'))
                ->with('error', 'Customer not found.');
        }

        try {
            $db->table('customers')
                ->where('id', (int) $id)
                ->delete();
        } catch (\Throwable $e) {
            log_message('error', 'Customer deletion failed: ' . $e->getMessage());

            return redirect()->to(site_url('customers'))
                ->with(
                    'error',
                    'This customer cannot be deleted because a related record may exist. Existing sales history is preserved.'
                );
        }

        if ($db->affectedRows() > 0) {
            return redirect()->to(site_url('customers'))
                ->with('success', 'Customer deleted successfully.');
        }

        return redirect()->to(site_url('customers'))
            ->with('error', 'Customer could not be deleted.');
    }
}