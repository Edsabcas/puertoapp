<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\DB;

class VerpedidoentregadoComponent extends Component
{
    public $TITULO,$DESCRIPCION,$FOTO_CATEGORIA,$FOTO_CATEGORIA1,$ESTADO,$ID_AREA,$ID_CATEGORIA,$a,$img,$FECHA_CREACION;
    public $ID_PEDIDO,$NO_PEDIDO,$ID_MESA,$ID_MESA2,$ID_EMPLEADO,$MONTO_CUENTA,$MONTO_CUENTA1,$ESTADO_PEDIDO,$FECHA_CREACION_PEDIDO,$leido,$cancelado,$extra;
    public $pedidos1,$mesas1;
    public $nopedido,$subtotalp,$subtotalex,$sumacuenta,$total;
    public $noOrden,$no_mesa,$mesero,$fecha,$mon,$idpedido,$tpago,$subt,$nmesa;
    //variables editar producto
    public $iddetalle,$idplatillo,$idpedidoedit,$cansolicitada,$cansolicitada2,$observacion1,$observacion2,$costopla,$nompla;
    public $ed_pla,$valcarga;
    public $item,$subtotl,$ext,$pe;
    public function render()
    {
        $anio=date("Y");
        $mes=date("m");
        $dia=date("d");
        $sql = "SELECT * FROM tb_pedidos where ESTADO_PEDIDO=3 and YEAR(FECHA_CREACION_PEDIDO)=? and MONTH(FECHA_CREACION_PEDIDO)=? and DAY(FECHA_CREACION_PEDIDO)=?";
        $pedidos= DB::select($sql,array($anio,$mes,$dia));
        $sql = "SELECT * FROM tb_categoria_platillo where ESTADO=1";
        $categorias= DB::select($sql);
        $sql = "SELECT * FROM tb_platillos WHERE eliminado=0";
        $platillos= DB::select($sql);
        $sql = "SELECT * FROM tb_bebidas where eliminado=0";
        $bebidas= DB::select($sql);
        $sql = "SELECT * FROM tb_mesas where ESTADO=1 AND  disponible=0";
        $mesas= DB::select($sql);

        $sql = "SELECT * FROM tb_mesas where ESTADO=1";
        $mesass= DB::select($sql);

        $sql = "SELECT * FROM tb_detalle_pedidos where PAGO=1 and YEAR(FECHA_DETALLE_EXTRA)=? and MONTH(FECHA_DETALLE_EXTRA)=? and DAY(FECHA_DETALLE_EXTRA)=?";
        $detalle_pe= DB::select($sql,array($anio,$mes,$dia));
        $sql = "SELECT * FROM rol_users1s";
        $rol= DB::select($sql);
        $sql = "SELECT * FROM users";
        $users= DB::select($sql);

        $sql='SELECT  US.name as us, DET.tiempo_cambio_e as tiempo, DET.id_pedido, ROL.descripcion as rol,DET.fecha_pedido,DET.fecha_cambio, CASE 
        WHEN PED.tipo_pedido =0 THEN  (select tb_mesas.NO_MESA from tb_mesas where tb_mesas.ID_MESA=PED.ID_MESA)
        WHEN PED.tipo_pedido =2 THEN "A DOMICILIO"
        WHEN PED.tipo_pedido =3 THEN "PARA LLEVAR" 
        WHEN PED.tipo_pedido =4 THEN "PEDIDO INTERNO" 
           ELSE "" END AS TIPO_PEDIDO FROM
        users US INNER JOIN
        tb_salida_pedidos_log DET ON US.id=DET.id_usuario
        INNER JOIN
        tipo_rols ROL ON  ROL.id=DET.id_rol 
        INNER JOIN
        tb_pedidos PED ON  PED.ID_PEDIDO=DET.id_pedido 
        where ROL.id=? and YEAR(DET.fecha_pedido)=? and month(DET.fecha_pedido)=? and DAY(DET.fecha_pedido)=?';
        
        $ro_em=intval(session('rolus'));
        $logreg= DB::select($sql,array($ro_em,$anio,$mes,$dia));
        return view('livewire.verpedidoentregado-component',compact('logreg','users','pedidos','categorias','platillos','bebidas','detalle_pe','mesas','rol','mesass'));
 
    }
    public function editat($a1,$a2,$a3,$a4,$a5,$a6,$a7,$a8,$a9){
        $this->valcarga=1;
        $this->ID_PEDIDO=$a1;
        $this->NO_PEDIDO=$a2;
        $this->ID_MESA=$a3;
        $this->ID_MESA2=$a3;
        $this->ID_EMPLEADO=$a4;
        $this->MONTO_CUENTA='Q. '.$a5;
        $this->MONTO_CUENTA1=$a5;
        $this->ESTADO_PEDIDO=$a6;
        $this->FECHA_CREACION_PEDIDO=$a7;
        $this->cancelado=$a8;
        $this->extra=$a9;
        $sql = "SELECT * FROM tb_mesas ";
        $mesas= DB::select($sql);
        foreach($mesas as $mesa){
            if($mesa->ID_MESA ==$this->ID_MESA){
                $this->nmesa=$mesa->NO_MESA;
            }
        }

       

        $sql = "SELECT * FROM tb_detalle_pedidos where ID_PEDIDIO=?";
        $detallepedidos= DB::select($sql,array( $this->ID_PEDIDO));
        session()->forget('detallepedidos'); 
        session(['detallepedidos' => $detallepedidos]);

        $sql = "SELECT * FROM tb_platillos where eliminado=0 and ESTADO=1";
        $platillosc= DB::select($sql);
        session()->forget('platillosc'); 
        session(['platillosc' => $platillosc]);
        
        $sql = "SELECT * FROM tb_bebidas where eliminado=0 and ESTADO=1";
        $bebidasc= DB::select($sql);
        session()->forget('bebidasc'); 
        session(['bebidasc' => $bebidasc]);

        
        $sql = "SELECT * FROM tb_mesas  where ID_MESA=? and ESTADO=1 AND  disponible=1";
        $this->mesas1= DB::select($sql,array($this->ID_MESA));

    }

