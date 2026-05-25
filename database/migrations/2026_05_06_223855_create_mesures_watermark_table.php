<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('mesures_watermark', function (Blueprint $table) {
            $table->id();
            $table->float('watermark1')->default(0);
            $table->float('watermark2')->default(0);
            $table->float('watermark3')->default(0);
            $table->string('device_id', 64)->default('esp32-main');
            $table->timestamp('recorded_at')->useCurrent();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('mesures_watermark');
    }
};
