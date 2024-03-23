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
        Schema::create('standings', function (Blueprint $table) {
            $table->id();
            $table->integer('fixture_id')->unsigned();
            $table->integer('team_id')->unsigned();
            $table->integer('points')->unsigned()->default(0);
            $table->integer('won')->unsigned()->default(0);
            $table->integer('drawn')->unsigned()->default(0);
            $table->integer('lost')->unsigned()->default(0);
            $table->integer('goal_difference')->unsigned()->default(0);

            $table->foreign('team_id')->references('id')->on('teams')->onDelete('CASCADE');
            $table->foreign('fixture_id')->references('id')->on('fixtures')->onDelete('CASCADE');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('standings');
    }
};
