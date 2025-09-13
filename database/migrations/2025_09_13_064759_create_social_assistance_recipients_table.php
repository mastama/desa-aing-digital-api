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
        Schema::create('social_assistance_recipients', function (Blueprint $table) {
            $table->uuid('id')->primary();

            // FK ke program bantuan sosial (SocialAssistance)
            $table->uuid('social_assistance_id');
            $table->foreign('social_assistance_id', 'sar_sa_fk')
                    ->references('id')->on('social_assistances')
                    ->cascadeOnDelete();

            // FK ke kepala keluarga HoF (penerima bantuan)
            $table->uuid('head_of_family_id');
            $table->foreign('head_of_family_id', 'sar_hof_fk')
                    ->references('id')->on('head_of_families')
                    ->cascadeOnDelete();

            // Nominal real yang disalurkan (wajib diisi)
            $table->decimal('amount', 10, 2);

            // Alasan (bisa diisi jika status adalah 'rejected')
            $table->longText('reason')->nullable();

            // Informasi rekening bank penerima
            $table->string('bank', 50)->nullable();

            $table->string('account_number', 64)->nullable();
            $table->string('proof_of_transfer')->nullable();

            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');

            // Periode penyaluran bantuan
            $table->unsignedTinyInteger('period_month'); // 1-12
            $table->unsignedSmallInteger('period_year'); // 4 digit year (2025, 2026, etc.)

            $table->softDeletes();
            $table->timestamps();

            // Indexes for optimization
            $table->index(['social_assistance_id', 'head_of_family_id'], 'sar_sa_hof_idx');
            $table->index(['status'], 'sar_status_idx');
            $table->index(['period_month', 'period_year'], 'sar_period_idx');

            // Cegah duplikasi penerima dalam periode yang sama
            $table->unique(
                ['social_assistance_id', 'head_of_family_id', 'period_month', 'period_year'], 
                'sar_unique_program_hof_period'
            );
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('social_assistance_recipients');
    }
};
