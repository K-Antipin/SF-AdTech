<?php

namespace App\Controllers;

use Monolog\Logger;
use Monolog\Handler\StreamHandler;
use App\Kernel\Controller\Controller;

class RedirectorController extends Controller
{
    public function index(): void
    {
        $data = $this->db()::getAll(
            "SELECT subscribe.user_id AS webmaster_id, subscribe.offer_id, subscribe.price, subscribe.url, subscribe.hash, subscribe.active AS subscribe_active, offers.user_id AS advertiser_id, offers.active AS offers_active
            FROM subscribe
            INNER JOIN offers
            ON subscribe.offer_id = offers.id
            WHERE subscribe.hash = ?",
            [$this->request()->input('hash')]
        );
        
        $log = new Logger('mylogger');
        $log->pushHandler(new StreamHandler('mylog.log', Logger::INFO));
        $log->info(
            'Clics',
            [
                'webmaster_id' => $data[0]['webmaster_id'],
                'advertiser_id' => $data[0]['advertiser_id'],
                'offer_id' => $data[0]['offer_id'],
                'price' => $data[0]['price'],
                'url' => $data[0]['url'],
                'hash' => $data[0]['hash'],
                'created_at' => date('Y-m-d H:i:s'),
            ]

        );

        if ($data[0]['subscribe_active'] == 1 && $data[0]['offers_active'] == 1) {
            $bean = $this->db()::dispense('statistics');
            $bean->webmaster_id = $data[0]['webmaster_id'];
            $bean->advertiser_id = $data[0]['advertiser_id'];
            $bean->offer_id = $data[0]['offer_id'];
            $bean->price = $data[0]['price'];
            $bean->url = $data[0]['url'];
            $bean->hash = $data[0]['hash'];
            
            $bean->created_at = date('Y-m-d H:i:s');
            $this->db()::store($bean);

            if (str_contains($data[0]['url'], 'http')) {
                $this->redirect($data[0]['url']);
            } else {
                $this->redirect('https://' . $data[0]['url']);
            }

        } else {
            $bean = $this->db()::dispense('statistics');
            $bean->webmaster_id = $data[0]['webmaster_id'];
            $bean->advertiser_id = $data[0]['advertiser_id'];
            $bean->offer_id = $data[0]['offer_id'];
            $bean->price = $data[0]['price'];
            $bean->url = $data[0]['url'];
            $bean->hash = $data[0]['hash'];
            $bean->rejection = 1;
            $bean->created_at = date('Y-m-d H:i:s');
            $this->db()::store($bean);
            
            $this->redirect('/404');
        }
    }
}