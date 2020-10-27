<?php

namespace Database\Factories;

use App\Models\Bookmark;
use App\Models\Meta;
use Illuminate\Database\Eloquent\Factories\Factory;

class MetaFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Meta::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'title' => $this->faker->words(rand(2, 4), true),
            'description' => $this->faker->words(rand(4, 8), true),
            'keywords' => mb_strtolower($this->faker->words(rand(4, 8), true)),
            'bookmark_id' => Bookmark::factory(),
        ];
    }
}
