<?php

namespace Database\Factories;

use App\Models\MediaPlat;
use App\Models\Plat;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<MediaPlat>
 */
class MediaPlatFactory extends Factory
{
    protected $model = MediaPlat::class;

    public function definition(): array
    {
        return [
            'plat_id' => Plat::factory(),
            'type' => MediaPlat::TYPE_PHOTO,
            'disk' => 'public',
            'file_path' => null,
            'external_url' => null,
            'is_primary' => false,
            'sort_order' => fake()->numberBetween(0, 20),
            'caption' => fake()->optional(0.4)->sentence(),
        ];
    }

    public function video(): static
    {
        return $this->state(fn (array $attributes) => [
            'type' => MediaPlat::TYPE_VIDEO,
            'file_path' => null,
            'external_url' => fake()->randomElement([
                'https://www.youtube.com/watch?v=dQw4w9WgXcQ',
                'https://www.youtube.com/watch?v=9bZkp7q19f0',
                'https://vimeo.com/148751763',
            ]),
            'is_primary' => false,
        ]);
    }

    public function photoPrincipale(): static
    {
        return $this->state(fn (array $attributes) => [
            'type' => MediaPlat::TYPE_PHOTO,
            'is_primary' => true,
            'sort_order' => 0,
        ]);
    }
}
