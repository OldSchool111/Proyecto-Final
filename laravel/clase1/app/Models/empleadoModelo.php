<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Tymon\JWTAuth\Contracts\JWTSubject;

class empleadoModelo extends Model implements JWTSubject
{
    use HasFactory;
    protected $table='empleadocliente';
    public $timestamps = false;
    protected $primaryKey ='idEmpleado';
    public $incrementing = true;
    protected $KeyType = 'int';
    protected $fillable=[
        'idEmpleado',
        'nombreEmpleado',
        'correoEmpleado',
        'passwordEmpleado'
    ];

    public function getJWTIdentifier()
    {
        // Debería devolver el ID del usuario o el campo que sea único en la base de datos
        return $this->getKey(); // Esto generalmente es el 'id' del usuario
    }
    public function getJWTCustomClaims()
    {
        // Puedes agregar reclamos personalizados si es necesario
        return [];
    }
}
