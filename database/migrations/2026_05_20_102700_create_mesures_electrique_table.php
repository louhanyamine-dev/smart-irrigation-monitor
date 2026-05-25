<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('mesures_electrique', function (Blueprint $table) {
            $table->id();
            $table->float('courant1')->default(0);
            $table->float('courant2')->default(0);
            $table->float('courant3')->default(0);
            $table->float('tension1')->default(0);
            $table->float('tension2')->default(0);
            $table->float('pression')->default(0);
            $table->string('device_id', 64)->default('esp32-electrique');
            $table->integer('rssi')->nullable();
            $table->timestamp('recorded_at')->useCurrent();
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('mesures_electrique');
    }
};
