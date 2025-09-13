<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('social_assistances', function (Blueprint $table) {
            $table->uuid('id')->primary();

            $table->string('thumbnail')->nullable(); // URL or path to the thumbnail image
            $table->string('name');                     // Name of the assistance program

            $table->enum('category', ['staple', 'cash', 'subsidized fuel', 'health', 'education', 'housing', 'other']);

            // Nominal default atau standar bantuan (boleh null jika variatif per penerima)
            $table->decimal('amount', 10, 2)->nullable();

            $table->string('provider')->nullable();
            $table->longText('description')->nullable();
            $table->boolean('is_available')->default(true);

            $table->softDeletes();
            $table->timestamps();

            // Indexes bantu pencarian program aktif
            $table->index(['is_available', 'category', 'name']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('social_assistances');
    }
};
