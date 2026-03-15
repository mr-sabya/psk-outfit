<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('ad_banners', function (Blueprint $table) {
            // Adding a nullable text column after the 'title' column
            $table->text('banner_text')->nullable()->after('title');
        });
    }

    public function down(): void
    {
        Schema::table('ad_banners', function (Blueprint $table) {
            // Dropping the column if migration is rolled back
            $table->dropColumn('banner_text');
        });
    }
};
