<?php

namespace App\Models;

use Database\Factories\PlatFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

#[Fillable([
    'category_id',
    'name',
    'slug',
    'description',
    'price',
    'currency_code',
    'promo_price',
    'is_available',
    'is_featured',
    'is_new',
    'preparation_minutes',
    'sku',
    'allergens',
    'dietary_tags',
    'tva_rate',
    'sort_order',
])]
class Plat extends Model
{
    /** @use HasFactory<PlatFactory> */
    use HasFactory;

    use SoftDeletes;

    /**
     * @param  Builder<static>  $query
     * @return Builder<static>
     */
    public function scopeDisponibles($query)
    {
        return $query->where('is_available', true);
    }

    /**
     * @param  Builder<static>  $query
     * @return Builder<static>
     */
    public function scopeMisEnAvant($query)
    {
        return $query->where('is_featured', true);
    }

    /**
     * @param  Builder<static>  $query
     * @return Builder<static>
     */
    public function scopeNouveautes($query)
    {
        return $query->where('is_new', true);
    }

    protected function casts(): array
    {
        return [
            'price' => 'decimal:2',
            'promo_price' => 'decimal:2',
            'is_available' => 'boolean',
            'is_featured' => 'boolean',
            'is_new' => 'boolean',
            'preparation_minutes' => 'integer',
            'allergens' => 'array',
            'dietary_tags' => 'array',
            'tva_rate' => 'decimal:2',
            'sort_order' => 'integer',
        ];
    }

    public function categorie(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function medias(): HasMany
    {
        return $this->hasMany(MediaPlat::class, 'plat_id')->orderBy('sort_order');
    }

    public function imagePrincipale(): HasOne
    {
        return $this->hasOne(MediaPlat::class, 'plat_id')
            ->where('type', MediaPlat::TYPE_PHOTO)
            ->where('is_primary', true);
    }
}
