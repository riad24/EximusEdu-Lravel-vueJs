<?php

namespace Database\Factories;

use App\Enums\Status;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class InstituteFactory extends Factory
{
    public function definition() : array
    {
        return [
            'name'            => $this->faker->bothify('?###??##'),
            'email'           => $this->faker->unique()->safeEmail(),
            'phone'           => $this->faker->unique()->phoneNumber(),
            'slug'            => Str::slug($this->faker->unique()->name),
            'status'          => Status::ACTIVE,
            'description'     => null
        ];
    }
}
