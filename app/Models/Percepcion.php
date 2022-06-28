<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Percepcion extends Model
{
    use HasFactory;
    protected $fillable = ['id_per', 'id_empleadop', 'salario_ordinario', 'bonificacion_mensual', 'fecha_asignacion','fecha_asignacion'];

}
