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
        Schema::dropIfExists('feedback_sub_categories');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::create('feedback_sub_categories', function (Blueprint $table) {
            // Define table schema if you want to recreate the table in the future
            $table->id();
            $table->string('name');
            // Add any other columns as needed
            $table->timestamps();
        });
    }
};
