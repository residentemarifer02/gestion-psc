<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class HistorialPrecioProducto extends Model
{
    use HasFactory;

    protected $table = 'historial_precio_productos';

    protected $fillable = [
        'proveedor_producto_id',
        'precio',
        'fecha',
        'capturado_por',
        'observaciones',
    ];

    protected function casts(): array
    {
        return [
            'fecha' => 'date',
        ];
    }

    public function producto(): BelongsTo
    {
        return $this->belongsTo(ProveedorProducto::class, 'proveedor_producto_id');
    }

    public function capturadoPor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'capturado_por');
    }
}