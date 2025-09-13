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
        Schema::create('development_applicants', function (Blueprint $table) {
            $table->uuid('id')->primary();

            // FK ke proyek pembangunan
            $table->uuid('development_id');
            $table->foreign('development_id', 'dev_app_dev_id_fk')
                    ->references('id')->on('developments')
                    ->cascadeOnDelete();

            // FK ke user yang mengajukan
            $table->uuid('user_id');
            $table->foreign('user_id', 'dev_app_user_id_fk')
                    ->references('id')->on('users')
                    ->cascadeOnDelete();

            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');

            $table->softDeletes();
            $table->timestamps();

            // Cegah user mendaftar proyek yang sama berkali-kali
            $table->unique(['development_id', 'user_id'], 'devapp_dev_user_uniq');

            // Index untuk filter by status
            $table->index(['status'], 'devapp_status_idx');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('development_applicants');
    }
};
