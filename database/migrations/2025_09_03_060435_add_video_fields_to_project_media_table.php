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
        Schema::table('project_media', function (Blueprint $table) {
            $table->string('file_name')->nullable()->after('file_path'); // Original file name
            $table->text('embed_url')->nullable()->after('file_type'); // For YouTube/Vimeo links
        });
    }
    public function down(): void
    {
        Schema::table('project_media', function (Blueprint $table) {
            $table->dropColumn(['file_name', 'embed_url']);
        });
    }
};
