<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Empleado extends Model
{
    use HasFactory;

    protected $fillable =['id','NoEmpleado','Primer_Nombre','Segundo_Nombre','Primer_Apellido','Segundo_Apellido','DPI','Puesto','Estado','Fecha_ingreso','Correo'];
}
