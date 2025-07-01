<?php

// app/Models/Prestamo.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Prestamo extends Model
{
    protected $table = 'tbl_prestamos';
    protected $primaryKey = 'id_prestamo';
    public $timestamps = false;

    protected $fillable = [
        'id_usuario',
        'id_libro',
        'fecha_prestamo',
        'fecha_devolucion_estimada',
        'fecha_devolucion_real',
        'estado',
        'multa',
        'observaciones'
    ];

    protected $dates = [
        'fecha_prestamo',
        'fecha_devolucion_estimada',
        'fecha_devolucion_real'
    ];

    // Relationships
    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'id_usuario');
    }

    public function libro()
    {
        return $this->belongsTo(Libro::class, 'id_libro');
    }
}