<?php

namespace Database\Factories;

use App\Models\Pet;
use App\Models\User;
use App\Models\Type;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Pet>
 */
class PetFactory extends Factory
{
    protected $model = Pet::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'type_id' => Type::factory(),
            'user_id' => User::factory(),
            'phone' => $this->faker->phoneNumber(),
        ];
    }
}
