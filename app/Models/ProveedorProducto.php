<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ProveedorProducto extends Model
{
    use HasFactory;

    protected $fillable = [
        'proveedor_id',
        'nombre_producto',
        'precio_referencia',
    ];

    public function proveedor(): BelongsTo
    {
        return $this->belongsTo(Proveedor::class);
    }

    public function historialPrecios(): HasMany
    {
        return $this->hasMany(HistorialPrecioProducto::class, 'proveedor_producto_id')
            ->orderByDesc('fecha')
            ->orderByDesc('id');
    }
}