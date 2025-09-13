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
        Schema::create('events', function (Blueprint $table) {
            $table->uuid('id')->primary();

            // owner/creator of the event
            $table->uuid('head_of_family_id')->nullable();
            $table->foreign('head_of_family_id')
                ->references('id')->on('head_of_families')
                ->nullOnDelete(); // kalau HoF dihapus, kolom ini jadi ke null

            $table->string('thumbnail')->nullable();
            $table->string('name');
            $table->longText('description')->nullable();
            $table->decimal('price', 10, 2)->default(0);

            // tanggal & jam dipisah biar lebih fleksibel
            $table->date('start_date');
            $table->time('start_time');
            $table->date('end_date');
            $table->time('end_time');

            $table->boolean('is_active')->default(true);  

            $table->softDeletes();
            $table->timestamps();

            // indeks yang membantu pencarian
            $table->index(['is_active', 'start_date']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('events');
    }
};
