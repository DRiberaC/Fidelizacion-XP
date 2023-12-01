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
        Schema::create('recompensa_historial', function (Blueprint $table) {
            $table->id();

            $table->string('tipo');
            $table->integer('cantidad');
            $table->string('detalle')->nullable();

            $table->unsignedBigInteger('recompensa_id')->nullable();
            $table->foreign('recompensa_id')->references('id')->on('recompensas')->onDelete('cascade');

            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('recompensa_historials');
    }
};
