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
    Schema::create('pressions', function (Blueprint $table) {
        $table->id();
        $table->float('valeur');      // pression en kPa
        $table->float('voltage');     // tension capteur
        $table->timestamps();         // created_at, updated_at
    });
}
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pressions');
    }
};
