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
            $table->string('name', 240);
            $table->string('expansion', 240);
            $table->string('army_type', 240);
            $table->json('unique_unit');
            $table->json('unique_tech');
            $table->string('team_bonus');
            $table->json('civilization_bonus');
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
