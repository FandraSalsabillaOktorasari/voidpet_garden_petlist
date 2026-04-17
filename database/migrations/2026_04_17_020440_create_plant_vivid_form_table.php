<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('plant_vivid_form', function (Blueprint $table) {
            $table->id();
            $table->foreignId('plant_id')->constrained()->cascadeOnDelete();
            $table->foreignId('vivid_form_id')->constrained()->cascadeOnDelete();
            $table->timestamps();

            $table->unique(['plant_id', 'vivid_form_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('plant_vivid_form');
    }
};
