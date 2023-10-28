<?php

namespace App\Services;

use App\Models\Offer;
use App\Models\Subscribe;
use App\Kernel\Auth\Auth;
use App\Kernel\Database\Database;

class OfferService
{
    public function __construct(
        private Database $db,
        private Auth $auth
    ) {
    }

    public function store(int $user_id, string $name, string $description, float $price, string $url): false|int
    {
        return $this->db->insert('offers', [
            'user_id' => $user_id,
            'name' => $name,
            'description' => $description,
            'price' => $price,
            'url' => $url,
        ]);
    }

    public function subscribe(int $user_id, int $offer_id, $name, $price, $url): false|int
    {
        // dd($this);
        $subscribe = $this->db::dispense('subscribe');
        $subscribe->user_id = $user_id;
        $subscribe->offer_id = $offer_id;
        $subscribe->name = $name;
        $subscribe->price = $price;
        $subscribe->url = $url;
        $subscribe->hash = $this->hash();

        return $this->db::store($subscribe);
    }

    public function all(): array
    {
        $offers = $this->db->get('offers');

        return array_map(function ($offer) {
            return new Offer(
                $offer['id'],
                $offer['name'],
                $offer['description'],
                $offer['price'],
                $offer['url'],
                $offer['active'],
                $offer['is_admin'],
                $offer['created_at'],
                $this->getSubscribers($offer['id'] ?? null)
            );
        }, $offers);
    }

    public function allUser(int $id): array
    {
        $offers = $this->db->get('offers', [
            'user_id' => $id,
            'is_admin' => 0
        ]);

        return array_map(function ($offer) {
            return new Offer(
                $offer['id'],
                $offer['name'],
                $offer['description'],
                $offer['price'],
                $offer['url'],
                $offer['active'],
                $offer['is_admin'],
                $offer['created_at'],
                $this->getSubscribers($offer['id'] ?? null)
            );
        }, $offers);
    }

    public function arhive(): array
    {
        $offers = $this->db->get('offers', [
            'active' => 0,

        ]);

        return array_map(function ($offer) {
            return new Offer(
                $offer['id'],
                $offer['name'],
                $offer['description'],
                $offer['price'],
                $offer['url'],
                $offer['active'],
                $offer['is_admin'],
                $offer['created_at'],
            );
        }, $offers);
    }

    public function destroy(int $id): void
    {
        $this->db->delete('offers', [
            'id' => $id,
        ]);
    }

    public function zip(string $table, int $id): void
    {
        $is_admin = $this->auth->user()->role() === 'admin' ? 1 : 0;
        die(
            json_encode(
                $this->db->update(
                    $table,
                    [
                        'active' => 0,
                        'is_admin' => $is_admin
                    ],
                    [
                        'id' => $id,
                    ]
                )
            )
        );
    }

    public function unzip(string $table, int $id): void
    {
        if ($this->auth->user()->role() === 'admin') {
            die(
                json_encode(
                    $this->db->update(
                        $table,
                        [
                            'active' => 1,
                            'is_admin' => 0
                        ],
                        [
                            'id' => $id,
                        ]
                    )
                )
            );
        } else {
            die(
                json_encode(
                    $this->db->update(
                        $table,
                        [
                            'active' => 1,
                        ],
                        [
                            'id' => $id,
                        ]
                    )
                )
            );
        }
    }

    public function find(int $id): ?Offer
    {
        $offer = $this->db::findOne('offers', 'id = ?', [$id]);

        if (!$offer) {
            return null;
        }

        return new Offer(
            $offer['id'],
            $offer['name'],
            $offer['description'],
            $offer['price'],
            $offer['url'],
            $offer['active'],
            $offer['is_admin'],
            $offer['created_at'],
            $this->getSubscribers($id)
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
            $subscribers = $this->db->get('subscribe', ['id' => $offer['id']]);
            return new Offer(
                $offer['id'],
                $offer['name'],
                $offer['description'],
                $offer['price'],
                $offer['url'],
                $offer['active'],
                $offer['is_admin'],
                $offer['created_at'],
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