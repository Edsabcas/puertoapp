<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Descuento extends Model
{
    use HasFactory;
    protected $fillable = ['id_descuentop','id_empleado','descripcion','monto','id_mes_descuento','fecha_ingreso','cobro_efectuado'];
}
