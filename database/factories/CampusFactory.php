<?php

namespace Database\Factories;

use App\Models\Campus;
use App\Models\School;
use Illuminate\Database\Eloquent\Factories\Factory;

class CampusFactory extends Factory
{
    protected $model = Campus::class;

    public function definition(): array
    {
        return [
            'school_id' => School::factory(),
            'name' => $this->faker->city . ' Campus',
            'address' => $this->faker->address,
            'phone' => $this->faker->phoneNumber,
            'email' => $this->faker->unique()->safeEmail,
            'is_main' => false,
            'is_active' => true,
        ];
    }
}
