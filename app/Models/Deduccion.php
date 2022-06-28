<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Deduccion extends Model
{
    use HasFactory;
    protected $fillable = ['id_deducciones', 'id_empleado', 'iggs_laboral', 'isr', 'descuentos_judiciales','otros2','fecha_ingreso'];

}
