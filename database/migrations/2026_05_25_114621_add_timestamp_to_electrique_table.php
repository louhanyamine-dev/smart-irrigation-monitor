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
    Schema::table('mesures_electrique', function (Blueprint $table) {
        $table->timestamp('timestamp')->nullable();
    });
}

public function down(): void
{
    Schema::table('mesures_electrique', function (Blueprint $table) {
        $table->dropColumn('timestamp');
    });
}
};
