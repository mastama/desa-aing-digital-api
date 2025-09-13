<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Tabel profil desa.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('profiles', function (Blueprint $table) {
            $table->uuid('id')->primary();

            $table->string('thumbnail')->nullable();   // opsional
            $table->string('name');                    // nama desa
            $table->longText('about')->nullable();     // dibuat nullable agar fleksibel
            $table->string('headman');                 // nama kepala desa/lurah

            // total penduduk: non-negatif, default 0 agar aman
            $table->unsignedInteger('people')->default(0);

            // luas wilayah/pertanian; default 0 agar aman
            $table->decimal('agriculture_area', 16, 4)->default(0);
            $table->decimal('total_area', 16, 4)->default(0);

            $table->softDeletes();
            $table->timestamps();

            // indeks ringan (opsional), mis. sering cari per nama
            $table->index('name', 'profiles_name_idx');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('profiles');
    }
};
