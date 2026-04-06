<?php

namespace App\Filament\Widgets;

use App\Models\Category;
use App\Models\MediaPlat;
use App\Models\Plat;
use App\Models\Restaurant;
use App\Models\User;
use Filament\Support\Icons\Heroicon;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Facades\DB;

class RestauKwetuStatsOverview extends StatsOverviewWidget
{
    protected static ?int $sort = -20;

    protected ?string $heading = 'Indicateurs Resto Kwetu';

    protected ?string $description = 'Synthèse du catalogue, de la carte client et des comptes d’administration.';

    protected int | string | array $columnSpan = 'full';

    /**
     * @return array<Stat>
     */
    protected function getStats(): array
    {
        $totalCategories = Category::query()->count();
        $categoriesActives = Category::query()->where('is_active', true)->count();
        $categoriesAliments = Category::query()->where('type', Category::TYPE_ALIMENT)->count();
        $categoriesBoissons = Category::query()->where('type', Category::TYPE_BOISSON)->count();

        $totalPlats = Plat::query()->count();
        $platsDisponibles = Plat::query()->where('is_available', true)->count();
        $platsUne = Plat::query()->where('is_featured', true)->count();
        $platsNouveaux = Plat::query()->where('is_new', true)->count();
        $platsPromo = Plat::query()->whereNotNull('promo_price')->count();
        $platsCorbeille = Plat::onlyTrashed()->count();

        $totalMedias = (int) DB::table('medias_plats')->count();
        $mediasPhotos = (int) DB::table('medias_plats')->where('type', MediaPlat::TYPE_PHOTO)->count();
        $mediasVideos = (int) DB::table('medias_plats')->where('type', MediaPlat::TYPE_VIDEO)->count();

        $fichesRestaurant = Restaurant::query()->count();
        $comptesUtilisateurs = User::query()->count();

        return [
            Stat::make('Catégories (total)', $totalCategories)
                ->description(sprintf(
                    '%d actives sur la carte publique · %d sections aliments · %d boissons',
                    $categoriesActives,
                    $categoriesAliments,
                    $categoriesBoissons
                ))
                ->descriptionIcon(Heroicon::OutlinedRectangleStack)
                ->color('primary'),

            Stat::make('Plats au catalogue', $totalPlats)
                ->description(sprintf(
                    '%d disponibles à la vente · %d à la une · %d nouveautés · %d en promo · %d en corbeille (supprimés)',
                    $platsDisponibles,
                    $platsUne,
                    $platsNouveaux,
                    $platsPromo,
                    $platsCorbeille
                ))
                ->descriptionIcon(Heroicon::OutlinedFire)
                ->color('success'),

            Stat::make('Médias des plats', $totalMedias)
                ->description(sprintf('%d photos · %d vidéos (fichier et/ou lien externe)', $mediasPhotos, $mediasVideos))
                ->descriptionIcon(Heroicon::OutlinedPhoto)
                ->color('warning'),

            Stat::make('Fiches restaurant', $fichesRestaurant)
                ->description('En-tête, coordonnées et paramètres affichés côté site.')
                ->descriptionIcon(Heroicon::OutlinedBuildingStorefront)
                ->color('gray'),

            Stat::make('Comptes admin', $comptesUtilisateurs)
                ->description('Utilisateurs pouvant se connecter au panneau Filament.')
                ->descriptionIcon(Heroicon::OutlinedUserGroup)
                ->color('gray'),
        ];
    }
}
