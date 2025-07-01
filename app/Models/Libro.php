<?php
// app/Models/Libro.php


namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Libro extends Model
{
    protected $table = 'tbl_libros';
    protected $primaryKey = 'id_libro';
    public $timestamps = false;

    protected $fillable = [
        'titulo',
        'isbn',
        'id_autor',
        'id_categoria',
        'editorial',
        'año_publicacion',
        'numero_paginas',
        'cantidad_total',
        'cantidad_disponible',
        'ubicacion',
        'descripcion',
        'estado'
    ];

    protected $dates = ['fecha_registro'];

    // Relationships
    public function autor()
    {
        return $this->belongsTo(Autor::class, 'id_autor');
    }

    public function categoria()
    {
        return $this->belongsTo(Categoria::class, 'id_categoria');
    }

    public function prestamos()
    {
        return $this->hasMany(Prestamo::class, 'id_libro');
    }
}