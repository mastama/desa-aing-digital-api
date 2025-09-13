<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Tabel gambar tambahan untuk profil.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('profile_images', function (Blueprint $table) {
            $table->uuid('id')->primary();

            // FK ke profiles dengan nama FK pendek (aman untuk MySQL)
            $table->uuid('profile_id');
            $table->foreign('profile_id', 'profimg_profile_fk')
                  ->references('id')->on('profiles')
                  ->cascadeOnDelete();

            // path/URL gambar; 255 biasanya cukup, naikan jika perlu
            $table->string('image_path');

            $table->softDeletes();
            $table->timestamps();

            // indeks bantu query by profile
            $table->index('profile_id', 'profimg_profile_idx');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('profile_images');
    }
};
