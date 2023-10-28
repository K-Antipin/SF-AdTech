<?php

namespace App\Controllers;

use App\Kernel\Controller\Controller;

class SubscribeController extends Controller
{
    public function store()
    {
        $validation = $this->request()->validate([
            'price' => ['required'],
            'comment' => ['required'],
        ]);

        if (! $validation) {
            foreach ($this->request()->errors() as $field => $errors) {
                $this->session()->set($field, $errors);
            }

            $this->redirect("/offer?id={$this->request()->input('id')}");
        }

        $this->db()->insert('subscribe', [
            'offer_id' => $this->request()->input('id'),
            'user_id' => $this->auth()->id(),
        ]);

        $this->redirect("/offer?id={$this->request()->input('id')}");
    }
}
