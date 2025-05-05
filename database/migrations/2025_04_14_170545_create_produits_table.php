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
        Schema::create('produits', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->bigIncrements('produit_id');
            $table->string('produit_nom');
            $table->string('produit_description');
            $table->decimal('produit_prix', 10, 2);
            $table->string('produit_image');
            });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('produits');
    }
};
