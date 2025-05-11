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
        Schema::create('payements_users_commandes', function (Blueprint $table)
        {
            $table->engine = 'InnoDB';

            $table->unsignedBigInteger('commande_id');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('payement_id');

            $table->primary(['commande_id', 'user_id']);

        });


        Schema::table("payements_users_commandes", function (Blueprint $table)
        {
            $table->foreign("commande_id")->references("commande_id")->on("commandes")->onDelete("cascade");
            $table->foreign("user_id")->references("id")->on("users");
            $table->foreign("payement_id")->references("payement_id")->on("modes_payements")->onDelete("cascade");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('modespayements_users_commandes');

    }
};
