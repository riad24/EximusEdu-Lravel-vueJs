<?php

namespace Database\Seeders;

use App\Libraries\AppLibrary;
use App\Models\Menu;
use Illuminate\Database\Seeder;


class MenuTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $menus = [
            [
                'name'       => 'dashboard',
                'url'        => 'dashboard',
                'icon'       => 'fas fa-laptop',
                'priority'   => 100,
                'status'     => 1,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name'       => 'institutes',
                'url'        => 'institutes',
                'icon'       => 'fas fa-laptop',
                'priority'   => 100,
                'status'     => 1,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name'       => 'students',
                'url'        => 'students',
                'icon'       => 'fas fa-laptop',
                'priority'   => 100,
                'status'     => 1,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name'       => 'fields',
                'url'        => 'fields',
                'icon'       => 'fas fa-laptop',
                'priority'   => 100,
                'status'     => 1,
                'created_at' => now(),
                'updated_at' => now()
            ],
        ];

        Menu::insert(AppLibrary::associativeToNumericArrayBuilder($menus));
    }
}
