<?php

// app/Models/Autor.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Autor extends Model
{
    protected $table = 'autores';
    protected $primaryKey = 'id_autor';
    public $timestamps = false;

    protected $fillable = [
        'nombre_autor',
        'apellido_autor',
        'nacionalidad',
        'fecha_nacimiento',
        'biografia'
    ];

    protected $dates = ['fecha_nacimiento'];

    public function libros()
    {
        return $this->hasMany(Libro::class, 'id_autor');
    }

    public function getNombreCompletoAttribute()
    {
        return $this->nombre_autor . ' ' . $this->apellido_autor;
    }
}