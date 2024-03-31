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
        Schema::table('armies', function (Blueprint $table){
            $table->dropColumn('ships');
            $table->dropColumn('broken_ships');
            $table->integer('transporter')->default(0);
            $table->integer('light_fighter')->default(0);;
            $table->integer('heavy_fighter')->default(0);;
            $table->integer('cruiser')->default(0);;
            $table->integer('battleships')->default(0);;
        });

        Schema::table('troops', function (Blueprint $table){
            $table->dropColumn('ships');
            $table->dropColumn('broken_ships');
            $table->integer('transporter')->default(0);;
            $table->integer('light_fighter')->default(0);;
            $table->integer('heavy_fighter')->default(0);;
            $table->integer('cruiser')->default(0);;
            $table->integer('battleships')->default(0);;
        });

        Schema::create('ship_types', function(Blueprint $table){
            $table->id();
            $table->string('type')->unique();
            $table->integer('health')->default(200);
            $table->integer('armor')->default(200);
            $table->integer('damage')->default(50);
        });
        DB::statement("ALTER TABLE ship_types ADD CONSTRAINT ship_types_type_constraint
                            CHECK (type IN ('transporter',
                                            'light_fighter',
                                            'heavy_fighter',
                                            'cruiser',
                                            'battleship')
                                )
                        ");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {

    }
};
