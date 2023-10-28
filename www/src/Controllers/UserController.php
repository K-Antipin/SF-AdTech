<?php

namespace App\Controllers;

use App\Kernel\Controller\Controller;
use App\Kernel\Auth\User;

class UserController extends Controller
{
    public function index()
    {

        $users = $this->allUsers();

        $this->view(
            'users',
            [
                'users' => $users,
            ],
            'Пользователи'
        );
    }
    public function add()
    {
        $user = $this->db()::dispense('users');
        $user->name = $this->request()->input('name');
        $user->email = $this->request()->input('email');
        $user->password = password_hash($this->request()->input('password'), PASSWORD_DEFAULT);
        $user->role = $this->request()->input('role');
        $this->db()::store($user);
    }

    public function edit()
    {
        $user = $this->user();

        $this->view(
            'register',
            [
                'user' => $user,
            ],
            'Регистрация'
        );
    }

    public function update()
    {
        $id = $this->request()->input('id');
        $user = $this->db()::load('users', $id);
        $user->name = $this->request()->input('name');
        $user->email = $this->request()->input('email');
        if ($this->request()->input('password'))
            $user->password = password_hash($this->request()->input('password'), PASSWORD_DEFAULT);
        $user->role = $this->request()->input('role');
        $user->status = $this->request()->input('status');
        
        $this->db()::store($user);

        // $this->redirect('/user?id=' . $id);
        die(json_encode(true));
    
    }

    public function user(): ?User
    {
        if (!$this->auth()->check()) {
            return null;
        }

        $user = $this->db()::load('users', $this->request()->input('id'));

        if ($user) {
            return new User(
                $user['id'],
                $user['name'],
                $user['email'],
                $user['password'],
                $user['role'],
                $user['status']
            );
        }

        return null;
    }

    public function allUsers()
    {
        $users = $this->db()->get('users', [], ['id' => 'DESC']);

        return array_map(function ($user) {
            return new User(
                $user['id'],
                $user['name'],
                $user['email'],
                $user['password'],
                $user['role'],
                $user['status']
            );
        }, $users);
    }

}