<?php

namespace App\Support;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

final class UniqueSlug
{
    /**
     * @param  class-string<Model>  $modelClass
     */
    public static function garantir(string $modelClass, string $base, string $colonne = 'slug', ?int $ignorerId = null): string
    {
        $slug = Str::slug($base);
        if ($slug === '') {
            $slug = 'element';
        }

        /** @var Model $instance */
        $instance = new $modelClass;
        $cle = $instance->getKeyName();

        $original = $slug;
        $n = 2;
        while ($instance->newQuery()
            ->where($colonne, $slug)
            ->when($ignorerId !== null, fn ($q) => $q->where($cle, '!=', $ignorerId))
            ->exists()) {
            $slug = $original.'-'.$n;
            $n++;
        }

        return $slug;
    }
}
