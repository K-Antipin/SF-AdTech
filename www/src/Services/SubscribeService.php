<?php

namespace App\Services;

use App\Kernel\Database\DatabaseInterface;
use App\Kernel\Auth\Auth;
use App\Kernel\Session\SessionInterface;
use App\Models\Offer;
use App\Models\Subscribe;

class SubscribeService
{
    public function __construct(
        private DatabaseInterface $db,
        private SessionInterface $session,
        private Auth $auth
    ) {
    }

    public function store(int $offer_id, string $name, string $description, float $price, string $url): false|int
    {
        return $this->db->insert('subscribe', [
            'user_id' => $this->session->get('user_id'),
            'offer_id' => $offer_id,
            'name' => $name,
            'description' => $description,
            'price' => $price,
            'url' => $url,
        ]);
    }

    public function subscribe($user_id, $offer_id, $name, $url): false|int
    {
        return $this->db->insert('subscribe', [
            'user_id' => $user_id,
            'offer_id' => $offer_id,
            'hash' => $offer_id,
        ]);
    }

    public function all()
    {
        $subscribers = $this->db->get('subscribe');
        
        return array_map(function ($subscribe) {
            $offer = $this->db->first('offers', [
                'id' => $subscribe['offer_id'],
            ]);
            // dd($offer);
            return new Subscribe(
                $subscribe['id'],
                $subscribe['user_id'],
                $subscribe['offer_id'],
                $subscribe['name'],
                $subscribe['price'],
                $subscribe['url'],
                $subscribe['hash'],
                $subscribe['active'],
                $subscribe['is_admin'],
                $subscribe['created_at'],
                $subscribe['updated_at'],
                new Offer(
                    $offer['id'],
                    $offer['name'],
                    $offer['description'],
                    $offer['price'],
                    $offer['url'],
                    $offer['active'],
                    $offer['is_admin'],
                    $offer['created_at'],
                )
            );
        }, $subscribers);
    }

    public function allUser(int $id): array
    {
        $subscribers = $this->db->get('subscribe', [
            'user_id' => $id,
            'is_admin' => 0
        ]);
        
        return array_map(function ($subscribe) {
            $offer = $this->db->first('offers', [
                'id' => $subscribe['offer_id'],
                // 'is_admin' => 0
            ]);
            
            return new Subscribe(
                $subscribe['id'],
                $subscribe['user_id'],
                $subscribe['offer_id'],
                $subscribe['name'],
                $subscribe['price'],
                $subscribe['url'],
                $subscribe['hash'],
                $subscribe['active'],
                $subscribe['is_admin'],
                $subscribe['created_at'],
                $subscribe['updated_at'],
                new Offer(
                    $offer['id'],
                    $offer['name'],
                    $offer['description'],
                    $offer['price'],
                    $offer['url'],
                    $offer['active'],
                    $offer['is_admin'],
                    $offer['created_at'],
                )
            );
        }, $subscribers);
    }

    public function destroy(int $id): void
    {

    }

    public function zip(int $id): void
    {
        $is_admin = $this->auth->user()->role() === 'admin' ? 1 : 0;
        $this->db->update(
            'offers',
            [
                'active' => 0,
                'is_admin' => $is_admin
            ],
            [
                'id' => $id,
            ]
        );
    }

    public function unzip(int $id): void
    {
        if ($this->auth->user()->role() === 'admin') {
            $this->db->update(
                'offers',
                [
                    'active' => 1,
                    'is_admin' => 0
                ],
                [
                    'id' => $id,
                ]
            );
        } else {
            $this->db->update(
                'offers',
                [
                    'active' => 1,
                ],
                [
                    'id' => $id,
                ]
            );
        }
    }

    public function find(int $id): ?Offer
    {
        $offer = $this->db->first('offers', [
            'id' => $id,
        ]);

        if (!$offer) {
            return null;
        }

        return new Offer(
            $offer['id'],
            $offer['name'],
            $offer['description'],
            $offer['price'],
            $offer['url'],
            $offer['hash'],
            $offer['active'],
            $offer['is_admin'],
            $offer['created_at'],
        );
    }

    public function update(int $id, string $name, string $description, float $price, string $url): void
    {
        $data = [
            'name' => $name,
            'description' => $description,
            'price' => $price,
            'url' => $url,
        ];

        $this->db->update('offers', $data, [
            'id' => $id,
        ]);
    }

    public function new(): array
    {
        $offers = $this->db->get('offers', [], ['id' => 'DESC']);

        return array_map(function ($offer) {
            return new Offer(
                $offer['id'],
                $offer['name'],
                $offer['description'],
                $offer['price'],
                $offer['url'],
                $offer['hash'],
                $offer['active'],
                $offer['is_admin'],
                $offer['created_at']
            );
        }, $offers);
    }

    public function getSubscribers(int $id): array
    {
        $subscribers = $this->db->get('subscribe', [
            'offer_id' => $id
        ]);

        return array_map(function ($subscribe) {
            $offer = $this->db->first('offers', [
                'id' => $subscribe['offer_id'],
            ]);
            
            return new Subscribe(
                $subscribe['id'],
                $subscribe['user_id'],
                $subscribe['offer_id'],
                $subscribe['name'],
                $subscribe['price'],
                $subscribe['url'],
                $subscribe['hash'],
                $subscribe['active'],
                $subscribe['is_admin'],
                $subscribe['created_at'],
                $subscribe['updated_at'],
                new Offer(
                    $offer['id'],
                    $offer['name'],
                    $offer['description'],
                    $offer['price'],
                    $offer['url'],
                    $offer['active'],
                    $offer['is_admin'],
                    $offer['created_at'],
                )
            );
        }, $subscribers);
    }


    public function hash(): string
    {
        return hash('sha256', uniqid());
    }
}