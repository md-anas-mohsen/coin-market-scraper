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
        Schema::create('coins', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('code');
            $table->float('price')->nullable();
            $table->float('one_hr_percent')->nullable();
            $table->float('day_percent')->nullable();
            $table->float('week_percent')->nullable();
            $table->float('market_cap')->nullable();
            $table->float('volume')->nullable();
            $table->float('circulating_supply')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('coins');
    }
};
