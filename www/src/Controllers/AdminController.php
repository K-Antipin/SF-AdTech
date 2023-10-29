<?php

namespace App\Controllers;

use App\Kernel\Controller\Controller;
use App\Services\OfferService;
use App\Services\SubscribeService;

class AdminController extends Controller
{
    public function index(): void
    {
        if ($this->auth()->check()) {
            $offers = new OfferService($this->db(), $this->auth());
            $subscribe = new SubscribeService($this->db(), $this->session(), $this->auth());

            $this->view("/{$this->auth()->user()->role()}/admin", [
                'subscribers' => $subscribe->allUser($this->auth()->id()),
                'offers' => $offers->allUser($this->auth()->id()),
                'request' => $this->request(),
            ], 'Админка');
        } else {
            $this->redirect('/');
        }
    }

    public function offers(): void
    {
        if ($this->auth()->check()) {
            $offers = new OfferService($this->db(), $this->auth());
            // dd($offers->all());
            $this->view("/{$this->auth()->user()->role()}/offers", [
                'offers' => $offers->all(),
                'request' => $this->request(),
            ], 'Офферы');
        } else {
            $this->redirect('/');
        }
    }

    public function subscribers(): void
    {
        if ($this->auth()->check()) {
            $subscribe = new SubscribeService($this->db(), $this->session(), $this->auth());

            $this->view("/{$this->auth()->user()->role()}/subscribers", [
                'subscribers' => $subscribe->all(),
                'request' => $this->request(),
            ], 'Подписки');
        } else {
            $this->redirect('/');
        }
    }

    public function statistics(): void
    {
        if ($this->auth()->check()) {
            $statistics = $this->db()::getAll('SELECT * FROM statistics');
            $urls = $this->db()::count('subscribe');

            $clicks = count($statistics);
            $rejection = 0;
            $cost = 0;
            foreach ($statistics as $statistic) {
                $rejection += (int) $statistic['rejection'];
                if ($statistic['rejection'] == 1)
                    continue;
                $cost += (float) $statistic['price'];
            }

            $this->view("/{$this->auth()->user()->role()}/statistics", [
                'urls' => $urls,
                'clicks' => $clicks,
                'rejection' => $rejection,
                'cost' => ($cost * 0.2),
            ], 'Статистика');
        } else {
            $this->redirect('/');
        }
    }

    public function arhive(): void
    {
        if (!$this->auth()->check()) {
            $this->redirect('/');
        }

        $subscribe = new SubscribeService($this->db(), $this->session(), $this->auth());
        $offers = new OfferService($this->db(), $this->auth());

        $this->view("{$this->auth()->user()->role()}/arhive", [
            'subscribers' => $subscribe->all(),
            'offers' => $offers->arhive(),
        ]);
    }
}