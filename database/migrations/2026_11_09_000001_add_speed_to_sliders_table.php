<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('sliders', function (Blueprint $table) {
            $table->string('speed_value', 20)->nullable()->after('button_link');
            $table->string('speed_unit', 20)->nullable()->after('speed_value');
            $table->string('download', 30)->nullable()->after('speed_unit');
            $table->string('upload', 30)->nullable()->after('download');
            $table->string('latency', 30)->nullable()->after('upload');
        });
    }

    public function down(): void
    {
        Schema::table('sliders', function (Blueprint $table) {
            $table->dropColumn(['speed_value', 'speed_unit', 'download', 'upload', 'latency']);
        });
    }
};
