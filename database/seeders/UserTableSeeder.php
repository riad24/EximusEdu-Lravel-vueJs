<?php

namespace Database\Seeders;

use App\Enums\Role as EnumRole;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $admin = User::create([
            'name'              => 'John Doe',
            'email'             => 'admin@example.com',
            'username'          => 'admin',
            'email_verified_at' => now(),
            'password'          => bcrypt('123456'),
        ]);
        $admin->assignRole(EnumRole::ADMIN);
    }
}
