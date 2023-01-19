<?php
namespace Database\Seeders;

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
        Institute::factory()->count(25)->create();
    }
}
