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
        Schema::create('family_members', function (Blueprint $table) {
            $table->uuid('id')->primary();

            $table->uuid('head_of_family_id');
            $table->foreign('head_of_family_id')->references('id')->on('head_of_families')->onDelete('cascade');

            $table->uuid('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

            $table->string('profile_picture')->nullable();
            $table->string('identity_number', 32)->unique();
            $table->enum('gender', ['male', 'female']);
            $table->date('date_of_birth')->nullable();
            $table->string('phone_number', 13)->nullable();
            $table->string('occupation')->nullable();
            $table->enum('marital_status', ['single', 'married', 'divorced', 'widowed']);
            $table->enum('relation', ['spouse', 'child', 'parent', 'sibling', 'wife', 'husband', 'other']);

            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('family_members');
    }
};
