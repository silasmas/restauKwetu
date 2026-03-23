<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\MediaPlat;
use App\Models\Plat;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

class RestaurantMenuSeeder extends Seeder
{
    private const NOMBRE_PLATS = 220;

    public function run(): void
    {
        $jpeg = $this->octetsImagePlaceholder();

        $categories = Category::factory()
            ->count(25)
            ->create();

        foreach (range(1, self::NOMBRE_PLATS) as $index) {
            Plat::factory()->create([
                'category_id' => $categories->random()->id,
                'sort_order' => $index,
            ]);
        }

        Plat::query()->orderBy('id')->each(function (Plat $plat) use ($jpeg): void {
            $dir = 'medias-plats/initial/'.$plat->id;
            $cheminPrincipal = $dir.'/principale.jpg';
            Storage::disk('public')->put($cheminPrincipal, $jpeg);

            MediaPlat::factory()
                ->for($plat)
                ->photoPrincipale()
                ->create([
                    'file_path' => $cheminPrincipal,
                    'caption' => fake()->optional(0.35)->words(3, true),
                ]);

            $nbGalerie = fake()->numberBetween(0, 3);
            for ($g = 0; $g < $nbGalerie; $g++) {
                $chemin = $dir.'/galerie-'.$g.'.jpg';
                Storage::disk('public')->put($chemin, $jpeg);

                MediaPlat::factory()
                    ->for($plat)
                    ->create([
                        'type' => MediaPlat::TYPE_PHOTO,
                        'file_path' => $chemin,
                        'is_primary' => false,
                        'sort_order' => $g + 1,
                        'caption' => fake()->optional(0.25)->sentence(),
                    ]);
            }

            if (fake()->boolean(18)) {
                MediaPlat::factory()
                    ->for($plat)
                    ->video()
                    ->create([
                        'sort_order' => 50 + $nbGalerie,
                    ]);
            }
        });
    }

    private function octetsImagePlaceholder(): string
    {
        try {
            $response = Http::timeout(20)
                ->withHeaders(['Accept' => 'image/jpeg'])
                ->get('https://picsum.photos/seed/restaukwetu-seed/400/300');

            $corps = $response->body();
            if ($response->successful() && str_starts_with($corps, "\xFF\xD8\xFF") && strlen($corps) > 500) {
                return $corps;
            }
        } catch (\Throwable) {
        }

        return self::jpegMinimal();
    }

    private static function jpegMinimal(): string
    {
        return base64_decode(
            '/9j/4AAQSkZJRgABAQEASABIAAD/2wBDAP//////////////////////////////////////////////////////////////////////////////////////2wBDAf//////////////////////////////////////////////////////////////////////////////////////wAARCABAAEADASIAAhEBAxEB/8QAFQABAQAAAAAAAAAAAAAAAAAAAAX/xAAUEAEAAAAAAAAAAAAAAAAAAAAA/8QAFQEBAQAAAAAAAAAAAAAAAAAAAAX/xAAUEQEAAAAAAAAAAAAAAAAAAAAA/9oADAMBAAIRAxEAPwCwAB8A/9k=',
            true
        ) ?: '';
    }
}
