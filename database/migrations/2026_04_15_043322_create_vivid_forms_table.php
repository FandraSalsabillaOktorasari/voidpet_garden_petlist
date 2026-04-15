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
        Schema::create('vivid_forms', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('box_type'); // void, water, metal, fire, earth, wood
            $table->string('rarity'); // rare, fable, mythical, absurd
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vivid_forms');
    }
};
