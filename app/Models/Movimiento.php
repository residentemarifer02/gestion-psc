<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Movimiento extends Model
{
    use HasFactory;

    protected $table = 'movimientos';

    protected $fillable = [
        'cliente_id',
        'proveedor_id',
        'usuario_id',
        'fecha',
        'hora',
        'tipo',
        'orden_compra',
        'concepto',
        'unidades',
        'pago',
        'unitario',
        'cuenta',
        'descripcion',
        'especifico',
        'facturacion',
        'empresa_facturacion',
        'monto',
        'observaciones',
    ];

    protected function casts(): array
    {
        return [
            'fecha' => 'date',
        ];
    }

    public function cliente(): BelongsTo
    {
        return $this->belongsTo(Cliente::class);
    }

    public function proveedor(): BelongsTo
    {
        return $this->belongsTo(Proveedor::class);
    }

    public function usuario(): BelongsTo
    {
        return $this->belongsTo(User::class, 'usuario_id');
    }
}