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
            $table->string('name')->unique(true)->nullable(false);
        });

        Schema::create('planets', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('galaxy_id')->nullable();
            $table->foreign('galaxy_id')->references('id')->on('galaxies')->onDelete('cascade');
            $table->string('name');
        });

        Schema::create('bases', function (Blueprint $table) {
            $table->id();
            $table->integer('level')->default(1)->nullable(false);
            $table->dateTime('created_at')->nullable();
            $table->dateTime('last_upgraded_at')->nullable();
            $table->string('name')->nullable(false);

            $table->unsignedBigInteger('planet_id')->nullable();
            $table->foreign('planet_id')->references('id')->on('planets')->onDelete('cascade');

            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

        });

        Schema::create('base_resources', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('base_id')->nullable();
            $table->foreign('base_id')->references('id')->on('bases')->onDelete('cascade');
            $table->float('metal')->default(0)->nullable(false);
            $table->float('gems')->default(0)->nullable(false);
            $table->float('gas')->default(0)->nullable(false);
        });

        Schema::create('harbours', function (Blueprint $table) {
            $table->id();
            $table->integer('ships')->default(0)->nullable();
            $table->integer('broken_ships')->nullable();

            $table->unsignedBigInteger('base_id')->nullable(); // Assuming PersonID is an unsigned big integer
            $table->foreign('base_id')->references('id')->on('bases')->onDelete('cascade');

        });

        Schema::create('fleets', function (Blueprint $table) {
            $table->id();
            $table->integer('ships')->default(0)->nullable();
            $table->integer('broken_ships')->nullable();

            $table->unsignedBigInteger('harbour_id')->nullable();
            $table->foreign('harbour_id')->references('id')->on('harbours')->onDelete('cascade');

            $table->string('name')->nullable(false);
        });

        Schema::create('collectors', function (Blueprint $table) {
            $table->id();
            $table->enum('type', ['metal', 'gems', 'gas'])->nullable(false);
            $table->dateTime('last_collected')->nullable();
            $table->integer('level')->default(1)->nullable(false);

            $table->unsignedBigInteger('base_id')->nullable();
            $table->foreign('base_id')->references('id')->on('bases')->onDelete('cascade');

        });

        DB::statement("ALTER TABLE collectors ADD CONSTRAINT collectors_type_constraint CHECK (type IN ('metal', 'gas', 'gems'))");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('collectors');
        Schema::dropIfExists('bases');
        Schema::dropIfExists('base_resources');
        Schema::dropIfExists('fleets');
        Schema::dropIfExists('harbours');
        Schema::dropIfExists('planet');
        Schema::dropIfExists('galaxies');
    }
};
