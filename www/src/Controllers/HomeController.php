<?php

namespace App\Controllers;

use App\Services\OfferService;
use App\Services\SubscribeService;
use App\Kernel\Controller\Controller;

class HomeController extends Controller
{
    public function index(): void
    {
        if (!$this->auth()->check()) {
            $offer = new OfferService($this->db(), $this->auth());
            $this->view('home', [
                'offers' => $offer->new(),
                'request' => $this->request(),
            ], 'Главная страница');
        } else {
            $offers = new OfferService($this->db(), $this->auth());
            $subscribe = new SubscribeService($this->db(), $this->session(), $this->auth());

            $this->view("{$this->auth()->user()->role()}/index", [
                'subscribers' => $subscribe->all(),
                'offers' => $offers->all(),
                'request' => $this->request(),
            ]);
        }
    }

    public function error(): void
    {
        $this->view('404', [], 'Главная страница');
    }
}