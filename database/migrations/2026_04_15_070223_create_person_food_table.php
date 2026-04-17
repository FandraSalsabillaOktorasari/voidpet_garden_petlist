<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('person_food', function (Blueprint $table) {
            $table->id();
            $table->foreignId('person_id')->constrained('people')->cascadeOnDelete();
            $table->foreignId('food_id')->constrained('foods')->cascadeOnDelete();
            $table->integer('gift_value')->default(0);
            $table->integer('throw_value')->default(0);
            $table->timestamps();
            
            $table->unique(['person_id', 'food_id']);
        });
    }
    public function down(): void {
        Schema::dropIfExists('person_food');
    }
};
