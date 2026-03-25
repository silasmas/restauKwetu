<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Category>
 */
class CategoryFactory extends Factory
{
    protected $model = Category::class;

    public function definition(): array
    {
        $label = fake()->unique()->numerify('Carte ###');

        return [
            'name' => $label,
            'slug' => Str::slug($label).'-'.fake()->unique()->bothify('??##'),
            'description' => fake()->optional(0.7)->sentence(12),
            'image_path' => null,
            'type' => fake()->randomElement([Category::TYPE_ALIMENT, Category::TYPE_BOISSON]),
            'sort_order' => fake()->numberBetween(0, 500),
            'is_active' => fake()->boolean(92),
        ];
    }
}
