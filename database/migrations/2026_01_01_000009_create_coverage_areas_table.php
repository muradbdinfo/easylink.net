<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('coverage_areas', function (Blueprint $table) {
            $table->id();
            $table->string('district');
            $table->string('upazilla');
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->unique(['district', 'upazilla']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('coverage_areas');
    }
};
