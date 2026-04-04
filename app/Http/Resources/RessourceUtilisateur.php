<?php

namespace App\Http\Resources;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Représentation JSON d’un compte utilisateur (sans secrets).
 *
 * @mixin User
 */
class RessourceUtilisateur extends JsonResource
{
    /**
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'nom' => $this->name,
            'email' => $this->email,
            'email_verifie_le' => $this->email_verified_at?->toIso8601String(),
            'cree_le' => $this->created_at?->toIso8601String(),
            'mis_a_jour_le' => $this->updated_at?->toIso8601String(),
        ];
    }
}
