<?php

namespace App\Models;

use Database\Factories\MediaPlatFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;

#[Fillable([
    'plat_id',
    'type',
    'disk',
    'file_path',
    'external_url',
    'is_primary',
    'sort_order',
    'caption',
])]
class MediaPlat extends Model
{
    /** @use HasFactory<MediaPlatFactory> */
    use HasFactory;

    protected $table = 'medias_plats';

    public const TYPE_PHOTO = 'photo';

    public const TYPE_VIDEO = 'video';

    protected static function booted(): void
    {
        static::creating(function (MediaPlat $media): void {
            if (blank($media->disk)) {
                $media->disk = 'public';
            }
        });

        static::saving(function (MediaPlat $media): void {
            $media->file_path = filled($media->file_path) ? $media->file_path : null;
            $media->external_url = filled($media->external_url) ? trim((string) $media->external_url) : null;

            if ($media->type === self::TYPE_VIDEO) {
                $media->is_primary = false;
            }

            if ($media->type === self::TYPE_PHOTO) {
                $media->external_url = null;
            }

            if ($media->type === self::TYPE_VIDEO) {
                $hasFichier = filled($media->file_path);
                $hasUrl = filled($media->external_url);
                if (! $hasFichier && ! $hasUrl) {
                    throw ValidationException::withMessages([
                        'file_path' => 'Pour une vidéo, indiquez un fichier uploadé et/ou une URL externe.',
                        'external_url' => 'Pour une vidéo, indiquez un fichier uploadé et/ou une URL externe.',
                    ]);
                }
            }
        });

        static::saved(function (MediaPlat $media): void {
            if (! $media->is_primary || $media->type !== self::TYPE_PHOTO) {
                return;
            }

            static::query()
                ->where('plat_id', $media->plat_id)
                ->where('type', self::TYPE_PHOTO)
                ->whereKeyNot($media->getKey())
                ->update(['is_primary' => false]);
        });
    }

    protected function casts(): array
    {
        return [
            'is_primary' => 'boolean',
            'sort_order' => 'integer',
        ];
    }

    public function plat(): BelongsTo
    {
        return $this->belongsTo(Plat::class, 'plat_id');
    }

    /**
     * URL publique du fichier stocké (photo ou vidéo hébergée sur le disque).
     */
    public function urlFichierPublic(): ?string
    {
        if (! $this->file_path) {
            return null;
        }

        return Storage::disk($this->disk)->url($this->file_path);
    }

    public function estPhoto(): bool
    {
        return $this->type === self::TYPE_PHOTO;
    }

    public function estVideo(): bool
    {
        return $this->type === self::TYPE_VIDEO;
    }
}
