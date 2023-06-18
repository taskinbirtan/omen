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
        Schema::create('pot', function (Blueprint $table) {

            $table->id();
            $table->string('name', 10);
            $table->unsignedInteger('index')->nullable();
            $table->string('slug', 10)->nullable();
            $table->enum('type', ['group', 'knockout'])->default('group');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pot');
    }
};
