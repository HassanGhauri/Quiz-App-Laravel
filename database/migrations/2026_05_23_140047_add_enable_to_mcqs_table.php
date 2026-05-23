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
        Schema::table('mcqs', function (Blueprint $table) {

            $table->boolean('enable')
                  ->default(1)
                  ->after('choices');

        });
    }

    /**
     * Reverse migrations
     */
    public function down(): void
    {
        Schema::table('mcqs', function (Blueprint $table) {

            $table->dropColumn('enable');

        });
    }
};