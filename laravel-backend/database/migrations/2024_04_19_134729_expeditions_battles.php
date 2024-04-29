<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('expeditions', function (Blueprint $table) {
            $table->id();
            $table->string('status')->default('idle');
            $table->dateTime('started_at')->nullable();
            $table->dateTime('ended_at')->nullable();
            $table->integer('duration')->default(10);
            $table->float('metal')->default(0);
            $table->float('gas')->default(0);
            $table->float('gems')->default(0);
            $table->unsignedBigInteger('fleet_id')->nullable();
            $table->foreign('fleet_id')->references('id')->on('fleets')->nullOnDelete();
        });
        DB::statement("ALTER TABLE expeditions ADD CONSTRAINT expeditions_status_constraint CHECK (status IN ('idle', 'started', 'failed', 'succeeded'))");

        Schema::create('battles', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('opponent_id')->nullable();
            $table->unsignedBigInteger('fleet_id')->nullable();
            $table->foreign('opponent_id')->references('id')->on('fleets')->nullOnDelete();
            $table->foreign('fleet_id')->references('id')->on('fleets')->cascadeOnDelete();
            $table->boolean('won')->default(true);
            $table->integer('lost_ships')->default(0);
            $table->unsignedBigInteger('expedition_id')->nullable();
            $table->foreign('expedition_id')->references('id')->on('expeditions')->nullOnDelete();
            $table->boolean('finished')->default(false);
            $table->integer('fleet_strength')->nullable();
            $table->integer('opponent_strength')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('expeditions');
        Schema::dropIfExists('battles');

    }
};
