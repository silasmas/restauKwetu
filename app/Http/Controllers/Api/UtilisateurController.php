<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\RessourceUtilisateur;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Unique;

/**
 * CRUD des comptes utilisateurs (authentification Sanctum requise).
 */
class UtilisateurController extends Controller
{
    /**
     * GET /api/v1/utilisateurs
     */
    public function index(): AnonymousResourceCollection
    {
        return RessourceUtilisateur::collection(User::query()->orderBy('name')->get());
    }

    /**
     * GET /api/v1/utilisateurs/{user}
     */
    public function show(User $user): RessourceUtilisateur
    {
        return new RessourceUtilisateur($user);
    }

    /**
     * POST /api/v1/utilisateurs
     */
    public function store(Request $request): RessourceUtilisateur
    {
        $data = $request->validate(self::regles());

        $user = User::create($data);

        return (new RessourceUtilisateur($user))
            ->response()
            ->setStatusCode(201)
            ->original;
    }

    /**
     * PUT/PATCH /api/v1/utilisateurs/{user}
     */
    public function update(Request $request, User $user): RessourceUtilisateur
    {
        $data = $request->validate(self::regles(parfoisRequis: true, user: $user));

        $user->update($data);

        return new RessourceUtilisateur($user->fresh());
    }

    /**
     * DELETE /api/v1/utilisateurs/{user}
     */
    public function destroy(User $user): JsonResponse
    {
        $user->delete();

        return response()->json(null, 204);
    }

    /**
     * @return array<string, list<string|Unique>>
     */
    private static function regles(bool $parfoisRequis = false, ?User $user = null): array
    {
        $emailUnique = Rule::unique('users', 'email')->ignore($user);

        if ($parfoisRequis) {
            return [
                'name' => ['sometimes', 'required', 'string', 'max:255'],
                'email' => ['sometimes', 'required', 'email', 'max:255', $emailUnique],
                'password' => ['sometimes', 'nullable', 'string', 'min:8', 'confirmed'],
            ];
        }

        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', $emailUnique],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ];
    }
}
