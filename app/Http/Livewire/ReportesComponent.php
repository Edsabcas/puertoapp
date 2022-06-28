<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\DB;
use PDF;

class ReportesComponent extends Component
{
    public $venta_total,
    $total_cevicheria,
    $total_personal,
    $sub_total,
    $total_propina,
    $total_dia,
    $total_tc_sin_rec,$monto_recargo;
    public $total_efe;
    public $anio,$mes,$dia;
    public $fecha_se,$fecha_busqueda;
    public $mesero_con;
    public function render()
    {
        if(session('rolus')==1){

      
        if($this->fecha_busqueda!=null){
            $fech = explode("-", $this->fecha_busqueda);
            $this->anio=$fech[0];
            $this->mes=$fech[1];
            $this->dia=$fech[2];

            $anio=$this->anio;
            $mes=$this->mes;
            $dia=$this->dia;
            $sql = "SELECT * FROM tb_pedidos where ESTADO_PEDIDO=3 AND CIERRE=0 and YEAR(FECHA_CREACION_PEDIDO)=? and MONTH(FECHA_CREACION_PEDIDO)=? and DAY(FECHA_CREACION_PEDIDO)=?";
            $pedidos= DB::select($sql,array($anio,$mes,$dia));
    
            $sql = "SELECT * FROM tb_categoria_platillo where ESTADO=1";
            $categorias= DB::select($sql);
    
            $sql = "SELECT * FROM tb_platillos WHERE eliminado=0";
            $platillos= DB::select($sql);
    
            $sql = "SELECT * FROM tb_bebidas where eliminado=0";
            $bebidas= DB::select($sql);
    
            $sql = "SELECT * FROM tb_mesas";
            $mesas= DB::select($sql);
    
            $sql = "SELECT * FROM tb_detalle_pedidos where CIERRE=0 AND PAGO=1 and YEAR(FECHA_DETALLE_EXTRA)=? and MONTH(FECHA_DETALLE_EXTRA)=? and DAY(FECHA_DETALLE_EXTRA)=?";
            $detalle_pe= DB::select($sql,array($anio,$mes,$dia));
    
            $sql = "SELECT * FROM users";
            $usuarios= DB::select($sql);

                    $sum_pedidos = DB::table('tb_pagos_pedidos')
                    ->select(DB::raw('round(sum(MONTO_CUENTA + 0.0000000001),2)-(ROUND(sum(MONTO_RECARGO_POS + 0.0000000001),2)+ROUND(sum(MONTO_PROPINA + 0.0000000001),2)) as Total'))
                    ->where('CANCELADO','=', 3)
                    ->where('tb_pagos_pedidos.CIERRE','=', 0)
                    ->where('TIPO_PEDIDO','<=', 3)
                    ->where(DB::raw('YEAR(FECHA_COBRO_PEDIDO)'), $anio)
                    ->where(DB::raw('MONTH(FECHA_COBRO_PEDIDO)'), $mes)
                    ->where(DB::raw('DAY(FECHA_COBRO_PEDIDO)'), $dia)
                // ->groupBy('FECHA_COBRO_PEDIDO')
                    ->get();

                    foreach($sum_pedidos as $sum_pedido){
                        $this->venta_total=$sum_pedido->Total;
                    }

            
                    $sum_cev= DB::table('tb_detalle_pedidos')
                    ->join('tb_platillos', 'tb_detalle_pedidos.ID_PLATILLO', '=', 'tb_platillos.ID_PLATILLO')
                    ->join('tb_pagos_pedidos', 'tb_detalle_pedidos.ID_PEDIDIO', '=', 'tb_pagos_pedidos.ID_PEDIDO')
                    ->join('tb_categoria_platillo', 'tb_categoria_platillo.ID_CATEGORIA', '=', 'tb_platillos.ID_CATEGORIA')
                    ->join('tb_areas', 'tb_categoria_platillo.ID_AREA', '=', 'tb_areas.ID_AREA')
                    ->select(DB::raw('round(sum(tb_detalle_pedidos.SUB_TOTAL),2)as Monto_cev'))
                    ->where(DB::raw('YEAR(FECHA_DETALLE_EXTRA)'), $anio)
                    ->where(DB::raw('MONTH(FECHA_DETALLE_EXTRA)'), $mes)
                    ->where(DB::raw('DAY(FECHA_DETALLE_EXTRA)'), $dia)
                    ->where('tb_areas.ID_AREA','=', 1)
                    ->where('tb_detalle_pedidos.CIERRE','=', 0)
                    ->where('tb_pagos_pedidos.TIPO_PEDIDO','<=', 3)
                    ->get();

                    foreach($sum_cev as $sum_ce){
                        $this->total_cevicheria=$sum_ce->Monto_cev;
                    }
    
    
                     $sum_pedidos_dl_personal = DB::table('tb_pagos_pedidos')
                     ->select(DB::raw('ROUND(sum(MONTO_CUENTA + 0.0000000001),2) as Total'))
                     ->where('CANCELADO','=', 3)
                     ->where('tb_pagos_pedidos.CIERRE','=', 0)
                     ->where('TIPO_PEDIDO','=', 4)
                     ->where(DB::raw('YEAR(FECHA_COBRO_PEDIDO)'), $anio)
                     ->where(DB::raw('MONTH(FECHA_COBRO_PEDIDO)'), $mes)
                     ->where(DB::raw('DAY(FECHA_COBRO_PEDIDO)'), $dia)
                    // ->groupBy('FECHA_COBRO_PEDIDO')
                     ->get();

                     foreach($sum_pedidos_dl_personal as $sum_pedidos_dl_persona)
                     {
                        $this->total_personal=$sum_pedidos_dl_persona->Total;
                     }

                     $sum_monto_reca_tc = DB::table('tb_pagos_pedidos')
                     ->select(DB::raw('ROUND(sum(MONTO_RECARGO_POS + 0.0000000001),2) as Total'))
                     ->where('CANCELADO','=', 3)
                     ->where('tb_pagos_pedidos.CIERRE','=', 0)
                     ->where(DB::raw('YEAR(FECHA_COBRO_PEDIDO)'), $anio)
                     ->where(DB::raw('MONTH(FECHA_COBRO_PEDIDO)'), $mes)
                     ->where(DB::raw('DAY(FECHA_COBRO_PEDIDO)'), $dia)
                    // ->groupBy('FECHA_COBRO_PEDIDO')
                     ->get();  

                     foreach($sum_monto_reca_tc as $sum_monto_reca_t){
                        $this->monto_recargo=$sum_monto_reca_t->Total;
                     }



                     $sum_prop = DB::table('tb_pagos_pedidos')
                     ->select(DB::raw('ROUND(sum(MONTO_PROPINA + 0.0000000001),2) as Total'))
                     ->where('CANCELADO','=', 3)
                     ->where('tb_pagos_pedidos.CIERRE','=', 0)
                     ->where(DB::raw('YEAR(FECHA_COBRO_PEDIDO)'), $anio)
                     ->where(DB::raw('MONTH(FECHA_COBRO_PEDIDO)'), $mes)
                     ->where(DB::raw('DAY(FECHA_COBRO_PEDIDO)'), $dia)
                    // ->groupBy('FECHA_COBRO_PEDIDO')
                     ->get();    

                     foreach($sum_prop as $sum_pro){
                        $this->total_propina=$sum_pro->Total;
                     }
    
                     $monto_tc = DB::table('tb_pagos_pedidos')
                     ->select(DB::raw('ROUND(sum(MONTO_CUENTA + 0.0000000001),2)-ROUND(sum(MONTO_RECARGO_POS + 0.0000000001),2) as Total'))
                     ->where('CANCELADO','=', 3)
                     ->where('tb_pagos_pedidos.CIERRE','=', 0)
                     ->where('tb_pagos_pedidos.FORMA_PAGO','=', 2)
                     ->where(DB::raw('YEAR(FECHA_COBRO_PEDIDO)'), $anio)
                     ->where(DB::raw('MONTH(FECHA_COBRO_PEDIDO)'), $mes)
                     ->where(DB::raw('DAY(FECHA_COBRO_PEDIDO)'), $dia)
                    // ->groupBy('FECHA_COBRO_PEDIDO')
                     ->get(); 
                     
                     foreach($monto_tc as $monto_t)
                     {
                        $this->total_tc_sin_rec=$monto_t->Total;
                     }

                     //Total TC tipo pago 3
                     $sql = "SELECT ROUND(sum(MONTO_TC + 0.0000000001),2)-ROUND(sum(MONTO_RECARGO_POS + 0.0000000001),2) AS Total FROM tb_pagos_pedidos where cierre=0 and FORMA_PAGO=3 and YEAR(FECHA_COBRO_PEDIDO)=? and MONTH(FECHA_COBRO_PEDIDO)=? and DAY(FECHA_COBRO_PEDIDO)=?";
                     $tc_2s= DB::select($sql,array($anio,$mes,$dia));
                     foreach($tc_2s as $efe_)
                     {
                        $this->total_tc_sin_rec=$this->total_tc_sin_rec+$efe_->Total;
                     }

                     //Suma de lo efectivo
                     $monto_ef = DB::table('tb_pagos_pedidos')
                     ->select(DB::raw('ROUND(sum(MONTO_CUENTA + 0.0000000001),2) as Total'))
                     ->where('CANCELADO','=', 3)
                     ->where('tb_pagos_pedidos.CIERRE','=', 0)
                     ->where('tb_pagos_pedidos.FORMA_PAGO','=', 1)
                     ->where(DB::raw('YEAR(FECHA_COBRO_PEDIDO)'), $anio)
                     ->where(DB::raw('MONTH(FECHA_COBRO_PEDIDO)'), $mes)
                     ->where(DB::raw('DAY(FECHA_COBRO_PEDIDO)'), $dia)
                    // ->groupBy('FECHA_COBRO_PEDIDO')
                     ->get(); 
                     
                     foreach($monto_ef as $monto_e)
                     {
                        $this->total_efe=$monto_e->Total;
                     }
                     $sql = "SELECT round(sum(MONTO_CUENTA + 0.0000000001),2)-ROUND(sum(MONTO_TC + 0.0000000001),2)AS Total FROM tb_pagos_pedidos where cierre=0 and FORMA_PAGO=3 and YEAR(FECHA_COBRO_PEDIDO)=? and MONTH(FECHA_COBRO_PEDIDO)=? and DAY(FECHA_COBRO_PEDIDO)=?";
                     $efe_2= DB::select($sql,array($anio,$mes,$dia));
                     foreach($efe_2 as $efe_)
                     {
                        $this->total_efe=$this->total_efe+$efe_->Total;
                     }





                     $cons_mesas = DB::table('tb_pagos_pedidos')
                     ->select(DB::raw('ROUND(sum(MONTO_CUENTA + 0.0000000001),2) as Total, ROUND(sum(MONTO_RECARGO_POS + 0.0000000001),2) as POS'))
                     ->where('TIPO_PEDIDO','=', 0)
                     ->where('tb_pagos_pedidos.CIERRE','=', 0)
                     ->where(DB::raw('YEAR(FECHA_COBRO_PEDIDO)'), $anio)
                     ->where(DB::raw('MONTH(FECHA_COBRO_PEDIDO)'), $mes)
                     ->where(DB::raw('DAY(FECHA_COBRO_PEDIDO)'), $dia)
                    // ->groupBy('FECHA_COBRO_PEDIDO')
                     ->get();
    
                     $cons_domicilio = DB::table('tb_pagos_pedidos')
                     ->select(DB::raw('ROUND(sum(MONTO_CUENTA + 0.0000000001),2) as Total, ROUND(sum(MONTO_RECARGO_POS + 0.0000000001),2) as POS'))
                     ->where('TIPO_PEDIDO','=', 2)
                     ->where('tb_pagos_pedidos.CIERRE','=', 0)
                     ->where(DB::raw('YEAR(FECHA_COBRO_PEDIDO)'), $anio)
                     ->where(DB::raw('MONTH(FECHA_COBRO_PEDIDO)'), $mes)
                     ->where(DB::raw('DAY(FECHA_COBRO_PEDIDO)'), $dia)
                    // ->groupBy('FECHA_COBRO_PEDIDO')
                     ->get();
    
                     $cons_llevar = DB::table('tb_pagos_pedidos')
                     ->select(DB::raw('ROUND(sum(MONTO_CUENTA + 0.0000000001),2) as Total, ROUND(sum(MONTO_RECARGO_POS + 0.0000000001),2) as POS'))
                     ->where('TIPO_PEDIDO','=', 3)
                     ->where('tb_pagos_pedidos.CIERRE','=', 0)
                     ->where(DB::raw('YEAR(FECHA_COBRO_PEDIDO)'), $anio)
                     ->where(DB::raw('MONTH(FECHA_COBRO_PEDIDO)'), $mes)
                     ->where(DB::raw('DAY(FECHA_COBRO_PEDIDO)'), $dia)
                    // ->groupBy('FECHA_COBRO_PEDIDO')
                     ->get();
    
                     $cons_interno = DB::table('tb_pagos_pedidos')
                     ->select(DB::raw('ROUND(sum(MONTO_CUENTA + 0.0000000001),2) as Total, ROUND(sum(MONTO_RECARGO_POS + 0.0000000001),2) as POS'))
                     ->where('TIPO_PEDIDO','=', 4)
                     ->where('tb_pagos_pedidos.CIERRE','=', 0)
                     ->where(DB::raw('YEAR(FECHA_COBRO_PEDIDO)'), $anio)
                     ->where(DB::raw('MONTH(FECHA_COBRO_PEDIDO)'), $mes)
                     ->where(DB::raw('DAY(FECHA_COBRO_PEDIDO)'), $dia)
                    // ->groupBy('FECHA_COBRO_PEDIDO')
                     ->get();
    
    
    
            $sql = "SELECT * FROM tb_pedidos where cierre=0 and extra=2 and YEAR(FECHA_CREACION_PEDIDO)=? and MONTH(FECHA_CREACION_PEDIDO)=? and DAY(FECHA_CREACION_PEDIDO)=? and ESTADO_EXTRA<3";
            $pedidos_extra= DB::select($sql,array($anio,$mes,$dia));
            $sql = "SELECT * FROM tb_detalle_pedidos where CIERRE=0 and extra=2 and YEAR(FECHA_DETALLE_EXTRA)=? and MONTH(FECHA_DETALLE_EXTRA)=? and DAY(FECHA_DETALLE_EXTRA)=?";
            $detalle_pe_ex= DB::select($sql,array($anio,$mes,$dia));

            return view('livewire.reportes-component',compact('sum_cev','cons_interno','cons_llevar','cons_domicilio','cons_mesas','sum_pedidos','sum_prop','sum_monto_reca_tc','monto_tc','sum_pedidos_dl_personal','pedidos_extra','detalle_pe_ex','pedidos','categorias','platillos','bebidas','detalle_pe','mesas','usuarios'));
  
        }
        else{
            return view('livewire.reportes-component');

        }

    }
    else{

        if(session('rolus')==2){
            if($this->fecha_busqueda!=null && $this->mesero_con!=null){
                $fech = explode("-", $this->fecha_busqueda);
                $this->anio=$fech[0];
                $this->mes=$fech[1];
                $this->dia=$fech[2];
    
                $anio=$this->anio;
                $mes=$this->mes;
                $dia=$this->dia;

                $sql = "SELECT * FROM tb_pedidos where ESTADO_PEDIDO=3 and ID_EMPLEADO=? AND CIERRE=0 and YEAR(FECHA_CREACION_PEDIDO)=? and MONTH(FECHA_CREACION_PEDIDO)=? and DAY(FECHA_CREACION_PEDIDO)=?";
                $pedidos= DB::select($sql,array($this->mesero_con,$anio,$mes,$dia));

                $sql = "SELECT * FROM tb_mesas";
                $mesas= DB::select($sql);
        
                $sql = "SELECT * FROM tb_detalle_pedidos where CIERRE=0 AND PAGO=1 and YEAR(FECHA_DETALLE_EXTRA)=? and MONTH(FECHA_DETALLE_EXTRA)=? and DAY(FECHA_DETALLE_EXTRA)=?";
                $detalle_pe= DB::select($sql,array($anio,$mes,$dia));
        
                $sql = "SELECT * FROM users";
                $usuarios= DB::select($sql);

                $sql = "SELECT rol_users1s.id_user, users.name,tipo_rols.descripcion from rol_users1s inner join
                users on rol_users1s.id_user=users.id inner join 
                tipo_rols on rol_users1s.id_tipo_rol=tipo_rols.id where tipo_rols.id=3";
                $meseros= DB::select($sql);

                return view('livewire.reportes-component', compact('pedidos','usuarios','detalle_pe','mesas','meseros'));
            }

        else{

            $sql = "SELECT rol_users1s.id_user, users.name,tipo_rols.descripcion from rol_users1s inner join
            users on rol_users1s.id_user=users.id inner join 
            tipo_rols on rol_users1s.id_tipo_rol=tipo_rols.id where tipo_rols.id=3";
            $meseros= DB::select($sql);

            return view('livewire.reportes-component', compact('meseros'));
            
        }

        }
    }


        //return view('livewire.reportes-component',compact('sum_cev','cons_interno','cons_llevar','cons_domicilio','cons_mesas','sum_pedidos','sum_prop','sum_monto_reca_tc','monto_tc','sum_pedidos_dl_personal','pedidos_extra','detalle_pe_ex','pedidos','categorias','platillos','bebidas','detalle_pe','mesas','usuarios'));
   
        //return view('livewire.reportes-component');
    }
    public function fecha(){
        if($this->fecha_se!=null){
            $this->fecha_busqueda=$this->fecha_se;

        }
    }
    public function fecha2(){
        if($this->fecha_se!=null){
            $this->fecha_busqueda=$this->fecha_se;

        }
    }
    public function imprimir(){
        $anio=$this->anio;
        $mes=$this->mes;
        $dia=$this->dia;
        $fechaactual= $this->fecha_busqueda;
        $venta_total=$this->venta_total;
        $total_cevicheria=$this->total_cevicheria;
        $total_personal=$this->total_personal;
        $sub_total=$this->sub_total;
        $total_propina=$this->total_propina;
        $total_dia=$this->total_dia;
        $total_tc_sin_rec=$this->total_tc_sin_rec;
        $monto_recargo=$this->monto_recargo;



       // $today = Carbon::now()->format('d/m/Y');
        $pdf = PDF::loadView('reportes.impresion',compact('fechaactual','venta_total','total_cevicheria','total_personal','sub_total','total_propina','total_dia','total_tc_sin_rec','monto_recargo'))->output();
       // return $pdf->download('ejemplo.pdf');
        return response()->streamDownload(
            fn () => print($pdf),
            "rep_d_".$fechaactual.".pdf"
       );
       $this->imprimir2();
      }

