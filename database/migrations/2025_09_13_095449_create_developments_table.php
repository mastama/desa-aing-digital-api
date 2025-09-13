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
        Schema::create('developments', function (Blueprint $table) {
            $table->uuid('id')->primary();

            $table->string('thumbnail')->nullable();
            $table->string('name');
            $table->longText('description')->nullable();

            // Catatan: sekarang string. Kalau mau relasi ke users, ganti ke:
            // $table->uuid('person_in_charge_id')->nullable();
            // $table->foreign('person_in_charge_id', 'dev_pic_fk')->references('id')->on('users')->nullOnDelete();
            $table->string('person_in_charge');

            // Tanggal mulai dan selesai
            $table->date('start_date');
            $table->date('end_date')->nullable();

            // Anggaran. Default 0 agar aman saat belum ditentukan
            $table->decimal('amount', 10, 2)->default(0);

            // Status proyek 
            $table->enum('status', ['planning','ongoing','completed','cancelled','paused'])->default('planning');

            // Progress proyek dalam persen (0-100)
            $table->unsignedTinyInteger('progress')->default(0);

            $table->softDeletes();
            $table->timestamps();

            // Indexes for faster queries on common fields
            $table->index(['status', 'start_date'], 'dev_status_start_date_idx');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('developments');
    }
};
