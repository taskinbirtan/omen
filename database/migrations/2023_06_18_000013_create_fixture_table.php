<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('fixture', function (Blueprint $table) {

            $table->id();
            $table->unsignedInteger('pot_id');
            $table->foreignId('home_team_id')->constrained('team');
            $table->foreignId('away_team_id')->constrained('team');
            $table->integer('home_team_score')->nullable();
            $table->integer('away_team_score')->nullable();
            $table->dateTime('date');
            $table->boolean('played')->default(false);
            $table->integer('week');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fixture');
    }
};
