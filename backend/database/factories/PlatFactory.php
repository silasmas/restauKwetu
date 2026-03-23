<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Plat;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Plat>
 */
class PlatFactory extends Factory
{
    protected $model = Plat::class;

    public function definition(): array
    {
        $name = fake()->words(rand(2, 5), true);

        $allergenPool = ['gluten', 'lactose', 'œufs', 'arachides', 'soja', 'fruits à coque', 'sésame', 'poisson', 'crustacés'];
        $dietPool = ['végétarien', 'vegan', 'sans gluten', 'halal', 'épicé'];

        return [
            'category_id' => Category::query()->inRandomOrder()->value('id') ?? Category::factory(),
            'name' => ucfirst($name),
            'slug' => Str::slug($name).'-'.fake()->unique()->bothify('????##'),
            'description' => fake()->optional(0.85)->paragraphs(rand(1, 3), true),
            'price' => fake()->randomFloat(2, 4, 85),
            'currency_code' => fake()->randomElement(['EUR', 'USD', 'CDF']),
            'promo_price' => fake()->optional(0.25)->randomFloat(2, 3, 40),
            'is_available' => fake()->boolean(88),
            'is_featured' => fake()->boolean(12),
            'is_new' => fake()->boolean(15),
            'preparation_minutes' => fake()->optional(0.7)->numberBetween(5, 55),
            'sku' => fake()->optional(0.6)->bothify('SKU-####-??'),
            'allergens' => fake()->optional(0.5, [])->randomElements($allergenPool, fake()->numberBetween(0, 3)),
            'dietary_tags' => fake()->optional(0.35, [])->randomElements($dietPool, fake()->numberBetween(0, 2)),
            'tva_rate' => fake()->optional(0.8)->randomElement([5.5, 10.0, 20.0]),
            'sort_order' => fake()->numberBetween(0, 500),
        ];
    }
}
