<?php

namespace App\Controllers;

class Staff extends BaseController
{
    private function requireLogin()
    {
        if (! session()->get('isLoggedIn')) {
            return redirect()->to('/login');
        }

        return null;
    }

    public function index()
    {
        if ($redirect = $this->requireLogin()) {
            return $redirect;
        }

        $db = \Config\Database::connect();
        $search = trim((string) $this->request->getGet('search'));

        $builder = $db->table('users')
            ->select('id, username, full_name, avatar, created_at');

        if ($search !== '') {
            $builder->groupStart()
                ->like('username', $search)
                ->orLike('full_name', $search)
                ->groupEnd();
        }

        $data = [
            'title' => 'Staff Management',
            'staff' => $builder->orderBy('id', 'DESC')->get()->getResultArray(),
            'search' => $search,
        ];

        return view('staff/index', $data);
    }

    public function create()
    {
        if ($redirect = $this->requireLogin()) {
            return $redirect;
        }

        return view('staff/create', [
            'title' => 'Add Staff',
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
            'username' => 'required|min_length[3]|max_length[50]|is_unique[users.username]',
            'full_name' => 'required|max_length[100]',
            'password' => 'required|min_length[8]',
            'avatar' => 'permit_empty|is_image[avatar]|mime_in[avatar,image/jpg,image/jpeg,image/png,image/webp]|max_size[avatar,2048]',
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $avatarName = null;
        $avatar = $this->request->getFile('avatar');

        if ($avatar && $avatar->isValid() && ! $avatar->hasMoved()) {
            $uploadPath = FCPATH . 'uploads/staff/';

            if (! is_dir($uploadPath)) {
                mkdir($uploadPath, 0775, true);
            }

            $avatarName = $avatar->getRandomName();
            $avatar->move($uploadPath, $avatarName);
        }

        \Config\Database::connect()->table('users')->insert([
            'username' => trim($this->request->getPost('username')),
            'full_name' => trim($this->request->getPost('full_name')),
            'password' => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
            'avatar' => $avatarName,
            'created_at' => date('Y-m-d H:i:s'),
        ]);

        return redirect()->to('/staff')->with('success', 'Staff account created successfully!');
    }

    public function edit($id)
    {
        if ($redirect = $this->requireLogin()) {
            return $redirect;
        }

        $member = \Config\Database::connect()
            ->table('users')
            ->where('id', $id)
            ->get()
            ->getRowArray();

        if (! $member) {
            return redirect()->to('/staff')->with('error', 'Staff account not found.');
        }

        return view('staff/edit', [
            'title' => 'Edit Staff',
            'member' => $member,
            'errors' => session()->getFlashdata('errors') ?? [],
        ]);
    }

    public function update($id)
    {
        if ($redirect = $this->requireLogin()) {
            return $redirect;
        }

        $db = \Config\Database::connect();
        $member = $db->table('users')->where('id', $id)->get()->getRowArray();

        if (! $member) {
            return redirect()->to('/staff')->with('error', 'Staff account not found.');
        }

        $rules = [
            'username' => "required|min_length[3]|max_length[50]|is_unique[users.username,id,{$id}]",
            'full_name' => 'required|max_length[100]',
            'password' => 'permit_empty|min_length[8]',
            'avatar' => 'permit_empty|is_image[avatar]|mime_in[avatar,image/jpg,image/jpeg,image/png,image/webp]|max_size[avatar,2048]',
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $avatarName = $member['avatar'];
        $avatar = $this->request->getFile('avatar');

        if ($avatar && $avatar->isValid() && ! $avatar->hasMoved()) {
            $uploadPath = FCPATH . 'uploads/staff/';

            if (! is_dir($uploadPath)) {
                mkdir($uploadPath, 0775, true);
            }

            $newAvatarName = $avatar->getRandomName();
            $avatar->move($uploadPath, $newAvatarName);

            if ($avatarName && is_file($uploadPath . $avatarName)) {
                unlink($uploadPath . $avatarName);
            }

            $avatarName = $newAvatarName;
        }

        $updates = [
            'username' => trim($this->request->getPost('username')),
            'full_name' => trim($this->request->getPost('full_name')),
            'avatar' => $avatarName,
        ];

        $newPassword = $this->request->getPost('password');

        if ($newPassword !== '') {
            $updates['password'] = password_hash($newPassword, PASSWORD_DEFAULT);
        }

        $db->table('users')->where('id', $id)->update($updates);

        // Keep the active session's staff details up to date.
        if ((int) session()->get('user_id') === (int) $id) {
            session()->set([
                'username' => $updates['username'],
                'full_name' => $updates['full_name'],
                'avatar' => $avatarName,
            ]);
        }

        return redirect()->to('/staff')->with('success', 'Staff account updated successfully!');
    }

    public function delete($id)
    {
        if ($redirect = $this->requireLogin()) {
            return $redirect;
        }

        if ((int) session()->get('user_id') === (int) $id) {
            return redirect()->to('/staff')->with('error', 'You cannot delete the staff account currently signed in.');
        }

        $db = \Config\Database::connect();
        $member = $db->table('users')->where('id', $id)->get()->getRowArray();

        if (! $member) {
            return redirect()->to('/staff')->with('error', 'Staff account not found.');
        }

        try {
            $db->table('users')->where('id', $id)->delete();
        } catch (\CodeIgniter\Database\Exceptions\DatabaseException $e) {
            return redirect()->to('/staff')->with('error', 'This staff account could not be deleted because another record may depend on it.');
        }

        if (! empty($member['avatar'])) {
            $avatarPath = FCPATH . 'uploads/staff/' . $member['avatar'];

            if (is_file($avatarPath)) {
                unlink($avatarPath);
            }
        }

        return redirect()->to('/staff')->with('success', 'Staff account deleted successfully!');
    }
}