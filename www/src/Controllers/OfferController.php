<?php

namespace App\Controllers;

use App\Kernel\Controller\Controller;
use App\Services\CategoryService;
use App\Services\OfferService;
use App\Kernel\Config\Config;

class OfferController extends Controller
{
    private OfferService $service;

    public function create(): void
    {
        $categories = new CategoryService($this->db());

        $this->view('admin/offers/add', [
            'categories' => $categories->all(),
        ]);
    }

    public function add(): void
    {
        $this->view('admin/offers/add');
    }

    public function store(): void
    {
        $validation = $this->request()->validate([
            'name' => ['required', 'min:3', 'max:50'],
            'description' => ['required'],
            'price' => ['required'],
            'url' => ['required'],
        ]);

        if (!$validation) {
            // foreach ($this->request()->errors() as $field => $errors) {
            //     $this->session()->set($field, $errors);
            // }

            // $this->redirect('/admin/offers/add');

            die(json_encode($this->request()->errors()));
        }

        die(
            json_encode(
                $this->service()->store(
                    $this->session()->get('user_id'),
                    $this->request()->input('name'),
                    $this->request()->input('description'),
                    $this->request()->input('price'),
                    $this->request()->input('url'),
                )
            )
        );
    }

    public function destroy(): void
    {
        $this->service()->destroy($this->request()->input('id'));

        $this->redirect('/admin');
    }

    public function zip(): void
    {
        $this->service()->zip($this->request()->input('table'), $this->request()->input('id'));
    }

    public function unzip(): void
    {
        
        $this->service()->unzip($this->request()->input('table'), $this->request()->input('id'));
    }

    public function subscribe(): void
    {

        // $this->service()->subscribe(
        //     $this->session()->get('user_id'),
        //     $this->request()->input('id'),
        //     $this->request()->input('name'),
        //     $this->request()->input('price'),
        //     $this->request()->input('url'),
        // );

        // $this->redirect('/admin');

        //рефакторинг под fetch
        die(
            json_encode(
                $this->service()->subscribe(
                    $this->session()->get('user_id'),
                    $this->request()->input('id'),
                    $this->request()->input('name'),
                    $this->request()->input('price'),
                    $this->request()->input('url'),
                )
            )
        );
    }

    public function edit(): void
    {
        $categories = new CategoryService($this->db());

        $this->view('admin/offers/update', [
            'offer' => $this->service()->find($this->request()->input('id')),
            'categories' => $categories->all()
        ]);
    }

    public function update()
    {
        $validation = $this->request()->validate([
            'name' => ['required', 'min:3', 'max:50'],
            'description' => ['required'],
            'price' => ['required'],
        ]);

        if (!$validation) {
            foreach ($this->request()->errors() as $field => $errors) {
                $this->session()->set($field, $errors);
            }

            $this->redirect("/admin/offers/update?id={$this->request()->input('id')}");
        }

        $this->service()->update(
            $this->request()->input('id'),
            $this->request()->input('name'),
            $this->request()->input('description'),
            $this->request()->input('price'),
            $this->request()->input('url'),
        );

        $this->redirect('/admin');
    }

    public function show(): void
    {
        $offer = $this->service()->find($this->request()->input('id'));
        
        $config = new Config;

        $this->view('offers', [
            'offer' => $offer,
            'config' => $config,
            'request' => $this->request(),
        ], "Offer - {$offer->name()}");
    }

    private function service(): OfferService
    {
        if (!isset($this->service)) {
            $this->service = new OfferService($this->db(), $this->auth());
        }

        return $this->service;
    }
}