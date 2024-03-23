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
        Schema::create('games', function (Blueprint $table) {
            $table->id();
            $table->integer('fixture_id')->unsigned();
            $table->integer('home_team_id')->unsigned();
            $table->integer('away_team_id')->unsigned();
            $table->integer('home_team_score')->nullable()->unsigned();
            $table->integer('away_team_score')->nullable()->unsigned();
            $table->integer('week')->unsigned();
            $table->boolean('is_played')->default(false);

            $table->foreign('home_team_id')->references('id')->on('teams')->onDelete('CASCADE');
            $table->foreign('away_team_id')->references('id')->on('teams')->onDelete('CASCADE');
            $table->foreign('fixture_id')->references('id')->on('fixtures')->onDelete('CASCADE');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('games');
    }
};
