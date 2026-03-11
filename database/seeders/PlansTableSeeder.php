<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Plan;

class PlansTableSeeder extends Seeder
{
    public function run()
    {
        $plans = [
            [
                'name' => 'Базовый',
                'slug' => 'basic',
                'description' => '1 конкурс в месяц',
                'contests_limit' => 1,
                'price' => 30000, // 300.00 рублей в копейках
                'currency' => 'RUB',
                'features' => ['create_contest', 'create_form', 'export_data'],
                'sort_order' => 1,
                'is_active' => true,
                'is_popular' => true,
            ],
            [
                'name' => 'Премиум',
                'slug' => 'premium',
                'description' => 'до 3 конкурсов в месяц, доступ к разделу “результаты”, доступ к разделу “статистика”',
                'contests_limit' => 3,
                'price' => 60000,
                'currency' => 'RUB',
                'features' => ['create_contest', 'create_form', 'export_data', 'api_access'],
                'sort_order' => 2,
                'is_active' => true,
                'is_popular' => false,
            ],
            [
                'name' => 'Ультра',
                'slug' => 'ultra',
                'description' => 'безлимитное количество конкурсов доступ к разделу “результаты” доступ к разделу “статистика” возможность загружать протоколы жюри',
                'contests_limit' => 999999,
                'price' => 100000,
                'currency' => 'RUB',
                'features' => ['create_contest', 'create_form', 'export_data', 'api_access'],
                'sort_order' => 2,
                'is_active' => true,
                'is_popular' => false,
            ],
        ];

        foreach ($plans as $plan) {
            Plan::updateOrCreate(
                ['slug' => $plan['slug']],
                $plan
            );
        }
    }
}