<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\MediaPlat;
use App\Models\Plat;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

/**
 * Remplit catégories + plats avec des données cohérentes pour un lounge bar.
 *
 * Le compte Instagram @resto.kwetu ne publie pas le menu en accès public sans connexion,
 * donc ce catalogue est une proposition type « Resto Kwetu » (pas une copie écran par écran).
 * Les images sont téléchargées depuis Unsplash (photos réelles, licence Unsplash).
 */
class RestoKwetuCatalogueSeeder extends Seeder
{
    /**
     * @return array<int, array{name: string, type: int, description: string, image: string, plats: list<array{name: string, description: string, price: float, currency_code: string, is_featured?: bool, image: string}>}>
     */
    private function sections(): array
    {
        return [
            [
                'name' => 'Entrées & partages',
                'type' => Category::TYPE_ALIMENT,
                'description' => 'Pour commencer ou partager entre amis.',
                'image' => 'https://images.unsplash.com/photo-1546069901-ba9599a7e63c?w=900&q=80',
                'plats' => [
                    ['name' => 'Bruschetta tomate & basilic', 'description' => 'Pain grillé, tomates fraîches, basilic, huile d’olive.', 'price' => 8.5, 'currency_code' => 'USD', 'image' => 'https://images.unsplash.com/photo-1572695159919-484df746f9c9?w=900&q=80'],
                    ['name' => 'Carpaccio de bœuf', 'description' => 'Fines lamelles, roquette, copeaux de parmesan, citron.', 'price' => 12.0, 'currency_code' => 'USD', 'is_featured' => true, 'image' => 'https://images.unsplash.com/photo-1544025162-d76694265947?w=900&q=80'],
                    ['name' => 'Calamars frits', 'description' => 'Servis avec sauce ail-persil.', 'price' => 9.5, 'currency_code' => 'USD', 'image' => 'https://images.unsplash.com/photo-1599487488170-d11ec9c172f0?w=900&q=80'],
                    ['name' => 'Salade César au poulet', 'description' => 'Laitue romaine, poulet grillé, parmesan, croûtons, sauce maison.', 'price' => 10.0, 'currency_code' => 'USD', 'image' => 'https://images.unsplash.com/photo-1546793665-c74683f339c1?w=900&q=80'],
                ],
            ],
            [
                'name' => 'Grillades & viandes',
                'type' => Category::TYPE_ALIMENT,
                'description' => 'Au feu de bois et marinades maison.',
                'image' => 'https://images.unsplash.com/photo-1529692236671-f1f6cf9683ba?w=900&q=80',
                'plats' => [
                    ['name' => 'Brochettes de bœuf', 'description' => 'Marinade maison, légumes de saison.', 'price' => 16.0, 'currency_code' => 'USD', 'is_featured' => true, 'image' => 'https://images.unsplash.com/photo-1558030006-450675393462?w=900&q=80'],
                    ['name' => 'Côtelettes d’agneau aux herbes', 'description' => 'Accompagnement au choix du chef.', 'price' => 22.0, 'currency_code' => 'USD', 'image' => 'https://images.unsplash.com/photo-1603360946369-dc9bb6258143?w=900&q=80'],
                    ['name' => 'Poulet grillé miel-moutarde', 'description' => 'Cuisse et filet, sauce maison.', 'price' => 14.5, 'currency_code' => 'USD', 'image' => 'https://images.unsplash.com/photo-1598103442097-8b74394b95c6?w=900&q=80'],
                    ['name' => 'Steak 250 g sauce au poivre', 'description' => 'Pièce du boucher, frites ou purée.', 'price' => 24.0, 'currency_code' => 'USD', 'image' => 'https://images.unsplash.com/photo-1600891964092-4316c288032e?w=900&q=80'],
                ],
            ],
            [
                'name' => 'Poissons & fruits de mer',
                'type' => Category::TYPE_ALIMENT,
                'description' => 'Produits frais selon arrivage.',
                'image' => 'https://images.unsplash.com/photo-1519708227418-c8fd229a51e7?w=900&q=80',
                'plats' => [
                    ['name' => 'Poisson du jour grillé', 'description' => 'Légumes vapeur, sauce citron vert.', 'price' => 18.0, 'currency_code' => 'USD', 'is_featured' => true, 'image' => 'https://images.unsplash.com/photo-1467003909585-2f8a72700288?w=900&q=80'],
                    ['name' => 'Crevettes à l’ail', 'description' => 'Persil, beurre, pain grillé.', 'price' => 17.5, 'currency_code' => 'USD', 'image' => 'https://images.unsplash.com/photo-1565680018434-b513d5e5fd47?w=900&q=80'],
                    ['name' => 'Pavé de saumon', 'description' => 'Sauce citron-aneth, riz basmati.', 'price' => 19.0, 'currency_code' => 'USD', 'image' => 'https://images.unsplash.com/photo-1485921325833-c519f76c4927?w=900&q=80'],
                ],
            ],
            [
                'name' => 'Pizzas & snacking',
                'type' => Category::TYPE_ALIMENT,
                'description' => 'Pâte fine croustillante.',
                'image' => 'https://images.unsplash.com/photo-1513104890138-7c749659a591?w=900&q=80',
                'plats' => [
                    ['name' => 'Pizza Margherita', 'description' => 'Tomate, mozzarella, basilic frais.', 'price' => 11.0, 'currency_code' => 'USD', 'image' => 'https://images.unsplash.com/photo-1574071318508-1cdbab80d002?w=900&q=80'],
                    ['name' => 'Pizza 4 saisons', 'description' => 'Jambon, champignons, artichauts, olives.', 'price' => 13.5, 'currency_code' => 'USD', 'image' => 'https://images.unsplash.com/photo-1565299624946-b28f40a0ae38?w=900&q=80'],
                    ['name' => 'Burger maison', 'description' => 'Steak haché, cheddar, bacon, frites.', 'price' => 12.5, 'currency_code' => 'USD', 'is_featured' => true, 'image' => 'https://images.unsplash.com/photo-1568901346375-23c9450c58cd?w=900&q=80'],
                ],
            ],
            [
                'name' => 'Desserts',
                'type' => Category::TYPE_ALIMENT,
                'description' => 'Douceurs du chef.',
                'image' => 'https://images.unsplash.com/photo-1551024506-0bccc28e09af?w=900&q=80',
                'plats' => [
                    ['name' => 'Tiramisu', 'description' => 'Recette classique, cacao amer.', 'price' => 6.5, 'currency_code' => 'USD', 'image' => 'https://images.unsplash.com/photo-1571877227200-a0d98ea607e9?w=900&q=80'],
                    ['name' => 'Crème brûlée vanille', 'description' => 'Caramel croquant.', 'price' => 5.5, 'currency_code' => 'USD', 'image' => 'https://images.unsplash.com/photo-1470324161839-ce2bb6fa6bc3?w=900&q=80'],
                    ['name' => 'Brownie chocolat-noisette', 'description' => 'Glace vanille.', 'price' => 6.0, 'currency_code' => 'USD', 'image' => 'https://images.unsplash.com/photo-1606313564200-e75d5e3047d9?w=900&q=80'],
                ],
            ],
            [
                'name' => 'Cocktails & mocktails',
                'type' => Category::TYPE_BOISSON,
                'description' => 'Bar lounge — avec ou sans alcool.',
                'image' => 'https://images.unsplash.com/photo-1514362545857-3f16c26b8786?w=900&q=80',
                'plats' => [
                    ['name' => 'Mojito classique', 'description' => 'Rhum, menthe, citron vert, sucre de canne.', 'price' => 7.0, 'currency_code' => 'USD', 'is_featured' => true, 'image' => 'https://images.unsplash.com/photo-1551538827-9c037cb4f32a?w=900&q=80'],
                    ['name' => 'Caïpirinha', 'description' => 'Cachaça, citron vert, sucre.', 'price' => 7.5, 'currency_code' => 'USD', 'image' => 'https://images.unsplash.com/photo-1536935338788-846bb9981813?w=900&q=80'],
                    ['name' => 'Virgin mojito', 'description' => 'Sans alcool, tout le frais du mojito.', 'price' => 5.0, 'currency_code' => 'USD', 'image' => 'https://images.unsplash.com/photo-1544145942-f90425340c7e?w=900&q=80'],
                    ['name' => 'Piña colada (sans alcool)', 'description' => 'Ananas, coco, glace pilée.', 'price' => 5.5, 'currency_code' => 'USD', 'image' => 'https://images.unsplash.com/photo-1534353473418-4cfa6c56fd38?w=900&q=80'],
                ],
            ],
            [
                'name' => 'Bières & pressions',
                'type' => Category::TYPE_BOISSON,
                'description' => 'Sélection locale et importée.',
                'image' => 'https://images.unsplash.com/photo-1535958637004-3f5e5c7a9b3a?w=900&q=80',
                'plats' => [
                    ['name' => 'Bière locale — pression 50 cl', 'description' => 'Selon arrivage du jour.', 'price' => 3.5, 'currency_code' => 'USD', 'image' => 'https://images.unsplash.com/photo-1608270586620-248524c67de9?w=900&q=80'],
                    ['name' => 'Bière importée 33 cl', 'description' => 'Large choix au bar.', 'price' => 4.5, 'currency_code' => 'USD', 'image' => 'https://images.unsplash.com/photo-1584225064535-1a6a8e3c2b5f?w=900&q=80'],
                ],
            ],
            [
                'name' => 'Vins & bulles',
                'type' => Category::TYPE_BOISSON,
                'description' => 'Verre ou bouteille.',
                'image' => 'https://images.unsplash.com/photo-1510812431401-41d2bd2722f3?w=900&q=80',
                'plats' => [
                    ['name' => 'Verre de vin rouge', 'description' => 'Sélection maison.', 'price' => 5.0, 'currency_code' => 'USD', 'image' => 'https://images.unsplash.com/photo-1506377247377-2a5b3b417ebb?w=900&q=80'],
                    ['name' => 'Verre de vin blanc', 'description' => 'Frais et fruité.', 'price' => 5.0, 'currency_code' => 'USD', 'image' => 'https://images.unsplash.com/photo-1553361371-9b22f78e8b1d?w=900&q=80'],
                    ['name' => 'Bouteille — carte du mois', 'description' => 'Demandez la sélection au serveur.', 'price' => 28.0, 'currency_code' => 'USD', 'is_featured' => true, 'image' => 'https://images.unsplash.com/photo-1566995541428-f2246c17d1d1?w=900&q=80'],
                ],
            ],
            [
                'name' => 'Spiritueux',
                'type' => Category::TYPE_BOISSON,
                'description' => 'Servis au comptoir.',
                'image' => 'https://images.unsplash.com/photo-1470337458703-46ad1756a187?w=900&q=80',
                'plats' => [
                    ['name' => 'Rhum vieux — 4 cl', 'description' => 'Sélection bar.', 'price' => 6.0, 'currency_code' => 'USD', 'image' => 'https://images.unsplash.com/photo-1614313511387-1432a78d1b8c?w=900&q=80'],
                    ['name' => 'Whisky premium — 4 cl', 'description' => 'Selon disponibilité.', 'price' => 9.0, 'currency_code' => 'USD', 'image' => 'https://images.unsplash.com/photo-1527281400683-1aae777175f8?w=900&q=80'],
                ],
            ],
            [
                'name' => 'Jus & softs',
                'type' => Category::TYPE_BOISSON,
                'description' => 'Rafraîchissements.',
                'image' => 'https://images.unsplash.com/photo-1437418747212-8d9709af91dc?w=900&q=80',
                'plats' => [
                    ['name' => 'Jus d’orange frais', 'description' => 'Pressé du jour.', 'price' => 3.0, 'currency_code' => 'USD', 'image' => 'https://images.unsplash.com/photo-1621506289937-a8e4df240d0b?w=900&q=80'],
                    ['name' => 'Soda 33 cl', 'description' => 'Coca, Fanta, Sprite…', 'price' => 2.5, 'currency_code' => 'USD', 'image' => 'https://images.unsplash.com/photo-1554866585-cd94860890b7?w=900&q=80'],
                    ['name' => 'Eau minérale 50 cl', 'description' => 'Plate ou gazeuse.', 'price' => 1.5, 'currency_code' => 'USD', 'image' => 'https://images.unsplash.com/photo-1548839140-29a749e1cf4d?w=900&q=80'],
                ],
            ],
        ];
    }

