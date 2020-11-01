<?php

namespace Database\Factories;

use App\Models\Bookmark;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\Factories\Factory;

class BookmarkFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Bookmark::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'title' => $this->faker->unique()->words(rand(2, 4), true),
            'url' => $this->faker->unique()->url(),
            'password_to_delete' => Hash::make($this->faker->password()),
            'favicon' => config('bookmarks.images.default'),
        ];
    }
}
