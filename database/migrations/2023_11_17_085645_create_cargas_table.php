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
        Schema::create('cargas', function (Blueprint $table) {
            $table->id();
            $table->string('id_referencia');
            $table->string('observacion');
            $table->decimal('total', 10, 2);
            $table->integer('nro_factura');
            $table->date('fecha_venta');
            $table->string('razon_social');
            $table->string('nit');
            $table->decimal('cantidad', 10, 2);
            $table->decimal('precio', 10, 2);

            $table->decimal('factor', 10, 2)->default(1);
            $table->decimal('puntos', 10, 2)->default(0);

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
        Schema::dropIfExists('cargas');
    }
};
