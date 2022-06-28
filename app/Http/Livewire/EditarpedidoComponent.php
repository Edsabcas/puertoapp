<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\DB;

class EditarpedidoComponent extends Component
{
    public $TITULO,$DESCRIPCION,$FOTO_CATEGORIA,$FOTO_CATEGORIA1,$ESTADO,$ID_AREA,$ID_CATEGORIA,$a,$img,$FECHA_CREACION;
    public $ID_PEDIDO,$NO_PEDIDO,$ID_MESA,$ID_MESA2,$ID_EMPLEADO,$MONTO_CUENTA,$MONTO_CUENTA1,$ESTADO_PEDIDO,$FECHA_CREACION_PEDIDO,$leido,$cancelado,$extra;
    public $pedidos1,$mesas1;
    public $nopedido,$subtotalp,$subtotalex,$sumacuenta,$total;
    public $noOrden,$no_mesa,$mesero,$fecha,$mon,$idpedido,$tpago,$subt,$nmesa;
    public $feseleccion;
    //variables editar producto
    public $iddetalle,$idplatillo,$idpedidoedit,$cansolicitada,$cansolicitada2,$observacion1,$observacion2,$costopla,$nompla;
    public $ed_pla,$valcarga;
    public $item,$subtotl,$ext,$pe,$fechase,$cantidad;
    public function render()
    {
        if($this->fechase != null){
            $porciones = explode("-", $this->fechase);
            $anio=$porciones[0];
            $mes=$porciones[1];
            $dia=$porciones[2];
            $sql = "SELECT count(ID_PEDIDO) AS CANTIDAD FROM tb_pedidos where ESTADO_PEDIDO>=0 and YEAR(FECHA_CREACION_PEDIDO)=? and MONTH(FECHA_CREACION_PEDIDO)=? and DAY(FECHA_CREACION_PEDIDO)=?";
            $pedidoscan= DB::select($sql,array($anio,$mes,$dia));
            $this->cantidad=0;
            foreach($pedidoscan as $cantidads){
                $this->cantidad=$cantidads->CANTIDAD;
            }

            $sql = "SELECT * FROM tb_pedidos where ESTADO_PEDIDO>=0 and YEAR(FECHA_CREACION_PEDIDO)=? and MONTH(FECHA_CREACION_PEDIDO)=? and DAY(FECHA_CREACION_PEDIDO)=?";
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
    
            $sql = "SELECT * FROM tb_detalle_pedidos where PAGO=0 and YEAR(FECHA_DETALLE_EXTRA)=? and MONTH(FECHA_DETALLE_EXTRA)=? and DAY(FECHA_DETALLE_EXTRA)=?";
            $detalle_pe= DB::select($sql,array($anio,$mes,$dia));
            $sql = "SELECT * FROM rol_users1s";
            $rol= DB::select($sql);
            $sql = "SELECT * FROM users";
            $users= DB::select($sql);
            
        return view('livewire.editarpedido-component',compact('users','pedidos','categorias','platillos','bebidas','detalle_pe','mesas','rol','mesass'));
   
        }else{
            return view('livewire.editarpedido-component');
            
        }

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
    public function buscar() {

        if($this->feseleccion!=null && $this->feseleccion!=""){
            $this->fechase=$this->feseleccion;
        }
    }

    public function editplatillo($subt,$nompla,$iddetalle,$idplatillo,$idpedido,$cansolicitada,$observa,$costopla){
        
        $this->iddetalle=$iddetalle;
        $this->idplatillo=$idplatillo;
        $this->idpedidoedit=$idpedido;
        $this->cansolicitada=$cansolicitada;
        $this->cansolicitada2=$cansolicitada;
        $this->observacion1=$observa;
        $this->observacion2=$observa;
        $this->costopla=$costopla;
        $this->ed_pla=1; 
        $this->nompla=$nompla;
        $this->subt='Q. '.$subt;
       }

       public function cancelaredit(){
        unset($this->ed_pla);
       }

       public function updatepedido(){
        if($this->validate([
            'ID_MESA' => 'required',
            'extra' => 'required',
            'cancelado' => 'required',
            'ESTADO_PEDIDO' => 'required',
            ])==false){
            $mensaje="no encontrado";
           session(['message' => 'no encontrado']);
            return  back()->withErrors(['mensaje'=>'Validar el input vacio']);
        }else{

            DB::beginTransaction();
            $aa= DB::table('tb_pedidos')
            ->where('ID_PEDIDO', $this->ID_PEDIDO)
            ->update(
                [
                 'ID_MESA' => $this->ID_MESA,
                 'cancelado' =>$this->cancelado,
                 'ESTADO_PEDIDO'=> $this->ESTADO_PEDIDO,
                 'extra'=>$this->extra,
                ]);

                $aa2=  DB::table('tb_mesas')
                ->where('ID_MESA', $this->ID_MESA2)
                ->update(
                    [
                     'disponible' => 0,
                     'FECHA_REGISTRO' =>date('Y-m-d H:i:s'),
                    ]);

                $aa3= DB::table('tb_mesas')
                ->where('ID_MESA', $this->ID_MESA)
                ->update(
                    [
                     'disponible' => 1,
                     'FECHA_REGISTRO' =>date('Y-m-d H:i:s'),
                    ]);

            if($aa and $aa2 and $aa3)
              {
                DB::commit();
                session()->forget('edit1'); 
                session(['edit1' => ' Agregado Correctamente.']);
                $this->render();
              }
            else{
                DB::rollback();
                session(['erroredit' => 'validar']);
            }
        }
       }

       public function updateitem(){
        if($this->validate([
            'cansolicitada' => 'required',
            'observacion1' => 'required',
            ])==false){
            $mensaje="no encontrado";
           session(['message' => 'no encontrado']);
            return  back()->withErrors(['mensaje'=>'Validar el input vacio']);
        }else{
            
            DB::beginTransaction();
            $a=null;
            $b=null;
            if( $this->cansolicitada == $this->cansolicitada2){
                            
            }else{
                $a= DB::table('tb_detalle_pedidos')
                ->where('ID_DETALLE_PEDIDO', $this->iddetalle)
                ->update(
                    [
 
                     'OBSERVACION' => $this->observacion1,
                     'CANTIDAD_SOLICITADA' =>$this->cansolicitada,
                     'SUB_TOTAL'=> ($this->cansolicitada * $this->costopla),
                    ]);

                    $this->bus_detalles();
                    $b=    DB::table('tb_pedidos')
                    ->where('ID_PEDIDO', $this->idpedidoedit)
                    ->update(
                        [
                         'MONTO_CUENTA' =>  $this->subtotalp,
                        ]);   
            }
          
            if( $this->observacion1 == $this->observacion2){
                            
            }else{
                $a= DB::table('tb_detalle_pedidos')
                ->where('ID_DETALLE_PEDIDO', $this->iddetalle)
                ->update(
                    [
                     'OBSERVACION' => $this->observacion1,
                    ]);  
            }


                if($a or $b )
                  {
                    DB::commit();
                    $this->render();
                    session()->forget('edit1'); 
                    session(['edit1' => ' Agregado Correctamente.']);
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
                    $this->iddetalle="";
                    $this->idplatillo="";
                    $this->idpedidoedit="";
                    $this->cansolicitada="";
                    $this->observacion1="";
                    $this->costopla="";
                    unset($this->ed_pla);
                    $this->nompla="";
                    $this->MONTO_CUENTA='Q. '.$this->subtotalp;
                    unset($this->subtotalp);
                  }
                else{
                    DB::rollback();
                    session(['erroredit' => 'validar']);
                }
        }
       }
       public function bus_detalles() {
        $sql = "SELECT * FROM tb_detalle_pedidos where ID_PEDIDIO=?";
        $detallepedidos= DB::select($sql,array( $this->idpedidoedit));

        if($detallepedidos !=null){
            $this->subtotalp=0;
            foreach($detallepedidos as $detalle_pe){
                $this->subtotalp=$this->subtotalp+$detalle_pe->SUB_TOTAL;
            }
        }

       }

       public function tvalor($va,$subtotal,$extra,$pe){
           $this->item=$va;
           $this->subtotl=$subtotal;
           $this->ext=$extra;
           $this->pe=$pe;
       }

       public function eliminaritempedido(){
        $sql = "SELECT MONTO_CUENTA FROM tb_pedidos where ID_PEDIDO=?";
        $montopedido= DB::select($sql,array($this->pe));
        $montop=0;
        foreach($montopedido as $monto){
            $montop=$monto->MONTO_CUENTA;
        }
        $cuentatotal=($montop-$this->subtotl);

        DB::beginTransaction();
        $deldetalle= DB::table('tb_detalle_pedidos')->where('ID_DETALLE_PEDIDO', '=',  $this->item)->delete();
       
        $upmesa= DB::table('tb_pedidos')
                ->where('ID_PEDIDO', $this->pe)
                ->update(
                    [
                    'MONTO_CUENTA' => $cuentatotal,
                    ]);

        if($deldetalle and $upmesa) {
            DB::commit();
            $this->MONTO_CUENTA1=$cuentatotal;
            $this->MONTO_CUENTA=$cuentatotal;
            $sql = "SELECT * FROM tb_detalle_pedidos where ID_PEDIDIO=?";
            $detallepedidos= DB::select($sql,array($this->pe));
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

            session()->forget('delete11');
            session(['delete11' => 'si']);
        }else{
            session()->forget('error2');
            session(['error2' => 'error']);
            DB::rollback();
            
        }
       }

       public function eliminarpedgen($id,$idmesa){
        DB::beginTransaction();
       $deldetalle= DB::table('tb_detalle_pedidos')->where('ID_PEDIDIO', '=',  $id)->delete();
       $delpedi= DB::table('tb_pedidos')->where('ID_PEDIDO', '=',  $id)->delete();
       $upmesa="";
       if($idmesa!=null){
        $upmesa= DB::table('tb_mesas')
                ->where('ID_MESA', $idmesa)
                ->update(
                    [
                     'disponible' => 0,
                     'FECHA_REGISTRO' =>date('Y-m-d H:i:s'),
                    ]);
       }else{

       }


        if(($deldetalle and $delpedi) or $upmesa) {
            DB::commit();
            session()->forget('delete1');
            session(['delete1' => 'si']);
        }else{
            session()->forget('error');
            session(['error' => 'si']);
            DB::rollback();
            
       }

}

}
