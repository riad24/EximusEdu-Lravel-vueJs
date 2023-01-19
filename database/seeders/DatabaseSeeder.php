<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;


class DatabaseSeeder extends Seeder
{

    public function run()
    {
        $this->call(MenuTableSeeder::class);
        $this->call(PermissionTableSeeder::class);
        $this->call(RoleTableSeeder::class);
        $this->call(RolePermissionTableSeeder::class);
        $this->call(UserTableSeeder::class);
        $this->call(InstituteTableSeeder::class);
    }
}