      public function imprimir2() {

        $anio=$this->anio;
        $mes=$this->mes;
        $dia=$this->dia;
        $fechaactual=date("d-m-Y");

        
        $sql = "SELECT * FROM tb_pedidos where ESTADO_PEDIDO=3 AND CIERRE=0 and YEAR(FECHA_CREACION_PEDIDO)=? and MONTH(FECHA_CREACION_PEDIDO)=? and DAY(FECHA_CREACION_PEDIDO)=?";
        $pedidos= DB::select($sql,array($anio,$mes,$dia));


        $sql = "SELECT * FROM tb_mesas";
        $mesas= DB::select($sql);


        $sql = "SELECT * FROM users";
        $usuarios= DB::select($sql);



        $detalleped= DB::table('tb_detalle_pedidos')
        ->leftjoin('tb_platillos', 'tb_detalle_pedidos.ID_PLATILLO', '=', 'tb_platillos.ID_PLATILLO')
        ->leftjoin('tb_bebidas', 'tb_detalle_pedidos.ID_PLATILLO', '=', 'tb_bebidas.ID_BEBIDA')
        ->join('tb_pedidos', 'tb_detalle_pedidos.ID_PEDIDIO', '=', 'tb_pedidos.ID_PEDIDO')
        ->select('tb_detalle_pedidos.ID_PEDIDIO','tb_pedidos.tipo_pedido','tb_platillos.TITULO_PLATILLO','tb_bebidas.TITUTLO_BEBIDA','tb_detalle_pedidos.OBSERVACION','tb_detalle_pedidos.SUB_TOTAL','tb_detalle_pedidos.CANTIDAD_SOLICITADA')
        ->where('tb_detalle_pedidos.CIERRE','=', 0)
        ->where(DB::raw('YEAR(tb_detalle_pedidos.FECHA_DETALLE_EXTRA)'), $anio)
        ->where(DB::raw('MONTH(tb_detalle_pedidos.FECHA_DETALLE_EXTRA)'), $mes)
        ->where(DB::raw('DAY(tb_detalle_pedidos.FECHA_DETALLE_EXTRA)'), $dia)
        ->get();

        $pdf = PDF::loadView('reportes.impresiondeta',compact('detalleped','fechaactual','pedidos','mesas','usuarios'))->output();
        // return $pdf->download('ejemplo.pdf');
         return response()->streamDownload(
             fn () => print($pdf),
             "rep_d_deta_".$fechaactual.".pdf"
        );

      }
}
