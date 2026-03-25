<?php

namespace Database\Seeders;

use App\Models\Restaurant;
use Illuminate\Database\Seeder;

class RestaurantSeeder extends Seeder
{
    public function run(): void
    {
        Restaurant::query()->delete();

        Restaurant::create([
            'name' => 'Resto Kwetu',
            'slogan' => 'Lounge Bar, terrasse-piscine et salon privé',
            'description' => 'Lounge Bar, terrasse-piscine et salon privé. Un cadre unique à Kinshasa pour vos repas, événements et moments de détente.',
            'email' => null,
            'phone' => '+243 892 959 640',
            'phone_secondary' => null,
            'website' => null,
            'address' => "88, Avenue Nguma 3, Ngaliema, Macampagne (Ref : en diagonale d'Allée Verte)",
            'city' => 'Kinshasa',
            'postal_code' => null,
            'country' => 'Congo (RDC)',
            'latitude' => -4.3217,
            'longitude' => 15.2663,
            'currency_code' => 'USD',
            'timezone' => 'Africa/Kinshasa',
            'opening_hours' => [
                'Lundi' => '08:00 – 22:30',
                'Mardi' => '08:00 – 22:30',
                'Mercredi' => '08:00 – 22:30',
                'Jeudi' => '08:00 – 22:30',
                'Vendredi' => '08:00 – 22:30',
                'Samedi' => '08:00 – 22:30',
                'Dimanche' => '08:00 – 22:30',
            ],
            'social_links' => [
                'facebook' => 'https://facebook.com/restokwetu',
                'instagram' => 'https://www.instagram.com/resto.kwetu/',
            ],
        ]);
    }
}
