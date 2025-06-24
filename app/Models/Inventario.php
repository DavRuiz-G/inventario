<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Inventario extends Model
{
    protected $table = 'inventario';
    protected $fillable = ['producto_id', 'stock'];

    public function producto()
    {
        return $this->belongsTo(Producto::class, 'producto_id');
    }

    // Actualiza stock al registrar entrada
    public function registrarEntrada($cantidad)
    {
        $this->stock += $cantidad;
        $this->save();
    }

    // Actualiza stock al registrar salida
    public function registrarSalida($cantidad)
    {
        $this->stock -= $cantidad;
        $this->save();
    }
}