    public function buscarm($id) {
        $anio=date("Y");
        $mes=date("m");
        $dia=date("d");
        $sql = "SELECT * FROM tb_pedidos where ID_PEDIDO=? and YEAR(FECHA_CREACION_PEDIDO)=? and MONTH(FECHA_CREACION_PEDIDO)=? and DAY(FECHA_CREACION_PEDIDO)=?";
        $pedidos= DB::select($sql,array($id,$anio,$mes,$dia));

        foreach($pedidos as $pedido){
            $this->valcarga=1;
            $this->ID_PEDIDO=$pedido->ID_PEDIDO;
            $this->NO_PEDIDO=$pedido->NO_PEDIDO;
            $this->ID_MESA=$pedido->ID_MESA;
            $this->ID_MESA2=$pedido->ID_MESA;
            $this->ID_EMPLEADO=$pedido->ID_EMPLEADO;
            $this->MONTO_CUENTA='Q. '.$pedido->MONTO_CUENTA;
            $this->MONTO_CUENTA1=$pedido->MONTO_CUENTA;
            $this->ESTADO_PEDIDO=$pedido->ESTADO_PEDIDO;
            $this->FECHA_CREACION_PEDIDO=$pedido->FECHA_CREACION_PEDIDO;
            $this->cancelado=$pedido->cancelado;
            $this->extra=$pedido->extra;

            $sql = "SELECT * FROM tb_mesas ";
            $mesas= DB::select($sql);
            foreach($mesas as $mesa){
                if($mesa->ID_MESA ==$this->ID_MESA){
                    $this->nmesa=$mesa->NO_MESA;
                }
            }
    
           
    
            $sql = "SELECT * FROM tb_detalle_pedidos where ID_PEDIDIO=?";
            $detallepedidos= DB::select($sql,array( $this->ID_PEDIDO));
            session()->forget('detallepedidos'); 
            session(['detallepedidos' => $detallepedidos]);
    
            $sql = "SELECT * FROM tb_platillos where eliminado=0 and ESTADO=1";
            $platillosc= DB::select($sql);
            session()->forget('platillosc'); 
            session(['platillosc' => $platillosc]);
            
            $sql = "SELECT * FROM tb_bebidas where eliminado=0 and ESTADO=1";
            $bebidasc= DB::select($sql);
            session()->forget('bebidasc'); 
            session(['bebidasc' => $bebidasc]);
    
            $sql = "SELECT * FROM tb_mesas  where ID_MESA=? and ESTADO=1 AND  disponible=1";
            $this->mesas1= DB::select($sql,array($this->ID_MESA));
    


        }


    }

    public function cancelaredit(){
        $this->render();
    }
}
