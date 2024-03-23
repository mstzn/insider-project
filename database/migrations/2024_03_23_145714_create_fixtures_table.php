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
        Schema::create('fixtures', function (Blueprint $table) {
            $table->id();
            $table->integer('week')->unsigned();
            $table->integer('home_team_id')->unsigned();
            $table->integer('away_team_id')->unsigned();
            $table->integer('season_id')->unsigned();
            $table->integer('home_team_score')->nullable()->unsigned();
            $table->integer('away_team_score')->nullable()->unsigned();
            $table->timestamps();

            $table->foreign('home_team_id')->references('id')->on('teams')->onDelete('CASCADE');
            $table->foreign('away_team_id')->references('id')->on('teams')->onDelete('CASCADE');
            $table->foreign('season_id')->references('id')->on('seasons')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fixtures');
    }
};
