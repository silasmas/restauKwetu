<?php

namespace App\Models;

use Database\Factories\CategoryFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable([
    'name',
    'slug',
    'description',
    'image_path',
    'type',
    'sort_order',
    'is_active',
])]
class Category extends Model
{
    public const TYPE_ALIMENT = 1;

    public const TYPE_BOISSON = 2;

    /** @use HasFactory<CategoryFactory> */
    use HasFactory;

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
            'sort_order' => 'integer',
            'type' => 'integer',
        ];
    }

    /**
     * @return array<int, string>
     */
    public static function libellesType(): array
    {
        return [
            self::TYPE_ALIMENT => 'Aliments',
            self::TYPE_BOISSON => 'Boissons',
        ];
    }

    /**
     * @param  Builder<static>  $query
     * @return Builder<static>
     */
    public function scopeActives($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * @param  Builder<static>  $query
     * @return Builder<static>
     */
    public function scopeOfType($query, int $type)
    {
        return $query->where('type', $type);
    }

    public function plats(): HasMany
    {
        return $this->hasMany(Plat::class, 'category_id');
    }
}
