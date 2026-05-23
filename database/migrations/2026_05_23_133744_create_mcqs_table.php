<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run migrations
     */
    public function up(): void
    {
        Schema::create('mcqs', function (Blueprint $table) {

            $table->id(); // Auto Increment Primary Key

            $table->foreignId('quiz_id')
                  ->constrained('quizzes')
                  ->onDelete('cascade');

            $table->text('question');

            // JSON Array for choices
            $table->json('choices');

            $table->timestamps(); // created_at and updated_at
        });
    }

    /**
     * Reverse migrations
     */
    public function down(): void
    {
        Schema::dropIfExists('mcqs');
    }
};