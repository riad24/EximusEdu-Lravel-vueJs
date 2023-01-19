<?php

namespace Database\Seeders;

use App\Libraries\AppLibrary;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permissions = [
            [
                'title'      => 'Dashboard',
                'name'       => 'dashboard',
                'guard_name' => 'sanctum',
                'url'        => 'dashboard',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title'      => 'Institutes',
                'name'       => 'institutes',
                'guard_name' => 'sanctum',
                'url'        => 'institutes',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title'      => 'Students',
                'name'       => 'students',
                'guard_name' => 'sanctum',
                'url'        => 'students',
                'created_at' => now(),
                'updated_at' => now(),
            ],


            [
                'title'      => 'Fields',
                'name'       => 'fields',
                'guard_name' => 'sanctum',
                'url'        => 'fields',
                'created_at' => now(),
                'updated_at' => now(),

            ],

        ];

        $permissions = AppLibrary::associativeToNumericArrayBuilder($permissions);
        Permission::insert($permissions);
    }
}
