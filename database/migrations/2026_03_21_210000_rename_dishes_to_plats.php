<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('dish_media', function (Blueprint $table) {
            $table->dropForeign(['dish_id']);
        });

        Schema::rename('dishes', 'plats');

        Schema::table('dish_media', function (Blueprint $table) {
            $table->renameColumn('dish_id', 'plat_id');
        });

        Schema::rename('dish_media', 'medias_plats');

        Schema::table('medias_plats', function (Blueprint $table) {
            $table->foreign('plat_id')->references('id')->on('plats')->cascadeOnDelete();
        });

        DB::table('medias_plats')->where('type', 'image')->update(['type' => 'photo']);
    }

    public function down(): void
    {
        DB::table('medias_plats')->where('type', 'photo')->update(['type' => 'image']);

        Schema::table('medias_plats', function (Blueprint $table) {
            $table->dropForeign(['plat_id']);
        });

        Schema::rename('medias_plats', 'dish_media');

        Schema::table('dish_media', function (Blueprint $table) {
            $table->renameColumn('plat_id', 'dish_id');
        });

        Schema::rename('plats', 'dishes');

        Schema::table('dish_media', function (Blueprint $table) {
            $table->foreign('dish_id')->references('id')->on('dishes')->cascadeOnDelete();
        });
    }
};
