<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tb_propina extends Model
{
    use HasFactory;

    protected $table="tb_propinas";
    protected $fillable=['tb_propinas','monto_inicial','monto_final','monto','estado','fecha_update'];
}
