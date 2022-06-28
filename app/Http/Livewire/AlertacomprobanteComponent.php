<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\DB;

class AlertacomprobanteComponent extends Component
{
    public function render()
    {
        $anio=date("Y");
        $mes=date("m");
        $dia=date("d");
        $sql = "SELECT * FROM tb_pedidos where  cancelado=0 and YEAR(FECHA_CREACION_PEDIDO)=? and MONTH(FECHA_CREACION_PEDIDO)=? and DAY(FECHA_CREACION_PEDIDO)=?";
        $pedidos= DB::select($sql,array($anio,$mes,$dia));
        $sql = "SELECT * FROM tb_mesas  where ESTADO=1 AND  disponible=1";
        $mesas= DB::select($sql);
        return view('livewire.alertacomprobante-component',compact('mesas','pedidos'));
    }
    public function alerta($id){
        $anio=date("Y");
        $mes=date("m");
        $dia=date("d");
        $sql = "SELECT * FROM tb_pedidos where ESTADO_PEDIDO=3 and cancelado=0 and ID_MESA=?  and YEAR(FECHA_CREACION_PEDIDO)=? and MONTH(FECHA_CREACION_PEDIDO)=? and DAY(FECHA_CREACION_PEDIDO)=?";
        $pedidos= DB::select($sql,array($id,$anio,$mes,$dia));
        $idpe=0;
        foreach($pedidos as $pedid){
            $idpe=$pedid->ID_PEDIDO;
        }
        DB::beginTransaction();
        if(DB::table('tb_pedidos')
            ->where('ID_PEDIDO', $idpe)
            ->update(
                [
                 'cancelado' => 1,
                 'FECHA_CREACION_PEDIDO' =>date('Y-m-d H:i:s'),
                ]))
              {
                  DB::commit();
                  session()->forget('estado'); 
                  session(['estado' => ' Asignadas Correctamente.']);
                  $this->reset();
                 
    
              }else{
                  DB::rollback();
                  session(['error' => 'validar']);
              }
    }
}
