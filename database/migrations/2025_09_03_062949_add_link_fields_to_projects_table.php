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
        Schema::table('projects', function (Blueprint $table) {
            $table->text('embed_url')->nullable()->after('demo_url'); // Untuk Figma, Sketchfab, dll.
            $table->text('source_url')->nullable()->after('embed_url'); // Untuk GDrive, GitHub Repo ZIP
        });
    }

    public function down(): void
    {
        Schema::table('projects', function (Blueprint $table) {
            $table->dropColumn(['embed_url', 'source_url']);
        });
    }
};
