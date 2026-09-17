<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Proveedor extends Model
{
    use HasFactory;

    protected $table = 'proveedores';

    protected $fillable = [
        'nombre',
        'direccion',
        'horarios_trabajo',
        'contacto_telefono',
        'contacto_email',
    ];

    public function productos(): HasMany
    {
        return $this->hasMany(ProveedorProducto::class);
    }
}