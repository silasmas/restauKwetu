<?php

namespace App\Filament\Widgets;

use App\Models\Category;
use App\Models\Plat;
use App\Support\RestauKwetuUrls;
use Filament\Widgets\Widget;

class RestauKwetuDetailWidget extends Widget
{
    protected static ?int $sort = -15;

    protected string $view = 'filament.widgets.restau-kwetu-detail';

    protected int | string | array $columnSpan = 'full';

    /**
     * @return array<string, mixed>
     */
    protected function getViewData(): array
    {
        $parCategorie = Category::query()
            ->withCount([
                'plats as plats_total',
                'plats as plats_disponibles' => fn ($q) => $q->where('is_available', true),
            ])
            ->orderBy('sort_order')
            ->get()
            ->map(fn (Category $c) => [
                'nom' => $c->name,
                'slug' => $c->slug,
                'active' => (bool) $c->is_active,
                'plats_total' => (int) $c->plats_total,
                'plats_disponibles' => (int) $c->plats_disponibles,
            ])
            ->all();

        $sansCategorie = Plat::query()->whereNull('category_id')->count();

        $racine = RestauKwetuUrls::requestRoot();

        return [
            'parCategorie' => $parCategorie,
            'sansCategorie' => $sansCategorie,
            'endpointMenu' => $racine.'/api/v1/menu',
            'endpointCategories' => $racine.'/api/v1/categories',
            'endpointPlats' => $racine.'/api/v1/plats',
        ];
    }
}
