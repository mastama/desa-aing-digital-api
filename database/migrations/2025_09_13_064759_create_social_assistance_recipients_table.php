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

            $table->uuid('social_assistance_id');
            $table->foreign('social_assistance_id')->references('id')->on('social_assistances')->onDelete('cascade');

            $table->uuid('head_of_family_id');
            $table->foreign('head_of_family_id')->references('id')->on('head_of_families')->onDelete('cascade');

            $table->decimal('amount', 10, 2);
            $table->longText('reason')->nullable();
            $table->enum('bank', ['BCA', 'BNI', 'BRI', 'Mandiri', 'Danamon', 'CIMB Niaga', 'Permata', 'BTN', 'Maybank', 'Panin', 'OCBC NISP', 'UOB', 'Commonwealth'])->nullable();
            $table->string('account_number')->nullable();
            $table->string('proof_of_transfer')->nullable();
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');

            $table->softDeletes();
            $table->timestamps();
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
