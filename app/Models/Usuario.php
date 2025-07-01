<?php



// app/Models/Usuario.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Usuario extends Model
{
    protected $table = 'usuarios';
    protected $primaryKey = 'id_usuario';
    public $timestamps = false;

    protected $fillable = [
        'nombre',
        'email',
        'password',
        'rol',
        'telefono',
        'estado'
    ];

    protected $hidden = ['password'];
    protected $dates = ['fecha_registro'];

    public function prestamos()
    {
        return $this->hasMany(Prestamo::class, 'id_usuario');
    }
}