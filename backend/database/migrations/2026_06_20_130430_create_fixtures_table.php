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
            $table->unsignedInteger('week');
            $table->foreignId('home_team_id')->constrained('teams');
            $table->foreignId('away_team_id')->constrained('teams');
            $table->unsignedInteger('home_goals')->nullable();
            $table->unsignedInteger('away_goals')->nullable();
            $table->boolean('played')->default(false);
            $table->timestamps();
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
