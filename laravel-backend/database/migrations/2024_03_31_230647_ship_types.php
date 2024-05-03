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
        Schema::table('harbours', function (Blueprint $table){
            $table->dropColumn('ships');
            $table->dropColumn('broken_ships');
            $table->integer('transporter')->default(0);
            $table->integer('light_fighter')->default(0);;
            $table->integer('heavy_fighter')->default(0);;
            $table->integer('cruiser')->default(0);;
            $table->integer('battleships')->default(0);;
        });

        Schema::table('fleets', function (Blueprint $table){
            $table->dropColumn('ships');
            $table->dropColumn('broken_ships');
            $table->integer('transporter')->default(0);;
            $table->integer('light_fighter')->default(0);;
            $table->integer('heavy_fighter')->default(0);;
            $table->integer('cruiser')->default(0);;
            $table->integer('battleships')->default(0);;
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {

    }
};
