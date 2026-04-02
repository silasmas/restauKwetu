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
 * Catalogue aligné sur les menus officiels Resto Kwetu (plats + boissons, avril 2026).
 * Prix en USD selon l’équivalent indiqué sur la carte (colonne « K »).
 */
class RestoKwetuCatalogueSeeder extends Seeder
{
    private const U_EAU = 'https://images.unsplash.com/photo-1548839140-29a749e1cf4d?w=900&q=80';

    private const U_JUS = 'https://images.unsplash.com/photo-1621506289937-a8e4df240d0b?w=900&q=80';

    private const U_SODA = 'https://images.unsplash.com/photo-1554866585-cd94860890b7?w=900&q=80';

    private const U_BIERE = 'https://images.unsplash.com/photo-1608270586620-248524c67de9?w=900&q=80';

    private const U_COCKTAIL = 'https://images.unsplash.com/photo-1551538827-9c037cb4f32a?w=900&q=80';

    private const U_CAFE = 'https://images.unsplash.com/photo-1495474476917-bfedf931695c?w=900&q=80';

    private const U_VIN_ROUGE = 'https://images.unsplash.com/photo-1506377247377-2a5b3b417ebb?w=900&q=80';

    private const U_VIN_BLANC = 'https://images.unsplash.com/photo-1553361371-9b22f78e8b1d?w=900&q=80';

    private const U_ROSE = 'https://images.unsplash.com/photo-1510812431401-41d2bd2722f3?w=900&q=80';

    private const U_CHAMP = 'https://images.unsplash.com/photo-1566995541428-f2246c17d1d1?w=900&q=80';

    private const U_LIQUEUR = 'https://images.unsplash.com/photo-1614313511387-1432a78d1b8c?w=900&q=80';

    private const U_WHISKY = 'https://images.unsplash.com/photo-1527281400683-1aae777175f8?w=900&q=80';

