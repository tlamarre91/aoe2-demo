<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCivilizationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('civilizations', function (Blueprint $table) {
            $table->id();
            $table->string('name', 240)->nullable();
            $table->string('expansion', 240)->nullable();
            $table->string('army_type', 240)->nullable();
            $table->json('unique_unit')->nullable();
            $table->json('unique_tech')->nullable();
            $table->string('team_bonus')->nullable();
            $table->json('civilization_bonus')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('civilizations');
    }
}
