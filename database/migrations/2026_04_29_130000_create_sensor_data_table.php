<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('sensor_data')) {
            return;
        }

        Schema::create('sensor_data', function (Blueprint $table) {
            $table->id();
            $table->string('device_id', 64)->default('esp32-main')->index();
            $table->decimal('pressure', 10, 3);
            $table->decimal('voltage', 8, 3);
            $table->timestamp('recorded_at')->nullable()->index();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sensor_data');
    }
};
