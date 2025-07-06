<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Service;

class ServiceSeeder extends Seeder
{
    public function run()
    {
        $services = [
            [
                'name' => 'Deep Cleaning',
                'description' => 'Sepatu Olahraga, Dan Sepatu Bot',
                'price' => 35000,
                'duration_hours' => 24,
            ],
            [
                'name' => 'Deep Cleaning',
                'description' => 'Sepatu Sneakers',
                'price' => 30000,
                'duration_hours' => 24,
            ],
            [
                'name' => 'Deep Cleaning',
                'description' => 'Sepatu Kulit/Formal',
                'price' => 40000,
                'duration_hours' => 24,
            ],
            [
                'name' => 'Fast Cleaning',
                'description' => 'Sepatu Olahraga, Dan Sepatu Bot',
                'price' => 30000,
                'duration_hours' => 12,
            ],
            [
                'name' => 'Fast Cleaning',
                'description' => 'Sepatu Sneakers',
                'price' => 25000,
                'duration_hours' => 12,
            ],
            [
                'name' => 'Fast Cleaning',
                'description' => 'Sepatu Kulit/Formal',
                'price' => 35000,
                'duration_hours' => 12,
            ],
            [
                'name' => 'Unyellowing Shoes',
                'description' => 'Mengembalikan warna sepatu yang menguning',
                'price' => 25000,
                'duration_hours' => 12,
            ],
            [
                'name' => 'Promotion 3 Deep Cleaning',
                'description' => 'Cuci 3 Sepatu Deep Cleaning',
                'price' => 85000,
                'duration_hours' => 24,
            ],
            [
                'name' => 'Promotion 5 in 1',
                'description' => 'Cuci 5x Sepatu Gratis 1',
                'price' => 150000,
                'duration_hours' => 24,
            ],
        ];

        foreach ($services as $service) {
            Service::create($service);
        }
    }
}