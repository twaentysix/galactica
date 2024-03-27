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
        Schema::create('galaxies', function (Blueprint $table) {
            $table->id();
            $table->string('name');
        });

        Schema::create('planets', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('galaxy_id'); // Assuming PersonID is an unsigned big integer
            $table->foreign('galaxy_id')->references('id')->on('galaxies')->onDelete('cascade');
            $table->string('name');
        });

        Schema::create('bases', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('planet_id'); // Assuming PersonID is an unsigned big integer
            $table->foreign('planet_id')->references('id')->on('planets')->onDelete('cascade');
            $table->integer('level');
            $table->dateTime('created_at');
            $table->dateTime('last_upgraded_at');
        });

        Schema::create('base_resources', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('base_id'); // Assuming PersonID is an unsigned big integer
            $table->foreign('base_id')->references('id')->on('bases')->onDelete('cascade');
            $table->integer('metal');
            $table->integer('cristal');
            $table->integer('gas');
        });

        Schema::create('armies', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('base_id'); // Assuming PersonID is an unsigned big integer
            $table->foreign('base_id')->references('id')->on('bases')->onDelete('cascade');
            $table->integer('ships');
            $table->integer('broken_ships');
        });

        Schema::create('troops', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('army_id'); // Assuming PersonID is an unsigned big integer
            $table->foreign('army_id')->references('id')->on('armies')->onDelete('cascade');
            $table->integer('ships');
            $table->integer('broken_ships');
        });

        Schema::create('collectors', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('base_id'); // Assuming PersonID is an unsigned big integer
            $table->foreign('base_id')->references('id')->on('bases')->onDelete('cascade');
            $table->enum('type', ['metal', 'cristal', 'gas']);
            $table->dateTime('last_collected');
            $table->integer('level');
            $table->integer('rate_per_hour');
        });

        DB::statement("ALTER TABLE collectors ADD CONSTRAINT collectors_type_constraint CHECK (type IN ('metal', 'gas', 'cristal'))");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('collectors');
        Schema::dropIfExists('bases');
        Schema::dropIfExists('base_resources');
        Schema::dropIfExists('troops');
        Schema::dropIfExists('armies');
        Schema::dropIfExists('planet');
        Schema::dropIfExists('galaxies');
    }
};
