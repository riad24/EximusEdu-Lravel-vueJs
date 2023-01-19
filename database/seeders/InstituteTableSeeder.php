<?php
namespace Database\Seeders;

use App\Enums\Status;
use App\Models\Institute;
use Illuminate\Database\Seeder;


class InstituteTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Institute::create(
            [
            'name'              => 'Institute One',
            'slug'              => 'institute_one',
            'email'             => 'institute@example.com',
            'phone'             => '012548985',
            'description'       => 'institute one',
            'status'             => Status::ACTIVE,
        ]
        );
        Institute::create(
            [
                'name'              => 'Institute Two',
                'slug'              => 'institute_two',
                'email'             => 'institutetwo@example.com',
                'phone'             => '0125489855',
                'description'       => 'institute two',
                'status'             => Status::ACTIVE,
            ]
        );

    }
}
