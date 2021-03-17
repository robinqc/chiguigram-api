<?php

namespace Database\Factories;

use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class PostFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Post::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $users = User::all()->pluck('id');
        $images = [];
        for ($index = 0; $index <= $this->faker->randomDigitNotNull(); $index++) {
            array_push($images, $this->faker->imageUrl(1280, 720));
        }
        return [
            'user_id' => $this->faker->randomElement($users),
            'content' => $this->faker->text(),
            'images' => json_encode($images, JSON_UNESCAPED_SLASHES),
            'likes' => 0,
        ];
    }
}
