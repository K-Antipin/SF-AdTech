<?php

namespace App\Controllers;

use App\Services\OfferService;
use App\Services\SubscribeService;
use App\Kernel\Controller\Controller;

class StatisticsController extends Controller
{
    public function index(): void
    {
        $date_from = $this->request()->input('date_from');
        $date_to = $this->request()->input('date_to');
        
        if (isset($date_from) && isset($date_to)) {
            if ($this->auth()->check()) {
                
                $user = $this->auth()->user();
                
                if ($user->role() === 'admin') {
                    $statistics = $this->db()::getAll(
                        'SELECT * FROM statistics WHERE DATE(`created_at`) >= ? AND DATE(`created_at`) <= ? AND `offer_id` = ?',
                        [
                            $date_from,
                            $date_to,
                            $this->request()->input('offer_id')
                        ]
                    );
                } else {
                    $statistics = $this->db()::getAll(
                        'SELECT * FROM `statistics` WHERE `rejection` = 0 AND `' . $user->role() . '_id` = ? AND DATE(`created_at`) >= ? AND DATE(`created_at`) <= ? AND `offer_id` = ?',
                        [
                            $user->id(),
                            $date_from,
                            $date_to,
                            $this->request()->input('offer_id')
                        ]
                    );
                }

                // $this->view('statistics', [
                //     'statistics' => $statistics,
                //     'user' => $user,
                //     'request' => $this->request(),
                // ], 'Статистика');

                die(json_encode(['user' => $user->role(), 'result' => $statistics]));
            }            
            die(json_encode(false));
        } else {
            die(json_encode(false));
        }
    }
}