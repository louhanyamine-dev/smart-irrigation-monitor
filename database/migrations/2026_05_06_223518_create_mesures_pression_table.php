<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('mesures_pression', function (Blueprint $table) {
            $table->id();
            $table->float('pression1')->default(0);
            $table->float('pression2')->default(0);
            $table->float('voltage1')->default(0);
            $table->float('voltage2')->default(0);
            $table->string('device_id', 64)->default('esp32-main');
            $table->timestamp('recorded_at')->useCurrent();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('mesures_pression');
    }
};