    /**
     * @return array<int, array{name: string, type: int, description: string, image: string, plats: list<array{name: string, description: string, price: float, currency_code: string, is_featured?: bool, image: string}>}>
     */
    private function sections(): array
    {
        return [
            [
                'name' => 'Entrées',
                'type' => Category::TYPE_ALIMENT,
                'description' => 'Entrées froides et assiettes à partager pour commencer.',
                'image' => 'https://images.unsplash.com/photo-1546069901-ba9599a7e63c?w=900&q=80',
                'plats' => [
                    [
                        'name' => 'Duo Mpose Ndakala',
                        'description' => 'Assiette à partager : Mpose (poisson fumé ou séché, selon arrivage) et Ndakala (petits poissons), présentation gourmande façon Kwetu.',
                        'price' => 23.0,
                        'currency_code' => 'USD',
                        'is_featured' => true,
                        'image' => 'https://images.unsplash.com/photo-1467003909585-2f8a72700288?w=900&q=80',
                    ],
                    [
                        'name' => 'Terrine de Mbika',
                        'description' => 'Terrine onctueuse à base de graines de courge (mbika), épices douces et touche authentique du terroir.',
                        'price' => 23.0,
                        'currency_code' => 'USD',
                        'image' => 'https://images.unsplash.com/photo-1604908176997-125f25cc6f3d?w=900&q=80',
                    ],
                    [
                        'name' => 'Plateau de charcuterie Kwetu',
                        'description' => 'Sélection de charcuteries et accompagnements maison, idéal à partager en apéritif.',
                        'price' => 20.0,
                        'currency_code' => 'USD',
                        'image' => 'https://images.unsplash.com/photo-1603048297172-c92544798d5a?w=900&q=80',
                    ],
                    [
                        'name' => 'Avocat et crevette, variation en tartare',
                        'description' => 'Avocat crémeux, crevettes en petits dés, citron vert, herbes fraîches — version tartare légère.',
                        'price' => 23.0,
                        'currency_code' => 'USD',
                        'image' => 'https://images.unsplash.com/photo-1544025162-d76694265947?w=900&q=80',
                    ],
                ],
            ],
            [
                'name' => 'Plats — Le Terroir (signature du chef)',
                'type' => Category::TYPE_ALIMENT,
                'description' => 'Signatures du chef autour des produits locaux. Accompagnements au choix inclus (riz, fufu, banane plantain, etc.) — demandez la carte des inclus au service.',
                'image' => 'https://images.unsplash.com/photo-1529692236671-f1f6cf9683ba?w=900&q=80',
                'plats' => [
                    [
                        'name' => 'Poulet fermier, jus lumba-lumba',
                        'description' => 'Poulet fermier rôti ou mijoté, nappé d’un jus lumba-lumba (base tomate et piments) typique du Congo.',
                        'price' => 26.0,
                        'currency_code' => 'USD',
                        'is_featured' => true,
                        'image' => 'https://images.unsplash.com/photo-1598103442097-8b74394b95c6?w=900&q=80',
                    ],
                    [
                        'name' => 'Chèvre façon Kabewu & Bia Munda',
                        'description' => 'Viande de chèvre longuement mijotée aux saveurs Kabewu et Bia Munda, recettes du terroir.',
                        'price' => 35.0,
                        'currency_code' => 'USD',
                        'image' => 'https://images.unsplash.com/photo-1544027885-9e29a0adfdb2?w=900&q=80',
                    ],
                    [
                        'name' => 'Médaillon de poisson Kamba en Liboke',
                        'description' => 'Médaillons de Kamba (perche du fleuve) cuits en feuille de bananier (liboke), aromates et jus de cuisson parfumé.',
                        'price' => 35.0,
                        'currency_code' => 'USD',
                        'is_featured' => true,
                        'image' => 'https://images.unsplash.com/photo-1519708227418-c8fd229a51e7?w=900&q=80',
                    ],
                    [
                        'name' => 'Mboto mi-fumé, boulettes de Mbika farcies',
                        'description' => 'Mboto (poisson) demi-fumé, servi avec boulettes de pâte de mbika garnies — alliance fumé et onctuosité.',
                        'price' => 35.0,
                        'currency_code' => 'USD',
                        'image' => 'https://images.unsplash.com/photo-1467003909585-2f8a72700288?w=900&q=80',
                    ],
                ],
            ],
            [
                'name' => 'Plats — Nos poissons',
                'type' => Category::TYPE_ALIMENT,
                'description' => 'Poissons d’eau douce et sauces maison.',
                'image' => 'https://images.unsplash.com/photo-1519708227418-c8fd229a51e7?w=900&q=80',
                'plats' => [
                    [
                        'name' => 'Pavé de Zanda, coulis de tomates et Mossaka raffiné',
                        'description' => 'Pavé de Zanda (poisson d’eau douce), coulis de tomates et mossaka (mijoté de légumes) travaillé en version raffinée.',
                        'price' => 35.0,
                        'currency_code' => 'USD',
                        'image' => 'https://images.unsplash.com/photo-1485921325833-c519f76c4927?w=900&q=80',
                    ],
                    [
                        'name' => 'Dos de capitaine de Moanda, réduction de gingembre frais',
                        'description' => 'Dos de capitaine, sauce réduite au gingembre frais, équilibre entre puissance du poisson et fraîcheur épicée.',
                        'price' => 35.0,
                        'currency_code' => 'USD',
                        'is_featured' => true,
                        'image' => 'https://images.unsplash.com/photo-1534604973900-c43ab4c2e0ab?w=900&q=80',
                    ],
                ],
            ],
            [
                'name' => 'Plats — Nos volailles',
                'type' => Category::TYPE_ALIMENT,
                'description' => 'Volailles grillées au feu et volaille fumée maison.',
                'image' => 'https://images.unsplash.com/photo-1598103442097-8b74394b95c6?w=900&q=80',
                'plats' => [
                    [
                        'name' => 'Poussin grillé sur braise aromatique',
                        'description' => 'Jeune poulet entier grillé sur braise, marinades aux herbes et épices.',
                        'price' => 34.0,
                        'currency_code' => 'USD',
                        'image' => 'https://images.unsplash.com/photo-1608039829572-78524f79cacc?w=900&q=80',
                    ],
                    [
                        'name' => 'Poulet fumé, velouté à l’arachide',
                        'description' => 'Poulet fumé maison, sauce veloutée à la cacahuète (arachide), onctueux et fumé.',
                        'price' => 34.0,
                        'currency_code' => 'USD',
                        'is_featured' => true,
                        'image' => 'https://images.unsplash.com/photo-1626082927389-6cd097cdc6ec?w=900&q=80',
                    ],
                ],
            ],
            [
                'name' => 'Plats — Nos viandes fumées',
                'type' => Category::TYPE_ALIMENT,
                'description' => 'Mijotés de bœuf, porc Sombo ou antilope Mboloko, sauces épicées.',
                'image' => 'https://images.unsplash.com/photo-1558030006-450675393462?w=900&q=80',
                'plats' => [
                    [
                        'name' => 'Bœuf aux gombos',
                        'description' => 'Mijoté de bœuf fondant aux gombos, sauce légumineuse et épicée comme à la maison.',
                        'price' => 30.0,
                        'currency_code' => 'USD',
                        'image' => 'https://images.unsplash.com/photo-1547592166-23ac45744acd?w=900&q=80',
                    ],
                    [
                        'name' => 'Sombo (porc) ou Mboloko (antilope), jus épicé',
                        'description' => 'Au choix : porc Sombo ou viande d’antilope Mboloko, servi avec un jus de viande épicé et parfumé.',
                        'price' => 35.0,
                        'currency_code' => 'USD',
                        'image' => 'https://images.unsplash.com/photo-1600891964092-4316c288032e?w=900&q=80',
                    ],
                ],
            ],
            [
                'name' => 'Plats — Nos viandes d’exception',
                'type' => Category::TYPE_ALIMENT,
                'description' => 'Grills et pièces nobles, cuissons précises.',
                'image' => 'https://images.unsplash.com/photo-1600891964092-4316c288032e?w=900&q=80',
                'plats' => [
                    [
                        'name' => 'Côtelettes d’agneau, cuisson sur grille',
                        'description' => 'Côtelettes d’agneau grillées, rosé à cœur possible, jus court ou beurre aromatisé selon service.',
                        'price' => 45.0,
                        'currency_code' => 'USD',
                        'image' => 'https://images.unsplash.com/photo-1603360946369-dc9bb6258143?w=900&q=80',
                    ],
                    [
                        'name' => 'Steak tomahawk, réduction aromatique',
                        'description' => 'Imposante entrecôte avec os long, grillée, sauce réduite aux aromates — partage recommandé.',
                        'price' => 65.0,
                        'currency_code' => 'USD',
                        'is_featured' => true,
                        'image' => 'https://images.unsplash.com/photo-1558030006-450675393462?w=900&q=80',
                    ],
                    [
                        'name' => 'Entrecôte de bœuf, beurre maison',
                        'description' => 'Entrecôte persillée, cuisson au gré du client, beurre composé maison.',
                        'price' => 40.0,
                        'currency_code' => 'USD',
                        'image' => 'https://images.unsplash.com/photo-1600891964092-4316c288032e?w=900&q=80',
                    ],
                ],
            ],
            [
                'name' => 'Suppléments (extras)',
                'type' => Category::TYPE_ALIMENT,
                'description' => 'Avec les plats : riz pilaf, riz parfumé, banane/lituma, frites, patate douce vapeur, fufu, kwanga… Garnitures (pondu, légumes, etc.) et sauces au choix — suppléments facturés ci-dessous.',
                'image' => 'https://images.unsplash.com/photo-1586201375761-83865001e31c?w=900&q=80',
                'plats' => [
                    [
                        'name' => 'Extra — accompagnement au choix',
                        'description' => 'Supplément pour changer ou ajouter un accompagnement (riz pilaf, frites, fufu, kwanga, etc.).',
                        'price' => 6.0,
                        'currency_code' => 'USD',
                        'image' => 'https://images.unsplash.com/photo-1586201375761-83865001e31c?w=900&q=80',
                    ],
                    [
                        'name' => 'Extra — garniture',
                        'description' => 'Assortiment de légumes du jour, pondu, nsakamadesu, légumes verts, ngaï-ngaï… en supplément.',
                        'price' => 4.0,
                        'currency_code' => 'USD',
                        'image' => 'https://images.unsplash.com/photo-1540420773420-3366772f4999?w=900&q=80',
                    ],
                    [
                        'name' => 'Extra — sauce',
                        'description' => 'Sauce au choix : vierge, gombos, aubergines, chimichurri, tomates confites, crémeux champignons, réduction poivre vert, béarnaise…',
                        'price' => 5.0,
                        'currency_code' => 'USD',
                        'image' => 'https://images.unsplash.com/photo-1476718406336-bb5a9690ee2a?w=900&q=80',
                    ],
                ],
            ],
            [
                'name' => 'Planches à partager',
                'type' => Category::TYPE_ALIMENT,
                'description' => 'Grands formats pour plusieurs convives.',
                'image' => 'https://images.unsplash.com/photo-1414235077428-338989a2e8c0?w=900&q=80',
                'plats' => [
                    [
                        'name' => 'Dégustation gourmande (planche)',
                        'description' => 'Assortiment gourmand de mets salés à partager, sélection du chef.',
                        'price' => 37.0,
                        'currency_code' => 'USD',
                        'image' => 'https://images.unsplash.com/photo-1555939594-58d7cb561ad1?w=900&q=80',
                    ],
                    [
                        'name' => 'Assortiment Terre et Mer',
                        'description' => 'Plateau mêlant viandes et produits de la mer, pour une table conviviale.',
                        'price' => 60.0,
                        'currency_code' => 'USD',
                        'is_featured' => true,
                        'image' => 'https://images.unsplash.com/photo-1544027885-9e29a0adfdb2?w=900&q=80',
                    ],
                    [
                        'name' => 'Plateau convivial',
                        'description' => 'Très grand plateau festif, idéal pour les grands groupes.',
                        'price' => 120.0,
                        'currency_code' => 'USD',
                        'image' => 'https://images.unsplash.com/photo-1504674900247-0877df9cc836?w=900&q=80',
                    ],
                    [
                        'name' => 'Liboke de porc à l’ancienne',
                        'description' => 'Porc mijoté ou cuit en liboke (feuille), recette traditionnelle.',
                        'price' => 25.0,
                        'currency_code' => 'USD',
                        'image' => 'https://images.unsplash.com/photo-1529042410759-befb1204b468?w=900&q=80',
                    ],
                    [
                        'name' => 'Poulet entier, cuisson sur braise parfumé',
                        'description' => 'Poulet entier rôti sur braise, parfums d’épices et herbes.',
                        'price' => 30.0,
                        'currency_code' => 'USD',
                        'image' => 'https://images.unsplash.com/photo-1598103442097-8b74394b95c6?w=900&q=80',
                    ],
                ],
            ],
            [
                'name' => 'Desserts',
                'type' => Category::TYPE_ALIMENT,
                'description' => 'Fins de repas et douceurs maison.',
                'image' => 'https://images.unsplash.com/photo-1551024506-0bccc28e09af?w=900&q=80',
                'plats' => [
                    [
                        'name' => 'Dégustation gourmande (dessert)',
                        'description' => 'Assortiment de mignardises et petites douceurs du chef.',
                        'price' => 18.0,
                        'currency_code' => 'USD',
                        'image' => 'https://images.unsplash.com/photo-1578985545062-69928b1d9587?w=900&q=80',
                    ],
                    [
                        'name' => 'Ananas rôti à la vanille',
                        'description' => 'Ananas caramélisé au four, parfum vanille, souvent servi tiède.',
                        'price' => 6.0,
                        'currency_code' => 'USD',
                        'image' => 'https://images.unsplash.com/photo-1559181567-c3190ca9959b?w=900&q=80',
                    ],
                    [
                        'name' => 'Moelleux au chocolat',
                        'description' => 'Cœur fondant ou mi-cuit au chocolat, selon la recette du jour.',
                        'price' => 20.0,
                        'currency_code' => 'USD',
                        'is_featured' => true,
                        'image' => 'https://images.unsplash.com/photo-1606313564200-e75d5e3047d9?w=900&q=80',
                    ],
                    [
                        'name' => 'Assortiment de crème glacée',
                        'description' => 'Plusieurs parfums de glaces et sorbets maison ou sélectionnés.',
                        'price' => 20.0,
                        'currency_code' => 'USD',
                        'image' => 'https://images.unsplash.com/photo-1563805042-7684c019e1cb?w=900&q=80',
                    ],
                    [
                        'name' => 'Crêpes revisitées',
                        'description' => 'Crêpes façon Kwetu : garniture et présentation revisitées par le chef.',
                        'price' => 20.0,
                        'currency_code' => 'USD',
                        'image' => 'https://images.unsplash.com/photo-1626082927389-6cd097cdc6ec?w=900&q=80',
                    ],
                ],
            ],
            [
                'name' => 'Eaux',
                'type' => Category::TYPE_BOISSON,
                'description' => 'Eaux minérales locales et importées (carte Menu Boissons Kwetu).',
                'image' => self::U_EAU,
                'plats' => [
                    ['name' => 'Eau simple — locale', 'description' => 'Eau de table ou source locale, format standard.', 'price' => 1.5, 'currency_code' => 'USD', 'image' => self::U_EAU],
                    ['name' => 'Eau minérale plate — locale', 'description' => 'Bouteille d’eau plate locale.', 'price' => 3.5, 'currency_code' => 'USD', 'image' => self::U_EAU],
                    ['name' => 'Eau minérale gazeuse — locale', 'description' => 'Bouteille d’eau gazeuse locale.', 'price' => 3.5, 'currency_code' => 'USD', 'image' => self::U_EAU],
                    ['name' => 'Aqua Panna — plate (importée)', 'description' => 'Eau minérale plate italienne, équilibre très doux.', 'price' => 12.0, 'currency_code' => 'USD', 'image' => self::U_EAU],
                    ['name' => 'San Pellegrino — pétillante (importée)', 'description' => 'Eau minérale naturelle pétillante, italienne.', 'price' => 8.0, 'currency_code' => 'USD', 'image' => self::U_EAU],
                    ['name' => 'Perrier', 'description' => 'Eau minérale naturelle gazeuse.', 'price' => 8.0, 'currency_code' => 'USD', 'image' => self::U_EAU],
                ],
            ],
            [
                'name' => 'Jus frais',
                'type' => Category::TYPE_BOISSON,
                'description' => 'Jus pressés, mélanges et jus en brique.',
                'image' => self::U_JUS,
                'plats' => [
                    ['name' => 'Jus d’orange frais', 'description' => 'Pressé à la demande, vitaminé.', 'price' => 8.0, 'currency_code' => 'USD', 'image' => self::U_JUS],
                    ['name' => 'Jus d’ananas frais', 'description' => 'Ananas frais mixé ou pressé, goût tropical.', 'price' => 8.0, 'currency_code' => 'USD', 'image' => self::U_JUS],
                    ['name' => 'Jus de gingembre frais', 'description' => 'Gingembre frais, vif et légèrement piquant, rafraîchissant.', 'price' => 8.0, 'currency_code' => 'USD', 'image' => self::U_JUS],
                    ['name' => 'Cocktails de jus', 'description' => 'Mélange de jus frais façon bar — composition du jour.', 'price' => 10.0, 'currency_code' => 'USD', 'is_featured' => true, 'image' => self::U_JUS],
                    ['name' => 'Jus en boîte — pomme, orange ou ananas', 'description' => 'Jus de fruits en brique, parfum au choix selon stock.', 'price' => 5.0, 'currency_code' => 'USD', 'image' => self::U_JUS],
                    ['name' => 'Jus multi-fruits', 'description' => 'Assemblage de plusieurs fruits, équilibre sucre-acidité.', 'price' => 7.0, 'currency_code' => 'USD', 'image' => self::U_JUS],
                ],
            ],
            [
                'name' => 'Sodas locaux',
                'type' => Category::TYPE_BOISSON,
                'description' => 'Sodas en bouteille locale.',
                'image' => self::U_SODA,
                'plats' => [
                    ['name' => 'Sodas locaux — 33 cl', 'description' => 'Coca, Fanta, Sprite, Vitalo, Maltina ou Tonic, format standard.', 'price' => 3.5, 'currency_code' => 'USD', 'image' => self::U_SODA],
                    ['name' => 'Coca Grand', 'description' => 'Grand format Coca-Cola.', 'price' => 5.0, 'currency_code' => 'USD', 'image' => self::U_SODA],
                ],
            ],
            [
                'name' => 'Sodas en canette',
                'type' => Category::TYPE_BOISSON,
                'description' => 'Soft drinks et énergisant en canette.',
                'image' => self::U_SODA,
                'plats' => [
                    ['name' => 'Sodas en canette', 'description' => 'Coca, Fanta, Sprite, Vimto ou Tonic — canette.', 'price' => 4.0, 'currency_code' => 'USD', 'image' => self::U_SODA],
                    ['name' => 'Schweppes agrumes', 'description' => 'Boisson gazeuse aux agrumes.', 'price' => 5.0, 'currency_code' => 'USD', 'image' => self::U_SODA],
                    ['name' => 'Coca Zéro', 'description' => 'Cola sans sucres, version canette.', 'price' => 4.5, 'currency_code' => 'USD', 'image' => self::U_SODA],
                    ['name' => 'Bavaria', 'description' => 'Bière sans alcool ou boisson maltée selon référence servie.', 'price' => 5.5, 'currency_code' => 'USD', 'image' => self::U_SODA],
                    ['name' => 'Red Bull', 'description' => 'Boisson énergisante.', 'price' => 6.0, 'currency_code' => 'USD', 'image' => self::U_SODA],
                ],
            ],
            [
                'name' => 'Bières locales',
                'type' => Category::TYPE_BOISSON,
                'description' => 'Bières brassées ou distribuées localement.',
                'image' => self::U_BIERE,
                'plats' => [
                    ['name' => 'Beaufort', 'description' => 'Bière blonde locale, légère et désaltérante.', 'price' => 5.0, 'currency_code' => 'USD', 'image' => self::U_BIERE],
                    ['name' => 'Castel', 'description' => 'Lager africaine, notes maltées.', 'price' => 5.0, 'currency_code' => 'USD', 'image' => self::U_BIERE],
                    ['name' => 'Nkoyi', 'description' => 'Bière locale, profil malt houblon équilibré.', 'price' => 5.0, 'currency_code' => 'USD', 'image' => self::U_BIERE],
                    ['name' => 'Mutzig', 'description' => 'Bière premium locale, plus corsée.', 'price' => 5.0, 'currency_code' => 'USD', 'image' => self::U_BIERE],
                    ['name' => 'Tembo', 'description' => 'Bière locale, format ou gamme premium selon la cave.', 'price' => 8.0, 'currency_code' => 'USD', 'is_featured' => true, 'image' => self::U_BIERE],
                    ['name' => 'Heineken — locale', 'description' => 'Heineken distribuée en circuit local.', 'price' => 5.0, 'currency_code' => 'USD', 'image' => self::U_BIERE],
                    ['name' => 'Legend', 'description' => 'Bière locale, caractère affirmé.', 'price' => 5.0, 'currency_code' => 'USD', 'image' => self::U_BIERE],
                    ['name' => 'Doppel', 'description' => 'Bière locale, souvent plus alcoolisée ou « double » malt.', 'price' => 5.0, 'currency_code' => 'USD', 'image' => self::U_BIERE],
                ],
            ],
            [
                'name' => 'Bières importées',
                'type' => Category::TYPE_BOISSON,
                'description' => 'Bières européennes importées.',
                'image' => self::U_BIERE,
                'plats' => [
                    ['name' => 'Heineken — importée', 'description' => 'Lager néerlandaise, servie très fraîche.', 'price' => 8.0, 'currency_code' => 'USD', 'image' => self::U_BIERE],
                    ['name' => 'Leffe Blonde', 'description' => 'Abbaye belge blonde, notes fruitées et épicées.', 'price' => 8.0, 'currency_code' => 'USD', 'image' => self::U_BIERE],
                    ['name' => 'Leffe Brune', 'description' => 'Abbaye brune, caramel et malt torréfié.', 'price' => 8.0, 'currency_code' => 'USD', 'image' => self::U_BIERE],
                ],
            ],
            [
                'name' => 'Cocktails signature Kwetu',
                'type' => Category::TYPE_BOISSON,
                'description' => 'Créations maison au rhum Kwilu et mélanges signature.',
                'image' => self::U_COCKTAIL,
                'plats' => [
                    ['name' => 'Apa Ndjo Kwetu', 'description' => 'Kwilu Rhum, jus de gingembre, citron vert, fruit de la passion, jus d’ananas, sirop de canne.', 'price' => 20.0, 'currency_code' => 'USD', 'is_featured' => true, 'image' => self::U_COCKTAIL],
                    ['name' => 'Mojito Kwetu', 'description' => 'Kwilu Rhum, sucre de canne, menthe fraîche, citron vert, infusion de basilic, eau pétillante.', 'price' => 20.0, 'currency_code' => 'USD', 'is_featured' => true, 'image' => self::U_COCKTAIL],
                    ['name' => 'Ma Campagne Mojito', 'description' => 'Rhum blanc, menthe fraîche, basilic, bissap, eau pétillante — version maison du mojito.', 'price' => 18.0, 'currency_code' => 'USD', 'image' => self::U_COCKTAIL],
                    ['name' => 'Piña Colada', 'description' => 'Rhum blanc, crème de coco, jus d’ananas — onctueux et tropical.', 'price' => 18.0, 'currency_code' => 'USD', 'image' => self::U_COCKTAIL],
                    ['name' => 'Margarita', 'description' => 'Tequila, triple sec, citron vert, glace — bord de verre au sel (recette classique ; la carte peut varier).', 'price' => 18.0, 'currency_code' => 'USD', 'image' => self::U_COCKTAIL],
                    ['name' => 'Passion Kiss', 'description' => 'Jus d’orange, ananas, sirop de grenadine et sirop de fruit de la passion — cocktail fruité, sans alcool sur la base indiquée.', 'price' => 18.0, 'currency_code' => 'USD', 'image' => self::U_COCKTAIL],
                ],
            ],
            [
                'name' => 'Boissons chaudes',
                'type' => Category::TYPE_BOISSON,
                'description' => 'Thés, infusions, cafés et chocolat.',
                'image' => self::U_CAFE,
                'plats' => [
                    ['name' => 'Thé nature', 'description' => 'Thé noir ou infusion simple, servi chaud.', 'price' => 2.0, 'currency_code' => 'USD', 'image' => self::U_CAFE],
                    ['name' => 'Thé vert', 'description' => 'Thé vert, notes herbacées et légères.', 'price' => 3.0, 'currency_code' => 'USD', 'image' => self::U_CAFE],
                    ['name' => 'Thé citron', 'description' => 'Thé parfumé citron, digeste et rafraîchissant.', 'price' => 3.0, 'currency_code' => 'USD', 'image' => self::U_CAFE],
                    ['name' => 'Infusion nature locale', 'description' => 'Tisane ou infusion aux plantes du terroir.', 'price' => 3.0, 'currency_code' => 'USD', 'image' => self::U_CAFE],
                    ['name' => 'Infusion gingembre', 'description' => 'Gingembre chaud, réconfortant et épicé.', 'price' => 4.0, 'currency_code' => 'USD', 'image' => self::U_CAFE],
                    ['name' => 'Café allongé local', 'description' => 'Café noir allongé, torréfaction locale.', 'price' => 3.0, 'currency_code' => 'USD', 'image' => self::U_CAFE],
                    ['name' => 'Expresso', 'description' => 'Café serré, court et corsé.', 'price' => 5.0, 'currency_code' => 'USD', 'image' => self::U_CAFE],
                    ['name' => 'Café au lait', 'description' => 'Café doux allongé au lait chaud.', 'price' => 3.5, 'currency_code' => 'USD', 'image' => self::U_CAFE],
                    ['name' => 'Chocolat chaud', 'description' => 'Chocolat onctueux, servi bien chaud.', 'price' => 3.8, 'currency_code' => 'USD', 'image' => self::U_CAFE],
                ],
            ],
            [
                'name' => 'Vins rouges',
                'type' => Category::TYPE_BOISSON,
                'description' => 'Carte des rouges — Afrique du Sud, Bordeaux, Rhône ; formats bouteille, quart ou pichet.',
                'image' => self::U_VIN_ROUGE,
                'plats' => [
                    ['name' => 'Nederburg Cabernet Sauvignon 2018', 'description' => 'Afrique du Sud — cabernet structuré, fruits noirs et tanins fondus.', 'price' => 58.0, 'currency_code' => 'USD', 'image' => self::U_VIN_ROUGE],
                    ['name' => 'Van Loveren African Java Pinotage', 'description' => 'Afrique du Sud — pinotage, profil fruité et légèrement fumé.', 'price' => 47.8, 'currency_code' => 'USD', 'image' => self::U_VIN_ROUGE],
                    ['name' => 'Van Loveren Harvest Reserve Red Shiraz', 'description' => 'Afrique du Sud — shiraz, épices et mûre.', 'price' => 47.8, 'currency_code' => 'USD', 'image' => self::U_VIN_ROUGE],
                    ['name' => 'Four Cousins Collection Merlot 2019', 'description' => 'Afrique du Sud — merlot souple, prune et épices douces.', 'price' => 31.9, 'currency_code' => 'USD', 'image' => self::U_VIN_ROUGE],
                    ['name' => 'Four Cousins Collection Cabernet Sauvignon 2019', 'description' => 'Afrique du Sud — cabernet accessible, fruit rouge et structure légère.', 'price' => 31.9, 'currency_code' => 'USD', 'image' => self::U_VIN_ROUGE],
                    ['name' => 'Château Haut Vignoble Seguin Saint-Estèphe 2017', 'description' => 'Bordeaux — Saint-Estèphe, vin de garde, tanins présents.', 'price' => 117.0, 'currency_code' => 'USD', 'is_featured' => true, 'image' => self::U_VIN_ROUGE],
                    ['name' => 'Château Ségur de Cabanac Saint-Estèphe 2017', 'description' => 'Bordeaux — Saint-Estèphe, équilibre puissance et finesse.', 'price' => 117.0, 'currency_code' => 'USD', 'image' => self::U_VIN_ROUGE],
                    ['name' => 'Gravet Renaissance Saint-Émilion 2018', 'description' => 'Bordeaux droite — merlot/cabernet franc, souple et parfumé.', 'price' => 85.0, 'currency_code' => 'USD', 'image' => self::U_VIN_ROUGE],
                    ['name' => 'Château d’Arsac Margaux 2019', 'description' => 'Bordeaux — Margaux, élégance et tanins soyeux.', 'price' => 117.0, 'currency_code' => 'USD', 'image' => self::U_VIN_ROUGE],
                    ['name' => 'La Fiole Châteauneuf-du-Pape', 'description' => 'Vallée du Rhône — bouteille iconique, grenache/syrah, généreux.', 'price' => 90.0, 'currency_code' => 'USD', 'image' => self::U_VIN_ROUGE],
                    ['name' => 'Côtes du Rhône (rouge)', 'description' => 'Rhône méridional — rouge gourmand, épices et fruits rouges.', 'price' => 63.9, 'currency_code' => 'USD', 'image' => self::U_VIN_ROUGE],
                    ['name' => 'Mouton Cadet (petite bouteille)', 'description' => 'Bordeaux — format quart ou demi selon service.', 'price' => 15.8, 'currency_code' => 'USD', 'image' => self::U_VIN_ROUGE],
                    ['name' => 'Baron d’Arignac (petite bouteille)', 'description' => 'Vin de pays occitan, format réduit, facile à boire.', 'price' => 13.7, 'currency_code' => 'USD', 'image' => self::U_VIN_ROUGE],
                    ['name' => 'Verre au quart — vin rouge', 'description' => 'Service au quart de bouteille, sélection du jour.', 'price' => 10.7, 'currency_code' => 'USD', 'image' => self::U_VIN_ROUGE],
                    ['name' => 'Pichet — vin rouge', 'description' => 'Pichet de vin rouge, idéal pour la table.', 'price' => 19.0, 'currency_code' => 'USD', 'image' => self::U_VIN_ROUGE],
                ],
            ],
            [
                'name' => 'Vins rosés',
                'type' => Category::TYPE_BOISSON,
                'description' => 'Rosés doux et rosés de Rhône.',
                'image' => self::U_ROSE,
                'plats' => [
                    ['name' => 'Four Cousins Natural Sweet Rosé', 'description' => 'Afrique du Sud — rosé légèrement sucré, fruité et facile.', 'price' => 90.0, 'currency_code' => 'USD', 'image' => self::U_ROSE],
                    ['name' => 'Côtes du Rhône (rosé)', 'description' => 'Rhône — rosé sec aux notes de fruits rouges et d’agrumes.', 'price' => 63.9, 'currency_code' => 'USD', 'image' => self::U_ROSE],
                ],
            ],
            [
                'name' => 'Vins blancs',
                'type' => Category::TYPE_BOISSON,
                'description' => 'Blancs d’Alsace, Bourgogne, Loire et Afrique du Sud.',
                'image' => self::U_VIN_BLANC,
                'plats' => [
                    ['name' => 'Van Loveren Harvest Gewürztraminer', 'description' => 'Afrique du Sud — gewurztraminer aromatique, litchi et rose.', 'price' => 44.8, 'currency_code' => 'USD', 'image' => self::U_VIN_BLANC],
                    ['name' => 'Christiena Troussau Cabernet Chardonnay', 'description' => 'Assemblage chardonnay structuré, notes beurrées et fruitées.', 'price' => 47.8, 'currency_code' => 'USD', 'image' => self::U_VIN_BLANC],
                    ['name' => 'Gewürztraminer Alsace 2020', 'description' => 'Alsace — floral et épicé, accord possible avec poissons épicés.', 'price' => 47.9, 'currency_code' => 'USD', 'image' => self::U_VIN_BLANC],
                    ['name' => 'Chablis 2022 — Chardonnay', 'description' => 'Bourgogne — chardonnay minéral, craie et citron.', 'price' => 90.5, 'currency_code' => 'USD', 'is_featured' => true, 'image' => self::U_VIN_BLANC],
                    ['name' => 'Sancerre 2019', 'description' => 'Loire — sauvignon blanc sec, vif et minéral.', 'price' => 101.0, 'currency_code' => 'USD', 'image' => self::U_VIN_BLANC],
                    ['name' => 'Pouilly-Fumé — Sauvignon blanc', 'description' => 'Loire — sauvignon fumé, finesse et longueur.', 'price' => 101.0, 'currency_code' => 'USD', 'image' => self::U_VIN_BLANC],
                    ['name' => 'Chardonnay Grand Sud 2022 (petite bouteille)', 'description' => 'Blanc de pays, format réduit, fruité.', 'price' => 15.8, 'currency_code' => 'USD', 'image' => self::U_VIN_BLANC],
                    ['name' => 'Moelleux Grand Sud 2022 (petite bouteille)', 'description' => 'Blanc légèrement moelleux, dessert ou apéritif doux.', 'price' => 13.7, 'currency_code' => 'USD', 'image' => self::U_VIN_BLANC],
                    ['name' => 'Verre au quart — vin blanc', 'description' => 'Service au quart de bouteille.', 'price' => 10.7, 'currency_code' => 'USD', 'image' => self::U_VIN_BLANC],
                    ['name' => 'Pichet — vin blanc', 'description' => 'Pichet de vin blanc pour la table.', 'price' => 19.0, 'currency_code' => 'USD', 'image' => self::U_VIN_BLANC],
                ],
            ],
            [
                'name' => 'Apéritifs',
                'type' => Category::TYPE_BOISSON,
                'description' => 'Liqueurs et vermouths avant le repas.',
                'image' => self::U_LIQUEUR,
                'plats' => [
                    ['name' => 'Amarula', 'description' => 'Crème de liqueur sud-africaine aux fruits marula, vanillée.', 'price' => 16.9, 'currency_code' => 'USD', 'image' => self::U_LIQUEUR],
                    ['name' => 'Baileys', 'description' => 'Crème irlandaise whisky-cacao.', 'price' => 16.9, 'currency_code' => 'USD', 'image' => self::U_LIQUEUR],
                    ['name' => 'Cointreau', 'description' => 'Triple sec d’orange, base de nombreux cocktails.', 'price' => 15.8, 'currency_code' => 'USD', 'image' => self::U_LIQUEUR],
                    ['name' => 'Grand Marnier', 'description' => 'Liqueur d’orange au cognac, ronde et amère.', 'price' => 20.2, 'currency_code' => 'USD', 'image' => self::U_LIQUEUR],
                    ['name' => 'Malibu', 'description' => 'Liqueur de rhum à la noix de coco.', 'price' => 15.8, 'currency_code' => 'USD', 'image' => self::U_LIQUEUR],
                    ['name' => 'Martini — rouge, blanc ou rosé', 'description' => 'Vermouth italien, au choix.', 'price' => 15.8, 'currency_code' => 'USD', 'image' => self::U_LIQUEUR],
                    ['name' => 'Porto — rouge, blanc ou rosé', 'description' => 'Porto selon couleur et millésime proposé.', 'price' => 15.8, 'currency_code' => 'USD', 'image' => self::U_LIQUEUR],
                ],
            ],
            [
                'name' => 'Mousseux et cidre',
                'type' => Category::TYPE_BOISSON,
                'description' => 'Bulles italiennes et cidre.',
                'image' => self::U_CHAMP,
                'plats' => [
                    ['name' => 'Prosecco', 'description' => 'Vin mousseux italien, bulles fines et fruitées.', 'price' => 64.0, 'currency_code' => 'USD', 'image' => self::U_CHAMP],
                    ['name' => 'Savanna', 'description' => 'Cidre ou bulle fruitée selon la référence (carte sud-africaine).', 'price' => 6.3, 'currency_code' => 'USD', 'image' => self::U_CHAMP],
                ],
            ],
            [
                'name' => 'Champagnes',
                'type' => Category::TYPE_BOISSON,
                'description' => 'Champagnes de maisons reconnues et cuvées prestige.',
                'image' => self::U_CHAMP,
                'plats' => [
                    ['name' => 'Moët & Chandon ICE Impérial demi-sec', 'description' => 'Champagne demi-sec, pensé pour être servi sur glaçons.', 'price' => 170.0, 'currency_code' => 'USD', 'image' => self::U_CHAMP],
                    ['name' => 'Moët & Chandon Nectar Impérial Rosé demi-sec', 'description' => 'Rosé demi-sec, fruité et gourmand.', 'price' => 159.8, 'currency_code' => 'USD', 'image' => self::U_CHAMP],
                    ['name' => 'Moët & Chandon Brut Impérial', 'description' => 'Brut classique de la maison, bulles régulières.', 'price' => 181.0, 'currency_code' => 'USD', 'is_featured' => true, 'image' => self::U_CHAMP],
                    ['name' => 'Laurent-Perrier Brut', 'description' => 'Champagne brut, frais et élégant.', 'price' => 181.0, 'currency_code' => 'USD', 'image' => self::U_CHAMP],
                    ['name' => 'Veuve Clicquot 1772 Brut', 'description' => 'Brut maison Veuve Clicquot, structure et brioche.', 'price' => 191.7, 'currency_code' => 'USD', 'image' => self::U_CHAMP],
                    ['name' => 'Ruinart Blanc de Blancs', 'description' => '100 % chardonnay, pureté et minéralité.', 'price' => 314.0, 'currency_code' => 'USD', 'image' => self::U_CHAMP],
                    ['name' => 'Dom Pérignon (cuvée prestige)', 'description' => 'Champagne de prestige, millésime selon disponibilité.', 'price' => 585.8, 'currency_code' => 'USD', 'is_featured' => true, 'image' => self::U_CHAMP],
                    ['name' => 'Veuve Clicquot La Grande Dame', 'description' => 'Cuvée prestige, complexité et longue garde.', 'price' => 479.0, 'currency_code' => 'USD', 'image' => self::U_CHAMP],
                ],
            ],
            [
                'name' => 'Spiritueux et digestifs',
                'type' => Category::TYPE_BOISSON,
                'description' => 'Whiskies, rhums, vodkas et cognacs — service au verre selon la carte.',
                'image' => self::U_WHISKY,
                'plats' => [
                    ['name' => 'Nzinga Nkuvu', 'description' => 'Whisky / spiritueux local ou régional, profil à demander au bar.', 'price' => 12.0, 'currency_code' => 'USD', 'image' => self::U_WHISKY],
                    ['name' => 'J&B', 'description' => 'Scotch blend léger et accessible.', 'price' => 15.0, 'currency_code' => 'USD', 'image' => self::U_WHISKY],
                    ['name' => 'Johnnie Walker Red Label', 'description' => 'Blend écossais, fumée et épices.', 'price' => 15.0, 'currency_code' => 'USD', 'image' => self::U_WHISKY],
                    ['name' => 'Johnnie Walker Black Label 12 ans', 'description' => 'Blend 12 ans, plus rond et tourbé modéré.', 'price' => 16.0, 'currency_code' => 'USD', 'image' => self::U_WHISKY],
                    ['name' => 'Johnnie Walker Double Black', 'description' => 'Blend intense, fumée marquée.', 'price' => 18.0, 'currency_code' => 'USD', 'image' => self::U_WHISKY],
                    ['name' => 'Johnnie Walker Blue Label', 'description' => 'Blend premium, rareté et finesse.', 'price' => 295.0, 'currency_code' => 'USD', 'is_featured' => true, 'image' => self::U_WHISKY],
                    ['name' => 'Jack Daniel’s 7 ans', 'description' => 'Tennessee whiskey, sucre d’érable et vanille.', 'price' => 12.0, 'currency_code' => 'USD', 'image' => self::U_WHISKY],
                    ['name' => 'Glenfiddich', 'description' => 'Single malt écossais Speyside, fruité et élégant.', 'price' => 20.0, 'currency_code' => 'USD', 'image' => self::U_WHISKY],
                    ['name' => 'Chivas Regal 12 ans', 'description' => 'Blend écossais 12 ans, miel et pomme.', 'price' => 18.0, 'currency_code' => 'USD', 'image' => self::U_WHISKY],
                    ['name' => 'Chivas Regal 13 ans', 'description' => 'Blend vieilli, plus de profondeur et d’épices.', 'price' => 22.0, 'currency_code' => 'USD', 'image' => self::U_WHISKY],
                    ['name' => 'Chivas Regal 18 ans', 'description' => 'Blend 18 ans, complexité et longueur.', 'price' => 24.0, 'currency_code' => 'USD', 'image' => self::U_WHISKY],
                    ['name' => 'Royal Salute 21 ans', 'description' => 'Blend de luxe 21 ans, coffret porcelaine.', 'price' => 350.0, 'currency_code' => 'USD', 'image' => self::U_WHISKY],
                    ['name' => 'Rhum sélection — 12 ans', 'description' => 'Rhum vieilli 12 ans (référence selon bar).', 'price' => 18.0, 'currency_code' => 'USD', 'image' => self::U_LIQUEUR],
                    ['name' => 'Rhum sélection — 13 ans', 'description' => 'Rhum vieilli 13 ans (référence selon bar).', 'price' => 22.0, 'currency_code' => 'USD', 'image' => self::U_LIQUEUR],
                    ['name' => 'Rhum sélection — 18 ans', 'description' => 'Rhum vieilli 18 ans (référence selon bar).', 'price' => 24.0, 'currency_code' => 'USD', 'image' => self::U_LIQUEUR],
                    ['name' => 'Belvedere', 'description' => 'Vodka polonaise de luxe, très pure.', 'price' => 15.4, 'currency_code' => 'USD', 'image' => self::U_LIQUEUR],
                    ['name' => 'Absolut', 'description' => 'Vodka suédoise classique, neutre.', 'price' => 10.0, 'currency_code' => 'USD', 'image' => self::U_LIQUEUR],
                    ['name' => 'Courvoisier', 'description' => 'Cognac, assemblage fruité et vanillé.', 'price' => 28.0, 'currency_code' => 'USD', 'image' => self::U_LIQUEUR],
                    ['name' => 'Hennessy VSOP', 'description' => 'Cognac vieilli, rondeur et épices.', 'price' => 28.0, 'currency_code' => 'USD', 'image' => self::U_LIQUEUR],
                    ['name' => 'Hennessy VS', 'description' => 'Cognac jeune, vif et fruité.', 'price' => 25.0, 'currency_code' => 'USD', 'image' => self::U_LIQUEUR],
                    ['name' => 'Rémy Martin VSOP', 'description' => 'Cognac fines bois, équilibre et longueur.', 'price' => 25.0, 'currency_code' => 'USD', 'image' => self::U_LIQUEUR],
                    ['name' => 'Rémy Martin XO', 'description' => 'Cognac XO, rancio et complexité.', 'price' => 45.0, 'currency_code' => 'USD', 'image' => self::U_LIQUEUR],
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
