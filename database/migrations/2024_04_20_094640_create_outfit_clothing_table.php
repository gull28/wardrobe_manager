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
        Schema::create('outfit_clothing', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->foreignId('outfit_id')->constrained('outfit');
            $table->foreignId('clothing_id')->constrained();
            $table->string('category');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('outfit_clothing');
    }
};
