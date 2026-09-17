<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('historial_precio_productos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('proveedor_producto_id')->constrained('proveedor_productos')->cascadeOnDelete();
            $table->decimal('precio', 12, 2);
            $table->date('fecha');
            $table->foreignId('capturado_por')->nullable()->constrained('users')->nullOnDelete();
            $table->string('observaciones')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('historial_precio_productos');
    }
};