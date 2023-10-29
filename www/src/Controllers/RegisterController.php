<?php

namespace App\Controllers;

use App\Kernel\Controller\Controller;

class RegisterController extends Controller
{
    public function index(): void
    {
        $this->view(name: 'register', title: 'Регистрация');
    }

    public function register()
    {
        $validation = $this->request()->validate([
            'name' => ['required', 'max:255'],
            'email' => ['required', 'email'],
            'role' => ['required', 'role'],
            'password' => ['required', 'min:8', 'confirmed'],
            'password_confirmation' => ['required', 'min:8'],
        ]);

        if (! $validation) {
            foreach ($this->request()->errors() as $field => $errors) {
                $this->session()->set($field, $errors);
            }

            $this->redirect('/register');
        }

        $this->db()->insert('users', [
            'name' => $this->request()->input('name'),
            'role' => $this->request()->input('role'),
            'email' => $this->request()->input('email'),
            'password' => password_hash($this->request()->input('password'), PASSWORD_DEFAULT),
        ]);

        die(json_encode('redirect'));
    }
}
