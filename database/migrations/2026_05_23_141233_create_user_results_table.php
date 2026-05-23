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
        Schema::create('user_results', function (Blueprint $table) {

            $table->id(); // Auto Increment Primary Key

            $table->foreignId('user_id')
                  ->constrained('users')
                  ->onDelete('cascade');

            $table->foreignId('quiz_id')
                  ->constrained('quizzes')
                  ->onDelete('cascade');

            // JSON array of answers
            $table->json('answers');

            $table->float('percentage');

            $table->boolean('passed');

            $table->integer('time_taken');

            $table->timestamps(); // created_at and updated_at
        });
    }

    /**
     * Reverse migrations
     */
    public function down(): void
    {
        Schema::dropIfExists('user_results');
    }
};