    public function run(): void
    {
        MediaPlat::query()->delete();
        Plat::query()->forceDelete();
        Category::query()->delete();

        $ordreCat = 0;
        foreach ($this->sections() as $section) {
            $slugCat = Str::slug($section['name']);
            $cheminImageCat = $this->telechargerImage($section['image'], 'categories/'.$slugCat.'.jpg');

            $categorie = Category::create([
                'name' => $section['name'],
                'slug' => $slugCat.'-'.$ordreCat,
                'description' => $section['description'],
                'image_path' => $cheminImageCat,
                'type' => $section['type'],
                'sort_order' => $ordreCat,
                'is_active' => true,
            ]);

            $ordrePlat = 0;
            foreach ($section['plats'] as $p) {
                $slugPlat = Str::slug($p['name']).'-'.$categorie->id.'-'.$ordrePlat;
                $plat = Plat::create([
                    'category_id' => $categorie->id,
                    'name' => $p['name'],
                    'slug' => $slugPlat,
                    'description' => $p['description'],
                    'price' => $p['price'],
                    'currency_code' => $p['currency_code'],
                    'promo_price' => null,
                    'is_available' => true,
                    'is_featured' => (bool) ($p['is_featured'] ?? false),
                    'is_new' => false,
                    'preparation_minutes' => $section['type'] === Category::TYPE_BOISSON ? 5 : 20,
                    'sku' => null,
                    'allergens' => [],
                    'dietary_tags' => [],
                    'tva_rate' => null,
                    'sort_order' => $ordrePlat,
                ]);

                $cheminPlat = $this->telechargerImage($p['image'], 'medias-plats/kwetu/'.$plat->id.'.jpg');
                if ($cheminPlat !== null) {
                    MediaPlat::create([
                        'plat_id' => $plat->id,
                        'type' => MediaPlat::TYPE_PHOTO,
                        'file_path' => $cheminPlat,
                        'external_url' => null,
                        'is_primary' => true,
                        'sort_order' => 0,
                        'caption' => $p['name'],
                    ]);
                }

                $ordrePlat++;
            }

            $ordreCat++;
        }

        $this->command?->info('Catalogue Resto Kwetu : '.$ordreCat.' catégories, plats et images importés.');
    }

    private function telechargerImage(string $url, string $cheminRelatif): ?string
    {
        try {
            $reponse = Http::timeout(45)
                ->withHeaders(['Accept' => 'image/*'])
                ->get($url);

            if (! $reponse->successful()) {
                return null;
            }

            $corps = $reponse->body();
            if (strlen($corps) < 2000) {
                return null;
            }

            Storage::disk('public')->put($cheminRelatif, $corps);

            return $cheminRelatif;
        } catch (\Throwable) {
            return null;
        }
    }
}
