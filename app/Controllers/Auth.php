<?php

namespace App\Controllers;

class Auth extends BaseController
{
    public function login()
    {
        if (session()->get('isLoggedIn')) {
            return redirect()->to(site_url('dashboard'));
        }

        return view('auth/login');
    }

    public function attemptLogin()
    {
        $rules = [
            'username' => 'required|max_length[50]',
            'password' => 'required',
        ];

        if (! $this->validate($rules)) {
            return redirect()->to(site_url('login'))
                ->withInput()
                ->with('error', 'Please enter your username and password.');
        }

        $username = trim($this->request->getPost('username'));
        $password = $this->request->getPost('password');

        $db = \Config\Database::connect();

        $user = $db->table('users')
            ->where('username', $username)
            ->get()
            ->getRowArray();

        if (! $user || ! password_verify($password, $user['password'])) {
            return redirect()->to(site_url('login'))
                ->with('error', 'Invalid username or password.');
        }

        session()->regenerate(true);

        session()->set([
            'user_id'    => $user['id'],
            'username'   => $user['username'],
            'full_name'  => $user['full_name'],
            'avatar'     => $user['avatar'],
            'isLoggedIn' => true,
        ]);

        return redirect()->to(site_url('dashboard'));
    }

    public function logout()
    {
        session()->destroy();

        return redirect()->to(site_url('login'))
            ->with('success', 'You have been signed out.');
    }
}