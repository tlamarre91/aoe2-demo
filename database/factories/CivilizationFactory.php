<?php

namespace Database\Factories;

use App\Models\Civilization;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class CivilizationFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Civilization::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name,
        ];
    }
}

