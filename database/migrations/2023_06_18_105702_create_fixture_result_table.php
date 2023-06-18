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
        Schema::create('fixture_result', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('fixture_id');

            $table->unsignedInteger('home_team_id');
            $table->unsignedInteger('away_team_id');

            $table->integer('home_team_score');
            $table->integer('away_team_score');
            $table->integer('week');
            $table->enum('result', ['win', 'draw', 'loss'])->nullable()->default(null);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fixture_result');
    }
};
