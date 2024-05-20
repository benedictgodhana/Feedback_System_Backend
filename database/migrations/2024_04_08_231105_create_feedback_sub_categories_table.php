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
        // Drop foreign key constraint before dropping the table
        Schema::table('feedback', function (Blueprint $table) {
            $table->dropForeign(['feedback_subcategory_id']);
        });

        Schema::dropIfExists('feedback_sub_categories');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::create('feedback_sub_categories', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('feedback_category_id');
            $table->string('name');
            $table->text('description')->nullable();
            $table->timestamps();

            // Foreign key relation
            $table->foreign('feedback_category_id')->references('id')->on('feedback_categories')->onDelete('cascade');
        });

        // Add back the foreign key constraint
        Schema::table('feedback', function (Blueprint $table) {
            $table->foreign('feedback_subcategory_id')->references('id')->on('feedback_sub_categories')->onDelete('cascade');
        });
    }
};
