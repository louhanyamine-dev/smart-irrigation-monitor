<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
 public function up() {
    Schema::table('mesures_watermark', function (Blueprint $table) {
        $table->double('watermark4')->default(0)->after('watermark3');
        $table->double('watermark5')->default(0)->after('watermark4');
        $table->double('watermark6')->default(0)->after('watermark5');
    });
}

public function down() {
    Schema::table('mesures_watermark', function (Blueprint $table) {
        $table->dropColumn(['watermark4', 'watermark5', 'watermark6']);
    });
}
};
