<?php

// app/Models/Categoria.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Categoria extends Model
{
    protected $table = 'categorias';
    protected $primaryKey = 'id_categoria';
    public $timestamps = false;

    protected $fillable = ['nombre_categoria', 'descripcion'];
    protected $dates = ['fecha_creacion'];

    public function libros()
    {
        return $this->hasMany(Libro::class, 'id_categoria');
    }
}