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
        Schema::create('user_pets', function (Blueprint $table) {
            $table->id();
            $table->foreignId('species_id')->constrained('species')->cascadeOnDelete();
            $table->foreignId('vivid_form_id')->nullable()->constrained('vivid_forms')->nullOnDelete();
        
            $table->string('nickname')->nullable();
            $table->json('element')->nullable(); // Elemen bisa array untuk multi element
            $table->integer('stage')->default(1);
            $table->integer('level')->default(1);
            $table->boolean('is_favorite')->default(false); // Fitur safe lock
        
            // Bonus Stats
            $table->integer('intensity')->default(0);
            $table->integer('clarity')->default(0);
            $table->integer('stability')->default(0);
        
            // Battle Stats
            $table->integer('hp')->default(0);
            $table->integer('focus')->default(0);
            $table->integer('calm')->default(0);
            $table->integer('speed')->default(0);
            $table->integer('balance')->default(0);
            $table->integer('strength')->default(0);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_pets');
    }
};
