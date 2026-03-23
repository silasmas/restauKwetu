<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\RessourceRestaurant;
use App\Models\Restaurant;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

/**
 * CRUD pour la fiche de présentation du restaurant.
 */
class RestaurantController extends Controller
{
    /**
     * GET /api/v1/restaurant — liste (en pratique un seul enregistrement).
     */
    public function index(): AnonymousResourceCollection
    {
        return RessourceRestaurant::collection(Restaurant::all());
    }

    /**
     * GET /api/v1/restaurant/{restaurant} — détail.
     */
    public function show(Restaurant $restaurant): RessourceRestaurant
    {
        return new RessourceRestaurant($restaurant);
    }

    /**
     * POST /api/v1/restaurant — créer.
     */
    public function store(Request $request): RessourceRestaurant
    {
        $data = $request->validate(self::regles());

        $restaurant = Restaurant::create($data);

        return (new RessourceRestaurant($restaurant))
            ->response()
            ->setStatusCode(201)
            ->original;
    }

    /**
     * PUT/PATCH /api/v1/restaurant/{restaurant} — mettre à jour.
     */
    public function update(Request $request, Restaurant $restaurant): RessourceRestaurant
    {
        $data = $request->validate(self::regles(parfoisRequis: true));

        $restaurant->update($data);

        return new RessourceRestaurant($restaurant->fresh());
    }

    /**
     * DELETE /api/v1/restaurant/{restaurant} — supprimer.
     */
    public function destroy(Restaurant $restaurant): JsonResponse
    {
        $restaurant->delete();

        return response()->json(null, 204);
    }

    /**
     * @return array<string, mixed>
     */
    private static function regles(bool $parfoisRequis = false): array
    {
        $requis = $parfoisRequis ? 'sometimes|required' : 'required';

        return [
            'name' => [$requis, 'string', 'max:255'],
            'slogan' => ['nullable', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'logo_path' => ['nullable', 'string', 'max:255'],
            'cover_path' => ['nullable', 'string', 'max:255'],
            'email' => ['nullable', 'email', 'max:255'],
            'phone' => ['nullable', 'string', 'max:255'],
            'phone_secondary' => ['nullable', 'string', 'max:255'],
            'website' => ['nullable', 'url', 'max:255'],
            'address' => ['nullable', 'string', 'max:255'],
            'city' => ['nullable', 'string', 'max:255'],
            'postal_code' => ['nullable', 'string', 'max:20'],
            'country' => ['nullable', 'string', 'max:255'],
            'latitude' => ['nullable', 'numeric', 'between:-90,90'],
            'longitude' => ['nullable', 'numeric', 'between:-180,180'],
            'currency_code' => [$requis, 'string', 'size:3'],
            'timezone' => [$requis, 'string', 'max:255'],
            'opening_hours' => ['nullable', 'array'],
            'opening_hours.*' => ['string'],
            'social_links' => ['nullable', 'array'],
            'social_links.*' => ['string', 'url'],
        ];
    }
}
