<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\DB;
use Mike42\Escpos\PrintConnectors\WindowsPrintConnector;
use Mike42\Escpos\Printer;
use Illuminate\Support\Facades\Http;

class ComprobantemesaordenComponent extends Component
{
    public $nopedido,$subtotalp,$subtotalex,$sumacuenta,$total;
    public $pedidos1,$detallepedidos,$platillosc,$bebidasc,$mesas1,$cancelado;
    public $noOrden,$no_mesa,$mesero,$fecha,$mon,$idpedido,$tpago,$nombreMesero;
    public $m,$cance,$op,$nom_cliente,$telef,$dire,$propinas,$valorpro,$monto_efec,$tpedido;
    public $valorinput,$notc,$cuentamasrecargo,$detallepedidos2;
    public $array1=array(),$cambio,$mo,$cuentainput;
    public $idpedg,$opad,$valorcambio,$t_pedido,$mprop,$valoradomicilio,$valoradomicilio1;
    public $estado_p,$estado_ex;
    public $pago_mixto,$monto_tc_par,$cuentainput2,$monto_efec2,$sumaefetc,$recargo_tc2;
    public $array2=array(),$mensaje,$existe,$respuesta;
    public $fel,$nitcliente,$nombcliente,$direccioncliente,$nitclientereg,$nombclientereg,$direccionclientereg;
    public function render()
    {
        $anio=date("Y");
        $mes=date("m");
        $dia=date("d");
        $sql = "SELECT * FROM tb_pedidos where cancelado<=2 and YEAR(FECHA_CREACION_PEDIDO)=? and MONTH(FECHA_CREACION_PEDIDO)=? and DAY(FECHA_CREACION_PEDIDO)=?";
        $pedidos= DB::select($sql,array($anio,$mes,$dia));
        $sql = "SELECT * FROM tb_mesas  where ESTADO=1 AND  disponible=1";
        $mesas= DB::select($sql);
        return view('livewire.comprobantemesaorden-component',compact('mesas','pedidos'));
    }
    public function busquedacuenta($idmesa,$nomesa,$cancelado){
        $this->op==1;
        $this->cance=0;
        $this->nom_cliente=0;
        $this->telef=0;
        $this->dire=0;
        $this->propinas=0;
        $this->valorpro=0;
        $this->monto_efec=0;
        $this->cance=$cancelado;
        $this->m=$idmesa;
        $this->subtotalp=0;
        $this->subtotalex=0;
        $this->sumacuenta=0;
        $this->nopedido=1;
        $this->no_mesa=$nomesa;
        $this->fecha= date("d-m-Y H:i:s");
        $anio=date("Y");
        $mes=date("m");
        $dia=date("d");
        $sql = "SELECT * FROM tb_pedidos where cancelado>=0 and ID_MESA=? and YEAR(FECHA_CREACION_PEDIDO)=? and MONTH(FECHA_CREACION_PEDIDO)=? and DAY(FECHA_CREACION_PEDIDO)=?";
        $this->pedidos1= DB::select($sql,array($idmesa,$anio,$mes,$dia));
        foreach($this->pedidos1 as $pedido1){
            $this->idpedido=$pedido1->ID_PEDIDO;
            $this->noOrden=$pedido1->NO_PEDIDO;
            $this->mesero=$pedido1->ID_EMPLEADO;
            $this->mo=$pedido1->MONTO_CUENTA;
            $this->cancelado=$pedido1->cancelado;
            $this->t_pedido=$pedido1->tipo_pedido;
            $this->mprop=$pedido1->MONTO_PROPINA;
            $this->estado_p=$pedido1->ESTADO_PEDIDO;
            $this->estado_ex=$pedido1->ESTADO_EXTRA;
        }
        $sql = "SELECT * FROM users where id=?";
        $meseros= DB::select($sql,array($this->mesero));

        foreach($meseros as $mes){
            $this->nombreMesero=$mes->name;
        }


        $sql = "SELECT * FROM tb_detalle_pedidos where ID_PEDIDIO=?";
        $detallepedidos= DB::select($sql,array($this->idpedido));
        session()->forget('detallepedidos'); 
        session(['detallepedidos' => $detallepedidos]);

        $sql = "SELECT * FROM tb_platillos where eliminado=0 and ESTADO=1";
        $platillosc= DB::select($sql);
        session(['platillosc' => $platillosc]);

        $sql = "SELECT * FROM tb_bebidas where eliminado=0 and ESTADO=1";
        $bebidasc= DB::select($sql);
        session(['bebidasc' => $bebidasc]);

        $sql = "SELECT * FROM tb_propinas";
        $propinas= DB::select($sql);
        session(['propinas' => $propinas]);
    }

        public function busquedacuenta2($cancelado,$idpedi){
            $this->cance=$cancelado;
            $this->subtotalp=0;
            $this->subtotalex=0;
            $this->sumacuenta=0;
            $this->valorpro=0;
            unset($this->nopedido);
            unset($this->no_mesa);
            //unset($this->cance);
            unset($this->m);
            unset($this->no_mesa);
            $this->fecha= date("d-m-Y H:i:s");
            $anio=date("Y");
            $mes=date("m");
            $dia=date("d");
            $this->idpedg=$idpedi;
            $sql = "SELECT * FROM tb_pedidos where  cancelado>=0 and ID_PEDIDO=? and YEAR(FECHA_CREACION_PEDIDO)=? and MONTH(FECHA_CREACION_PEDIDO)=? and DAY(FECHA_CREACION_PEDIDO)=?";
            $this->pedidos1= DB::select($sql,array($idpedi,$anio,$mes,$dia));
            foreach($this->pedidos1 as $pedido1){
                $this->idpedido=$pedido1->ID_PEDIDO;
                $this->noOrden=$pedido1->NO_PEDIDO;
                $this->mesero=$pedido1->ID_EMPLEADO;
                $this->mo=$pedido1->MONTO_CUENTA;
                $this->cancelado=$pedido1->cancelado;
                $this->nom_cliente=$pedido1->nombre_cliente;
                $this->telef=$pedido1->telefono;
                $this->dire=$pedido1->direccion_pedido;
                $this->t_pedido=$pedido1->tipo_pedido;
                $this->mprop=$pedido1->MONTO_PROPINA;
                $this->valoradomicilio1=$pedido1->MONTO_A_DOMICILIO;
                $this->estado_p=$pedido1->ESTADO_PEDIDO;
                $this->estado_ex=$pedido1->ESTADO_EXTRA;
            }
            $sql = "SELECT * FROM users where id=?";
            $meseros= DB::select($sql,array($this->mesero));
    
            foreach($meseros as $mes){
                $this->nombreMesero=$mes->name;
            }
    
    
            $sql = "SELECT * FROM tb_detalle_pedidos where ID_PEDIDIO=?";
            $detallepedidos= DB::select($sql,array($this->idpedido));
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

            $sql = "SELECT * FROM tb_propinas";
            $propinas= DB::select($sql);
            session()->forget('propinas'); 
            session(['propinas' => $propinas]);
        }
        public function cliente($val){
            if($val==1){
                $this->existe="";
                $this->fel=$val;
            }
            else
            {
                $this->reset([
                    'nitcliente',
                    'nombcliente',
                    'direccioncliente',
    
                ]);
                $this->fel=$val; 
            }
        }
        public function buscarCliente(){
            $this->existe="";
            if($this->validate([
                'nitcliente' => 'required',
                ])==false){
                $mensaje="no encontrado";
               session(['message' => 'no encontrado']);
                return  back()->withErrors(['mensaje'=>'Validar el input vacio']);
            }else{

                $sql = "SELECT * FROM tb_clientes where nit=?";
                $buscliente= DB::select($sql,array($this->nitcliente));
                $encuentra=0;
                if($buscliente!=null){
                    foreach($buscliente as $bus){
                        $this->nitcliente=$bus->nit;
                        $this->nombcliente=$bus->nombre;
                        $this->direccioncliente=$bus->direccion;

                    }
                }
                else{
                    $this->existe=2;
                    //$this->nitcliente="";
                    $this->nombcliente="";
                    $this->direccioncliente="";
                }
            }


        }
        public function modalinsercliente(){
            $this->nitclientereg=$this->nitcliente;
            $this->existe="";
        }
        public function guardarcliente(){
            
            if($this->validate([
                'nitclientereg' => 'required',
                'nombclientereg' => 'required',
                'direccionclientereg' => 'required'
                ])==false){
                $mensaje="no encontrado";
               session(['message' => 'no encontrado']);
                return  back()->withErrors(['mensaje'=>'Validar el input vacio']);
            }else{
                $sql = "SELECT * FROM tb_clientes where nit=?";
                $buscliente= DB::select($sql,array($this->nitclientereg));
                $encuentra=0;
                foreach($buscliente as $bus){
                    $encuentra=$bus->nit;
                }
                if($encuentra==$this->nitclientereg){
                    $this->existe=1;
                }
                else{
                    DB::beginTransaction();
                    $guardarcliente=DB::table('tb_clientes')->insert(
                        [
                         'nombre' => $this->nombclientereg,
                         'nit'=> $this->nitclientereg,
                         'direccion'=>$this->direccionclientereg,
                         'fecha_registro' => date('Y-m-d H:i:s'),
                    ]);
                    if($guardarcliente)
                    {
                        DB::commit();
                        $this->nombcliente= $this->nombclientereg;
                        $this->nitcliente= $this->nitclientereg;
                        $this->direccioncliente=$this->direccionclientereg;
                        $this->nombcliente="";
                        $this->nitcliente="";
                        $this->direccioncliente="";
                        $this->mensaje=1;
                    }else{
                        DB::rollback();
                        $this->mensaje=2;
                    }
                }
            }
        }

        public function limpiarcliente(){
            $this->reset([
                'fel',
                'nitcliente',
                'nombcliente',
                'direccioncliente',

            ]);
        }
        public function cierrecuenta(){
          //  $sql = "SELECT * FROM tb_propinas";
           // $propinas= DB::select($sql);
            DB::beginTransaction();

            if($this->op==4){
                $resped=DB::table('tb_pedidos')
                ->where('ID_PEDIDO',  $this->idpedido)
                ->update(
                    [
                     'cancelado' => 2,
                     'MONTO_CUENTA'=>($this->mo),
                     
                    ]);
            }
        
            else{
                foreach(session('propinas') as $propina){
                    if($propina->monto_inicial<=$this->mo and $propina->monto_final>=$this->mo){
                        $this->valorpro=$propina->monto;
                    }
                }

                if($this->op==2){

                    if($this->validate([
                        'valoradomicilio' => 'required',
                        ])==false){
                        $mensaje="no encontrado";
                       session(['message' => 'no encontrado']);
                        return  back()->withErrors(['mensaje'=>'Validar el input vacio']);
                    }else{
                        $resped=DB::table('tb_pedidos')
                        ->where('ID_PEDIDO',  $this->idpedido)
                        ->update(
                            [
                             'cancelado' => 2,
                             'MONTO_CUENTA'=>($this->mo+$this->valoradomicilio),
                             'MONTO_PROPINA'=>0,
                             'MONTO_A_DOMICILIO'=>$this->valoradomicilio,
                            ]);

                    }
            }
            if($this->op==3){

   
                    $resped=DB::table('tb_pedidos')
                    ->where('ID_PEDIDO',  $this->idpedido)
                    ->update(
                        [
                         'cancelado' => 2,
                         'MONTO_CUENTA'=>($this->mo),
                         'MONTO_PROPINA'=>0,
                        ]);
        }
            else{
                $resped=DB::table('tb_pedidos')
                ->where('ID_PEDIDO',  $this->idpedido)
                ->update(
                    [
                     'cancelado' => 2,
                     'MONTO_CUENTA'=>($this->mo+$this->valorpro),
                     'MONTO_PROPINA'=>$this->valorpro,
                     
                    ]);
            }
        }
        if($resped)
        {
            DB::commit();
            session()->forget('estado'); 
            session(['estado' => ' Asignadas Correctamente.']);
            //Volver a activar para realizar impresion  
           // $this->cargainfo();
            $this->reset();
            session()->forget('detallepedidos'); 
            session()->forget('platillosc'); 
            session()->forget('bebidasc'); 
            session()->forget('tb_propinas'); 

        }else{
            DB::rollback();
            session(['error' => 'validar']);
        }

        
    }

        public function cargainfo(){
            $this->subtotalp=0;
            $this->subtotalex=0;
            $this->sumacuenta=0;
            $this->valorpro=0;
           
            $anio=date("Y");
            $mes=date("m");
            $dia=date("d");
            if($this->op==1){
                $this->nopedido=1;
                $sql = "SELECT * FROM tb_pedidos where cancelado>=1 and ID_MESA=? and YEAR(FECHA_CREACION_PEDIDO)=? and MONTH(FECHA_CREACION_PEDIDO)=? and DAY(FECHA_CREACION_PEDIDO)=?";
                $this->pedidos1= DB::select($sql,array($this->m,$anio,$mes,$dia));
            }
            else{
                
                $sql = "SELECT * FROM tb_pedidos where cancelado>=1 and ID_PEDIDO=? and YEAR(FECHA_CREACION_PEDIDO)=? and MONTH(FECHA_CREACION_PEDIDO)=? and DAY(FECHA_CREACION_PEDIDO)=?";
                $this->pedidos1= DB::select($sql,array($this->idpedg,$anio,$mes,$dia));
            }
              foreach($this->pedidos1 as $pedido1){
                $this->idpedido=$pedido1->ID_PEDIDO;
                $this->noOrden=$pedido1->NO_PEDIDO;
                $this->mesero=$pedido1->ID_EMPLEADO;
                $this->mo=$pedido1->MONTO_CUENTA;
                $this->cancelado=$pedido1->cancelado;
                $this->tpedido=$pedido1->tipo_pedido;
                $this->valoradomicilio1=$pedido1->MONTO_A_DOMICILIO;
            }
            $sql = "SELECT * FROM users where id=?";
            $meseros= DB::select($sql,array($this->mesero));
    
            foreach($meseros as $mes){
                $this->nombreMesero=$mes->name;
            }
    
    
            $sql = "SELECT * FROM tb_detalle_pedidos where ID_PEDIDIO=?";
            $this->detallepedidos= DB::select($sql,array($this->idpedido));

            $sql = "SELECT * FROM tb_detalle_pedidos where ID_PEDIDIO=? and extra=2";
            $this->detallepedidos2= DB::select($sql,array($this->idpedido));
    
            $sql = "SELECT * FROM tb_platillos where eliminado=0 and ESTADO=1";
            $this->platillosc= DB::select($sql);
    
            $sql = "SELECT * FROM tb_bebidas where eliminado=0 and ESTADO=1";
            $this->bebidasc= DB::select($sql);
            if($this->op==1){
                $sql = "SELECT * FROM tb_mesas  where ID_MESA=? and ESTADO=1 AND  disponible=1";
                $this->mesas1= DB::select($sql,array($this->m));
    
            }
          

            $sql = "SELECT * FROM tb_propinas";
            $this->propinas= DB::select($sql);
            
            $this->imprimir();

        }



        public function tipo_pedido($a){
            //$this->reset();
            if($a==1){
                $this->op=1;
                unset($this->nopedido);
                unset($this->detallepedidos);
                unset($this->platillosc);
                unset($this->bebidasc);
                session()->forget('detallepedidos'); 
                session()->forget('platillosc'); 
                session()->forget('bebidasc'); 
                session()->forget('tb_propinas'); 

            }else if($a==2){
                $this->op=2;
                unset($this->nopedido);
                unset($this->detallepedidos);
                unset($this->platillosc);
                unset($this->bebidasc);
                session()->forget('detallepedidos'); 
                session()->forget('platillosc'); 
                session()->forget('bebidasc'); 
                session()->forget('tb_propinas'); 
            }
            else if($a==3){
                $this->op=3;
                unset($this->nopedido);
                unset($this->detallepedidos);
                unset($this->platillosc);
                unset($this->bebidasc);
                session()->forget('detallepedidos'); 
                session()->forget('platillosc'); 
                session()->forget('bebidasc'); 
                session()->forget('tb_propinas'); 
            }
            else if($a==4){
                $this->op=4;
                unset($this->nopedido);
                unset($this->detallepedidos);
                unset($this->platillosc);
                unset($this->bebidasc);
                session()->forget('detallepedidos'); 
                session()->forget('platillosc'); 
                session()->forget('bebidasc'); 
                session()->forget('tb_propinas'); 
            }
        }

        public function imprimir()
        {
            $this->subtotalp=0;
            $this->subtotalex=0;
            $this->sumacuenta=0;
            $this->valorpro=0;
            $nombreImpresora = "EPSONTM-T20III";
            $connector = new WindowsPrintConnector($nombreImpresora);
            $impresora = new Printer($connector);
            $impresora->setJustification(Printer::JUSTIFY_CENTER);
            $impresora->setTextSize(1, 2);
            $impresora->text("Restaurante El Puerto \n");
            $impresora->setTextSize(1, 1);
            if(isset($this->no_mesa) and $this->no_mesa!=null){
                $impresora->text("Pedido Mesa. # " . $this->no_mesa . " \n");
            }
            if($this->nom_cliente!=null and $this->telef and $this->dire){
                $impresora->text("Pedido a domicilio\n");
            }
            elseif($this->nom_cliente!=null and $this->tpedido==3){
                $impresora->text("Pedido para llevar\n");
            }   
            elseif($this->nom_cliente!=null and $this->tpedido==4){
                $impresora->text("Pedido Interno\n");
            }   

            $impresora->text(date("d-m-Y H:i:s") . "\n");
            $impresora->text("Mesero: " . $this->nombreMesero . "\n");
            $impresora->text("\n");
            $impresora->setJustification(Printer::JUSTIFY_LEFT);
            if($this->nom_cliente!=null and $this->telef and $this->dire){
                $impresora->text("Cliente: ");
                $impresora->text($this->nom_cliente."\n");
                $impresora->text("Direccion: ");
                $impresora->text($this->dire."\n");
                $impresora->text("Tel: ");
                $impresora->text($this->telef."\n");
            }
            elseif($this->nom_cliente!=null and $this->tpedido==3){

                $impresora->text("Cliente: ");
                $impresora->text($this->nom_cliente."\n");
            }    
            elseif($this->nom_cliente!=null and $this->tpedido==4){
                $impresora->text("Colaborador: ");
                $impresora->text($this->nom_cliente."\n");
            }   

            $impresora->text("\n");  
            $impresora->setJustification(Printer::JUSTIFY_LEFT);
            $impresora->setTextSize(1, 1);
            $impresora->text("Pedido Original\n");

            $impresora->text("================================================\n");
            $impresora->text("\n");

            $impresora->text("Cant. Descripción         ");
            $impresora->setJustification(Printer::JUSTIFY_RIGHT);
            $impresora->text("   Precio   Totales\n");
            $impresora->text("\n");
            if($this->detallepedidos !=null){
                foreach($this->detallepedidos as $detallepedido){
                    foreach($this->platillosc as $platillo){
                    if($detallepedido->ID_PLATILLO == $platillo->ID_PLATILLO and $detallepedido->extra==0){
                        $this->subtotalp=($this->subtotalp +$detallepedido->SUB_TOTAL);
                        
                        $var1=strlen($platillo->TITULO_PLATILLO);
                        $var2=strlen($detallepedido->OBSERVACION);
                        if(($var1+$var2)==22 or ($var1+$var2)>22){
                        $impresora->setJustification(Printer::JUSTIFY_LEFT);
                        
                        if(strlen($detallepedido->CANTIDAD_SOLICITADA)==1){
                            $impresora->text($detallepedido->CANTIDAD_SOLICITADA."     ");
                           // $impresora->text($platillo->TITULO_PLATILLO." ".$detallepedido->OBSERVACION);
                            if(($var1+$var2)>30){
                                $sub1=substr($platillo->TITULO_PLATILLO." ".$detallepedido->OBSERVACION,0,28);
                                $sub2=substr($platillo->TITULO_PLATILLO." ".$detallepedido->OBSERVACION,28);
                                $impresora->text($sub1."...");
                                $impresora->text("\n");
                                $impresora->text("      ".$sub2);
                            }
                            else{
                                $impresora->text($platillo->TITULO_PLATILLO." ".$detallepedido->OBSERVACION);
                            }

                            
                        }
                        else if(strlen($detallepedido->CANTIDAD_SOLICITADA)==2){
                            $impresora->text($detallepedido->CANTIDAD_SOLICITADA."    ");
                            if(($var1+$var2)>30){
                                $sub1=substr($platillo->TITULO_PLATILLO." ".$detallepedido->OBSERVACION,0,28);
                                $sub2=substr($platillo->TITULO_PLATILLO." ".$detallepedido->OBSERVACION,28);
                                $impresora->text($sub1."...");
                                $impresora->text("\n");
                                $impresora->text("      ".$sub2);
                            }
                            else{
                                $impresora->text($platillo->TITULO_PLATILLO." ".$detallepedido->OBSERVACION);
                            }
                            
                            
                        }else if(strlen($detallepedido->CANTIDAD_SOLICITADA)==3){
                            $impresora->text($detallepedido->CANTIDAD_SOLICITADA."   ");
                            if(($var1+$var2)>30){
                                $sub1=substr($platillo->TITULO_PLATILLO." ".$detallepedido->OBSERVACION,0,28);
                                $sub2=substr($platillo->TITULO_PLATILLO." ".$detallepedido->OBSERVACION,29);
                                $impresora->text($sub1."...");
                                $impresora->text("\n");
                                $impresora->text("      ".$sub2);
                            }

                            else{
                                
                                $impresora->text($platillo->TITULO_PLATILLO." ".$detallepedido->OBSERVACION);

                            }
                        }
                        
                        $impresora->text("\n");
                        $impresora->setJustification(Printer::JUSTIFY_RIGHT);
                        if(strlen((($detallepedido->CANTIDAD_SOLICITADA * $platillo->COSTO_PLATILLO)+$detallepedido->costo_cambio+$detallepedido->costo_guarnicion))==2){
                            $impresora->text("Q. ".$platillo->COSTO_PLATILLO."    Q. ".(($detallepedido->CANTIDAD_SOLICITADA * $platillo->COSTO_PLATILLO)+($detallepedido->costo_cambio-$detallepedido->costo_guarnicion)."     "));
                            
                        }

                        else if(strlen((($detallepedido->CANTIDAD_SOLICITADA * $platillo->COSTO_PLATILLO)+$detallepedido->costo_cambio+$detallepedido->costo_guarnicion))==3){
                            $impresora->text("Q. ".$platillo->COSTO_PLATILLO);
                            $impresora->setJustification(Printer::JUSTIFY_RIGHT);
                            $impresora->text("    Q. ".(($detallepedido->CANTIDAD_SOLICITADA * $platillo->COSTO_PLATILLO)+($detallepedido->costo_cambio-$detallepedido->costo_guarnicion)."    "));
                         }
                         else{
                            $impresora->text("Q. ".$platillo->COSTO_PLATILLO);
                            $impresora->setJustification(Printer::JUSTIFY_RIGHT);
                            $impresora->text("     Q. ".(($detallepedido->CANTIDAD_SOLICITADA * $platillo->COSTO_PLATILLO)+($detallepedido->costo_cambio-$detallepedido->costo_guarnicion)."      "));
                         
                         }
                        $impresora->text("\n");
                        }else{
                            $impresora->setJustification(Printer::JUSTIFY_LEFT);
                            if(strlen($detallepedido->CANTIDAD_SOLICITADA)==1){
                                $impresora->text($detallepedido->CANTIDAD_SOLICITADA."     ");
                                $impresora->text($platillo->TITULO_PLATILLO);
                            }
                            else if(strlen($detallepedido->CANTIDAD_SOLICITADA)==2){
                                $impresora->text($detallepedido->CANTIDAD_SOLICITADA."    ");
                                $impresora->text($platillo->TITULO_PLATILLO);
                            }else if(strlen($detallepedido->CANTIDAD_SOLICITADA)==3){
                                $impresora->text($detallepedido->CANTIDAD_SOLICITADA."   ");
                                $impresora->text($platillo->TITULO_PLATILLO);
                            }

                            $impresora->setJustification(Printer::JUSTIFY_RIGHT);
                            if($var1==2){
                                if(strlen((($detallepedido->CANTIDAD_SOLICITADA * $platillo->COSTO_PLATILLO)+$detallepedido->costo_cambio+$detallepedido->costo_guarnicion))==2){
                                    $impresora->text("                     Q. ".$platillo->COSTO_PLATILLO."    Q. ".(($detallepedido->CANTIDAD_SOLICITADA * $platillo->COSTO_PLATILLO)+$detallepedido->costo_cambio+$detallepedido->costo_guarnicion));
                                }
                                else if(strlen((($detallepedido->CANTIDAD_SOLICITADA * $platillo->COSTO_PLATILLO)+$detallepedido->costo_cambio+$detallepedido->costo_guarnicion))==1){
                                    $impresora->text("                     Q. ".$platillo->COSTO_PLATILLO."     Q. ".(($detallepedido->CANTIDAD_SOLICITADA * $platillo->COSTO_PLATILLO)+$detallepedido->costo_cambio+$detallepedido->costo_guarnicion));
                                }
                                else if(strlen((($detallepedido->CANTIDAD_SOLICITADA * $platillo->COSTO_PLATILLO)+$detallepedido->costo_cambio+$detallepedido->costo_guarnicion))==3){
                                    if(strlen($platillo->COSTO_PLATILLO)==3){
                                        $impresora->text("                     Q. ".$platillo->COSTO_PLATILLO."   Q. ".(($detallepedido->CANTIDAD_SOLICITADA * $platillo->COSTO_PLATILLO)+$detallepedido->costo_cambio+$detallepedido->costo_guarnicion));
                                
                                    }
                                    else{
                                        $impresora->text("                     Q. ".$platillo->COSTO_PLATILLO."    Q. ".(($detallepedido->CANTIDAD_SOLICITADA * $platillo->COSTO_PLATILLO)+$detallepedido->costo_cambio+$detallepedido->costo_guarnicion));
                                
                                    }
                                 }
                                
                                else{
                                    $impresora->text("                    Q. ".$platillo->COSTO_PLATILLO."  Q. ".(($detallepedido->CANTIDAD_SOLICITADA * $platillo->COSTO_PLATILLO)+$detallepedido->costo_cambio+$detallepedido->costo_guarnicion));
                                }

                            }
                            if($var1==3){
                                if(strlen((($detallepedido->CANTIDAD_SOLICITADA * $platillo->COSTO_PLATILLO)+$detallepedido->costo_cambio+$detallepedido->costo_guarnicion))==2){
                                    $impresora->text("                    Q. ".$platillo->COSTO_PLATILLO."    Q. ".(($detallepedido->CANTIDAD_SOLICITADA * $platillo->COSTO_PLATILLO)+$detallepedido->costo_cambio+$detallepedido->costo_guarnicion));
                                }
                                else if(strlen((($detallepedido->CANTIDAD_SOLICITADA * $platillo->COSTO_PLATILLO)+$detallepedido->costo_cambio+$detallepedido->costo_guarnicion))==1){
                                    $impresora->text("                    Q. ".$platillo->COSTO_PLATILLO."     Q. ".(($detallepedido->CANTIDAD_SOLICITADA * $platillo->COSTO_PLATILLO)+$detallepedido->costo_cambio+$detallepedido->costo_guarnicion));
                                }
                                else if(strlen((($detallepedido->CANTIDAD_SOLICITADA * $platillo->COSTO_PLATILLO)+$detallepedido->costo_cambio+$detallepedido->costo_guarnicion))==3){
                                    if(strlen($platillo->COSTO_PLATILLO)==3){
                                        $impresora->text("                    Q. ".$platillo->COSTO_PLATILLO."   Q. ".(($detallepedido->CANTIDAD_SOLICITADA * $platillo->COSTO_PLATILLO)+$detallepedido->costo_cambio+$detallepedido->costo_guarnicion));
                                
                                    }
                                    else{
                                        $impresora->text("                    Q. ".$platillo->COSTO_PLATILLO."    Q. ".(($detallepedido->CANTIDAD_SOLICITADA * $platillo->COSTO_PLATILLO)+$detallepedido->costo_cambio+$detallepedido->costo_guarnicion));
                                
                                    }
                                 }
                                
                                else{
                                    $impresora->text("                    Q. ".$platillo->COSTO_PLATILLO."  Q. ".(($detallepedido->CANTIDAD_SOLICITADA * $platillo->COSTO_PLATILLO)+$detallepedido->costo_cambio+$detallepedido->costo_guarnicion));
                                }

                            }

                            if($var1==4){
                                if(strlen((($detallepedido->CANTIDAD_SOLICITADA * $platillo->COSTO_PLATILLO)+$detallepedido->costo_cambio+$detallepedido->costo_guarnicion))==2){
                                    $impresora->text("                   Q. ".$platillo->COSTO_PLATILLO."    Q. ".(($detallepedido->CANTIDAD_SOLICITADA * $platillo->COSTO_PLATILLO)+$detallepedido->costo_cambio+$detallepedido->costo_guarnicion));
                                }
                                else if(strlen((($detallepedido->CANTIDAD_SOLICITADA * $platillo->COSTO_PLATILLO)+$detallepedido->costo_cambio+$detallepedido->costo_guarnicion))==1){
                                    $impresora->text("                   Q. ".$platillo->COSTO_PLATILLO."     Q. ".(($detallepedido->CANTIDAD_SOLICITADA * $platillo->COSTO_PLATILLO)+$detallepedido->costo_cambio+$detallepedido->costo_guarnicion));
                                }
                                else if(strlen((($detallepedido->CANTIDAD_SOLICITADA * $platillo->COSTO_PLATILLO)+$detallepedido->costo_cambio+$detallepedido->costo_guarnicion))==3){
                                    if(strlen($platillo->COSTO_PLATILLO)==3){
                                        $impresora->text("                   Q. ".$platillo->COSTO_PLATILLO."   Q. ".(($detallepedido->CANTIDAD_SOLICITADA * $platillo->COSTO_PLATILLO)+$detallepedido->costo_cambio+$detallepedido->costo_guarnicion));
                                
                                    }
                                    else{
                                        $impresora->text("                   Q. ".$platillo->COSTO_PLATILLO."    Q. ".(($detallepedido->CANTIDAD_SOLICITADA * $platillo->COSTO_PLATILLO)+$detallepedido->costo_cambio+$detallepedido->costo_guarnicion));
                                
                                    }
                                 }
                                
                                else{
                                    $impresora->text("                   Q. ".$platillo->COSTO_PLATILLO."  Q. ".(($detallepedido->CANTIDAD_SOLICITADA * $platillo->COSTO_PLATILLO)+$detallepedido->costo_cambio+$detallepedido->costo_guarnicion));
                                }

                            }
                            if($var1==5){
                                if(strlen((($detallepedido->CANTIDAD_SOLICITADA * $platillo->COSTO_PLATILLO)+$detallepedido->costo_cambio+$detallepedido->costo_guarnicion))==2){
                                    
                                    $impresora->text("                  Q. ".$platillo->COSTO_PLATILLO."    Q. ".(($detallepedido->CANTIDAD_SOLICITADA * $platillo->COSTO_PLATILLO)+$detallepedido->costo_cambio+$detallepedido->costo_guarnicion));
                                }
                                else if(strlen((($detallepedido->CANTIDAD_SOLICITADA * $platillo->COSTO_PLATILLO)+$detallepedido->costo_cambio+$detallepedido->costo_guarnicion))==1){
                                    $impresora->text("                  Q. ".$platillo->COSTO_PLATILLO."     Q. ".(($detallepedido->CANTIDAD_SOLICITADA * $platillo->COSTO_PLATILLO)+$detallepedido->costo_cambio+$detallepedido->costo_guarnicion));
                                }
                                else if(strlen((($detallepedido->CANTIDAD_SOLICITADA * $platillo->COSTO_PLATILLO)+$detallepedido->costo_cambio+$detallepedido->costo_guarnicion))==3){
                                    if(strlen($platillo->COSTO_PLATILLO)==3){
                                        $impresora->text("                  Q. ".$platillo->COSTO_PLATILLO."   Q. ".(($detallepedido->CANTIDAD_SOLICITADA * $platillo->COSTO_PLATILLO)+$detallepedido->costo_cambio+$detallepedido->costo_guarnicion));
                                
                                    }
                                    else{
                                        $impresora->text("                  Q. ".$platillo->COSTO_PLATILLO."    Q. ".(($detallepedido->CANTIDAD_SOLICITADA * $platillo->COSTO_PLATILLO)+$detallepedido->costo_cambio+$detallepedido->costo_guarnicion));
                                
                                    }
                               }
                                
                                else{
                                    $impresora->text("                  Q. ".$platillo->COSTO_PLATILLO."  Q. ".(($detallepedido->CANTIDAD_SOLICITADA * $platillo->COSTO_PLATILLO)+$detallepedido->costo_cambio+$detallepedido->costo_guarnicion));
                                }

                            }
                            elseif($var1==6){
                                if(strlen((($detallepedido->CANTIDAD_SOLICITADA * $platillo->COSTO_PLATILLO)+$detallepedido->costo_cambio+$detallepedido->costo_guarnicion))==2){
                                     $impresora->text("                 Q. ".$platillo->COSTO_PLATILLO."    Q. ".(($detallepedido->CANTIDAD_SOLICITADA * $platillo->COSTO_PLATILLO)+$detallepedido->costo_cambio+$detallepedido->costo_guarnicion));                      

                                }
                                else if(strlen((($detallepedido->CANTIDAD_SOLICITADA * $platillo->COSTO_PLATILLO)+$detallepedido->costo_cambio+$detallepedido->costo_guarnicion))==1){
                                    $impresora->text("                 Q. ".$platillo->COSTO_PLATILLO."     Q. ".(($detallepedido->CANTIDAD_SOLICITADA * $platillo->COSTO_PLATILLO)+$detallepedido->costo_cambio+$detallepedido->costo_guarnicion));
                                }
                                else if(strlen((($detallepedido->CANTIDAD_SOLICITADA * $platillo->COSTO_PLATILLO)+$detallepedido->costo_cambio+$detallepedido->costo_guarnicion))==3){
                                    if(strlen($platillo->COSTO_PLATILLO)==3){
                                        $impresora->text("                 Q. ".$platillo->COSTO_PLATILLO."   Q. ".(($detallepedido->CANTIDAD_SOLICITADA * $platillo->COSTO_PLATILLO)+$detallepedido->costo_cambio+$detallepedido->costo_guarnicion));                      

                                    }else{
                                        $impresora->text("                 Q. ".$platillo->COSTO_PLATILLO."    Q. ".(($detallepedido->CANTIDAD_SOLICITADA * $platillo->COSTO_PLATILLO)+$detallepedido->costo_cambio+$detallepedido->costo_guarnicion));                      

                                    }
                                   
                                }
                                
                                else{
                                     $impresora->text("                 Q. ".$platillo->COSTO_PLATILLO."    Q. ".(($detallepedido->CANTIDAD_SOLICITADA * $platillo->COSTO_PLATILLO)+$detallepedido->costo_cambio+$detallepedido->costo_guarnicion));                      

                                }
                                
                               
                            }
                            elseif($var1==7){
                                if(strlen((($detallepedido->CANTIDAD_SOLICITADA * $platillo->COSTO_PLATILLO)+$detallepedido->costo_cambio+$detallepedido->costo_guarnicion))==2){
                                    $impresora->text("                Q. ".$platillo->COSTO_PLATILLO."    Q. ".(($detallepedido->CANTIDAD_SOLICITADA * $platillo->COSTO_PLATILLO)+$detallepedido->costo_cambio+$detallepedido->costo_guarnicion));                      

                               }
                               else if(strlen((($detallepedido->CANTIDAD_SOLICITADA * $platillo->COSTO_PLATILLO)+$detallepedido->costo_cambio+$detallepedido->costo_guarnicion))==1){
                                $impresora->text("                Q. ".$platillo->COSTO_PLATILLO."     Q. ".(($detallepedido->CANTIDAD_SOLICITADA * $platillo->COSTO_PLATILLO)+$detallepedido->costo_cambio+$detallepedido->costo_guarnicion));
                            }
                               else if(strlen((($detallepedido->CANTIDAD_SOLICITADA * $platillo->COSTO_PLATILLO)+$detallepedido->costo_cambio+$detallepedido->costo_guarnicion))==3){
                                if(strlen($platillo->COSTO_PLATILLO)==3){
                                    $impresora->text("                Q. ".$platillo->COSTO_PLATILLO."   Q. ".(($detallepedido->CANTIDAD_SOLICITADA * $platillo->COSTO_PLATILLO)+$detallepedido->costo_cambio+$detallepedido->costo_guarnicion));                      

                                }
                                else{
                                    $impresora->text("                Q. ".$platillo->COSTO_PLATILLO."    Q. ".(($detallepedido->CANTIDAD_SOLICITADA * $platillo->COSTO_PLATILLO)+$detallepedido->costo_cambio+$detallepedido->costo_guarnicion));                      

                                }
                                  
                               }
                               
                               else{
                                    $impresora->text("                Q. ".$platillo->COSTO_PLATILLO."    Q. ".(($detallepedido->CANTIDAD_SOLICITADA * $platillo->COSTO_PLATILLO)+$detallepedido->costo_cambio+$detallepedido->costo_guarnicion));                      

                               }
                               

                            }
                            elseif($var1==8){
                                if(strlen((($detallepedido->CANTIDAD_SOLICITADA * $platillo->COSTO_PLATILLO)+$detallepedido->costo_cambio+$detallepedido->costo_guarnicion))==2){
                                    $impresora->text("               Q. ".$platillo->COSTO_PLATILLO."    Q. ".(($detallepedido->CANTIDAD_SOLICITADA * $platillo->COSTO_PLATILLO)+$detallepedido->costo_cambio+$detallepedido->costo_guarnicion));                      

                               }
                               else if(strlen((($detallepedido->CANTIDAD_SOLICITADA * $platillo->COSTO_PLATILLO)+$detallepedido->costo_cambio+$detallepedido->costo_guarnicion))==1){
                                $impresora->text("               Q. ".$platillo->COSTO_PLATILLO."     Q. ".(($detallepedido->CANTIDAD_SOLICITADA * $platillo->COSTO_PLATILLO)+$detallepedido->costo_cambio+$detallepedido->costo_guarnicion));
                            }
                               else if(strlen((($detallepedido->CANTIDAD_SOLICITADA * $platillo->COSTO_PLATILLO)+$detallepedido->costo_cambio+$detallepedido->costo_guarnicion))==3){
                                if(strlen($platillo->COSTO_PLATILLO)==3){
                                    $impresora->text("               Q. ".$platillo->COSTO_PLATILLO."   Q. ".(($detallepedido->CANTIDAD_SOLICITADA * $platillo->COSTO_PLATILLO)+$detallepedido->costo_cambio+$detallepedido->costo_guarnicion));                      

                                }
                                else{
                                    $impresora->text("               Q. ".$platillo->COSTO_PLATILLO."    Q. ".(($detallepedido->CANTIDAD_SOLICITADA * $platillo->COSTO_PLATILLO)+$detallepedido->costo_cambio+$detallepedido->costo_guarnicion));                      

                                }
                                  
                               }
                               
                               else{
                                    $impresora->text("               Q. ".$platillo->COSTO_PLATILLO."    Q. ".(($detallepedido->CANTIDAD_SOLICITADA * $platillo->COSTO_PLATILLO)+$detallepedido->costo_cambio+$detallepedido->costo_guarnicion));                      

                               }

                            }
                            elseif($var1==9){
                                if(strlen((($detallepedido->CANTIDAD_SOLICITADA * $platillo->COSTO_PLATILLO)+$detallepedido->costo_cambio+$detallepedido->costo_guarnicion))==2){
                                    $impresora->text("              Q. ".$platillo->COSTO_PLATILLO."    Q. ".(($detallepedido->CANTIDAD_SOLICITADA * $platillo->COSTO_PLATILLO)+$detallepedido->costo_cambio+$detallepedido->costo_guarnicion));
                                }
                                else if(strlen((($detallepedido->CANTIDAD_SOLICITADA * $platillo->COSTO_PLATILLO)+$detallepedido->costo_cambio+$detallepedido->costo_guarnicion))==1){
                                    $impresora->text("              Q. ".$platillo->COSTO_PLATILLO."     Q. ".(($detallepedido->CANTIDAD_SOLICITADA * $platillo->COSTO_PLATILLO)+$detallepedido->costo_cambio+$detallepedido->costo_guarnicion));
                                }
                                else if(strlen((($detallepedido->CANTIDAD_SOLICITADA * $platillo->COSTO_PLATILLO)+$detallepedido->costo_cambio+$detallepedido->costo_guarnicion))==3){
                                    if(strlen($platillo->COSTO_PLATILLO)==3){
                                        $impresora->text("              Q. ".$platillo->COSTO_PLATILLO."   Q. ".(($detallepedido->CANTIDAD_SOLICITADA * $platillo->COSTO_PLATILLO)+$detallepedido->costo_cambio+$detallepedido->costo_guarnicion));                      

                                    }
                                    else{
                                        $impresora->text("              Q. ".$platillo->COSTO_PLATILLO."    Q. ".(($detallepedido->CANTIDAD_SOLICITADA * $platillo->COSTO_PLATILLO)+$detallepedido->costo_cambio+$detallepedido->costo_guarnicion));                      

                                    }
                                
                                }
                                
                                else{
                                    $impresora->text("                Q. ".$platillo->COSTO_PLATILLO."  Q. ".(($detallepedido->CANTIDAD_SOLICITADA * $platillo->COSTO_PLATILLO)+$detallepedido->costo_cambio+$detallepedido->costo_guarnicion));                      
                                }


                              //  $impresora->text("              Q. ".$platillo->COSTO_PLATILLO."    Q. ".(($detallepedido->CANTIDAD_SOLICITADA * $platillo->COSTO_PLATILLO)+$detallepedido->costo_cambio+$detallepedido->costo_guarnicion));                      

                            }
                            elseif($var1==10){
                                if(strlen((($detallepedido->CANTIDAD_SOLICITADA * $platillo->COSTO_PLATILLO)+$detallepedido->costo_cambio+$detallepedido->costo_guarnicion))==2){
                                    $impresora->text("             Q. ".$platillo->COSTO_PLATILLO."    Q. ".(($detallepedido->CANTIDAD_SOLICITADA * $platillo->COSTO_PLATILLO)+$detallepedido->costo_cambio+$detallepedido->costo_guarnicion));                      
                                }
                                else if(strlen((($detallepedido->CANTIDAD_SOLICITADA * $platillo->COSTO_PLATILLO)+$detallepedido->costo_cambio+$detallepedido->costo_guarnicion))==1){
                                    $impresora->text("             Q. ".$platillo->COSTO_PLATILLO."     Q. ".(($detallepedido->CANTIDAD_SOLICITADA * $platillo->COSTO_PLATILLO)+$detallepedido->costo_cambio+$detallepedido->costo_guarnicion));
                                }
                                else if(strlen((($detallepedido->CANTIDAD_SOLICITADA * $platillo->COSTO_PLATILLO)+$detallepedido->costo_cambio+$detallepedido->costo_guarnicion))==3){
                                    if(strlen($platillo->COSTO_PLATILLO)==3){
                                        $impresora->text("             Q. ".$platillo->COSTO_PLATILLO."   Q. ".(($detallepedido->CANTIDAD_SOLICITADA * $platillo->COSTO_PLATILLO)+$detallepedido->costo_cambio+$detallepedido->costo_guarnicion));                      
                               
                                    }
                                    else{
                                        $impresora->text("             Q. ".$platillo->COSTO_PLATILLO."    Q. ".(($detallepedido->CANTIDAD_SOLICITADA * $platillo->COSTO_PLATILLO)+$detallepedido->costo_cambio+$detallepedido->costo_guarnicion));                      
                               
                                    }
                                 }
                                
                                else{
                                    $impresora->text("             Q. ".$platillo->COSTO_PLATILLO."  Q. ".(($detallepedido->CANTIDAD_SOLICITADA * $platillo->COSTO_PLATILLO)+$detallepedido->costo_cambio+$detallepedido->costo_guarnicion));                      
                                }

                            }
                            elseif($var1==11){
                                if(strlen((($detallepedido->CANTIDAD_SOLICITADA * $platillo->COSTO_PLATILLO)+$detallepedido->costo_cambio+$detallepedido->costo_guarnicion))==2){
                                    $impresora->text("            Q. ".$platillo->COSTO_PLATILLO."    Q. ".(($detallepedido->CANTIDAD_SOLICITADA * $platillo->COSTO_PLATILLO)+$detallepedido->costo_cambio+$detallepedido->costo_guarnicion));                      

                               }
                               else if(strlen((($detallepedido->CANTIDAD_SOLICITADA * $platillo->COSTO_PLATILLO)+$detallepedido->costo_cambio+$detallepedido->costo_guarnicion))==1){
                                $impresora->text("            Q. ".$platillo->COSTO_PLATILLO."     Q. ".(($detallepedido->CANTIDAD_SOLICITADA * $platillo->COSTO_PLATILLO)+$detallepedido->costo_cambio+$detallepedido->costo_guarnicion));
                            }
                               else if(strlen((($detallepedido->CANTIDAD_SOLICITADA * $platillo->COSTO_PLATILLO)+$detallepedido->costo_cambio+$detallepedido->costo_guarnicion))==3){
                                if(strlen($platillo->COSTO_PLATILLO)==3){
                                    $impresora->text("            Q. ".$platillo->COSTO_PLATILLO."   Q. ".(($detallepedido->CANTIDAD_SOLICITADA * $platillo->COSTO_PLATILLO)+$detallepedido->costo_cambio+$detallepedido->costo_guarnicion));                      

                                }
                                else{
                                    $impresora->text("            Q. ".$platillo->COSTO_PLATILLO."    Q. ".(($detallepedido->CANTIDAD_SOLICITADA * $platillo->COSTO_PLATILLO)+$detallepedido->costo_cambio+$detallepedido->costo_guarnicion));                      

                                }
                                  
                               }
                               
                               else{
                                    $impresora->text("            Q. ".$platillo->COSTO_PLATILLO."    Q. ".(($detallepedido->CANTIDAD_SOLICITADA * $platillo->COSTO_PLATILLO)+$detallepedido->costo_cambio+$detallepedido->costo_guarnicion));                      

                               }
                            
                            }
                            elseif($var1==12){
                                if(strlen((($detallepedido->CANTIDAD_SOLICITADA * $platillo->COSTO_PLATILLO)+$detallepedido->costo_cambio+$detallepedido->costo_guarnicion))==2){
                                    $impresora->text("           Q. ".$platillo->COSTO_PLATILLO."    Q. ".(($detallepedido->CANTIDAD_SOLICITADA * $platillo->COSTO_PLATILLO)+$detallepedido->costo_cambio+$detallepedido->costo_guarnicion));                      
                                   }
                                   else if(strlen((($detallepedido->CANTIDAD_SOLICITADA * $platillo->COSTO_PLATILLO)+$detallepedido->costo_cambio+$detallepedido->costo_guarnicion))==1){
                                    $impresora->text("           Q. ".$platillo->COSTO_PLATILLO."     Q. ".(($detallepedido->CANTIDAD_SOLICITADA * $platillo->COSTO_PLATILLO)+$detallepedido->costo_cambio+$detallepedido->costo_guarnicion));
                                }
                                else if(strlen((($detallepedido->CANTIDAD_SOLICITADA * $platillo->COSTO_PLATILLO)+$detallepedido->costo_cambio+$detallepedido->costo_guarnicion))==3){
                                    if(strlen($platillo->COSTO_PLATILLO)==3){
                                        $impresora->text("           Q. ".$platillo->COSTO_PLATILLO."   Q. ".(($detallepedido->CANTIDAD_SOLICITADA * $platillo->COSTO_PLATILLO)+$detallepedido->costo_cambio+$detallepedido->costo_guarnicion));                      

                                    }
                                    else{
                                        $impresora->text("           Q. ".$platillo->COSTO_PLATILLO."    Q. ".(($detallepedido->CANTIDAD_SOLICITADA * $platillo->COSTO_PLATILLO)+$detallepedido->costo_cambio+$detallepedido->costo_guarnicion));                      

                                    }
                                  
                                }
                                
                                else{
                                    $impresora->text("           Q. ".$platillo->COSTO_PLATILLO."    Q. ".(($detallepedido->CANTIDAD_SOLICITADA * $platillo->COSTO_PLATILLO)+$detallepedido->costo_cambio+$detallepedido->costo_guarnicion));                      
                                  }


                          
                            }
                            elseif($var1==13){
                                if(strlen((($detallepedido->CANTIDAD_SOLICITADA * $platillo->COSTO_PLATILLO)+$detallepedido->costo_cambio+$detallepedido->costo_guarnicion))==2){
                                    $impresora->text("          Q. ".$platillo->COSTO_PLATILLO."    Q. ".(($detallepedido->CANTIDAD_SOLICITADA * $platillo->COSTO_PLATILLO)+$detallepedido->costo_cambio+$detallepedido->costo_guarnicion));                      
                                }
                                else if(strlen((($detallepedido->CANTIDAD_SOLICITADA * $platillo->COSTO_PLATILLO)+$detallepedido->costo_cambio+$detallepedido->costo_guarnicion))==1){
                                    $impresora->text("          Q. ".$platillo->COSTO_PLATILLO."     Q. ".(($detallepedido->CANTIDAD_SOLICITADA * $platillo->COSTO_PLATILLO)+$detallepedido->costo_cambio+$detallepedido->costo_guarnicion));
                                }
                                else if(strlen((($detallepedido->CANTIDAD_SOLICITADA * $platillo->COSTO_PLATILLO)+$detallepedido->costo_cambio+$detallepedido->costo_guarnicion))==3){
                                    if(strlen($platillo->COSTO_PLATILLO)==3){
                                        $impresora->text("          Q. ".$platillo->COSTO_PLATILLO."   Q. ".(($detallepedido->CANTIDAD_SOLICITADA * $platillo->COSTO_PLATILLO)+$detallepedido->costo_cambio+$detallepedido->costo_guarnicion));                      
                              
                                    }
                                    else{
                                        $impresora->text("          Q. ".$platillo->COSTO_PLATILLO."    Q. ".(($detallepedido->CANTIDAD_SOLICITADA * $platillo->COSTO_PLATILLO)+$detallepedido->costo_cambio+$detallepedido->costo_guarnicion));                      
                              
                                    }
                                  }
                                
                                else{
                                    $impresora->text("          Q. ".$platillo->COSTO_PLATILLO."  Q. ".(($detallepedido->CANTIDAD_SOLICITADA * $platillo->COSTO_PLATILLO)+$detallepedido->costo_cambio+$detallepedido->costo_guarnicion));                      
                                }


                            }
                            elseif($var1==14){
                                if(strlen((($detallepedido->CANTIDAD_SOLICITADA * $platillo->COSTO_PLATILLO)+$detallepedido->costo_cambio+$detallepedido->costo_guarnicion))==2){
                                    $impresora->text("         Q. ".$platillo->COSTO_PLATILLO."    Q. ".(($detallepedido->CANTIDAD_SOLICITADA * $platillo->COSTO_PLATILLO)+$detallepedido->costo_cambio+$detallepedido->costo_guarnicion));                      
                                }
                                else if(strlen((($detallepedido->CANTIDAD_SOLICITADA * $platillo->COSTO_PLATILLO)+$detallepedido->costo_cambio+$detallepedido->costo_guarnicion))==1){
                                    $impresora->text("         Q. ".$platillo->COSTO_PLATILLO."     Q. ".(($detallepedido->CANTIDAD_SOLICITADA * $platillo->COSTO_PLATILLO)+$detallepedido->costo_cambio+$detallepedido->costo_guarnicion));
                                }
                                else if(strlen((($detallepedido->CANTIDAD_SOLICITADA * $platillo->COSTO_PLATILLO)+$detallepedido->costo_cambio+$detallepedido->costo_guarnicion))==3){
                                    if(strlen($platillo->COSTO_PLATILLO)==3){
                                        $impresora->text("         Q. ".$platillo->COSTO_PLATILLO."   Q. ".(($detallepedido->CANTIDAD_SOLICITADA * $platillo->COSTO_PLATILLO)+$detallepedido->costo_cambio+$detallepedido->costo_guarnicion));                      
                              
                                    }
                                    else{
                                        $impresora->text("         Q. ".$platillo->COSTO_PLATILLO."    Q. ".(($detallepedido->CANTIDAD_SOLICITADA * $platillo->COSTO_PLATILLO)+$detallepedido->costo_cambio+$detallepedido->costo_guarnicion));                      
                              
                                    }
                                 }
                                
                                else{
                                    $impresora->text("         Q. ".$platillo->COSTO_PLATILLO."  Q. ".(($detallepedido->CANTIDAD_SOLICITADA * $platillo->COSTO_PLATILLO)+$detallepedido->costo_cambio+$detallepedido->costo_guarnicion));                      
                                }

                           //     $impresora->text("         Q. ".$platillo->COSTO_PLATILLO."    Q. ".(($detallepedido->CANTIDAD_SOLICITADA * $platillo->COSTO_PLATILLO)+$detallepedido->costo_cambio+$detallepedido->costo_guarnicion));                      

                            }
                            elseif($var1==15){
                                if(strlen((($detallepedido->CANTIDAD_SOLICITADA * $platillo->COSTO_PLATILLO)+$detallepedido->costo_cambio+$detallepedido->costo_guarnicion))==2){
                                    $impresora->text("        Q. ".$platillo->COSTO_PLATILLO."    Q. ".(($detallepedido->CANTIDAD_SOLICITADA * $platillo->COSTO_PLATILLO)+$detallepedido->costo_cambio+$detallepedido->costo_guarnicion));                      
                                }
                                else if(strlen((($detallepedido->CANTIDAD_SOLICITADA * $platillo->COSTO_PLATILLO)+$detallepedido->costo_cambio+$detallepedido->costo_guarnicion))==1){
                                    $impresora->text("        Q. ".$platillo->COSTO_PLATILLO."     Q. ".(($detallepedido->CANTIDAD_SOLICITADA * $platillo->COSTO_PLATILLO)+$detallepedido->costo_cambio+$detallepedido->costo_guarnicion));
                                }
                                else if(strlen((($detallepedido->CANTIDAD_SOLICITADA * $platillo->COSTO_PLATILLO)+$detallepedido->costo_cambio+$detallepedido->costo_guarnicion))==3){
                                    
                                    if(strlen($platillo->COSTO_PLATILLO)==3){
                                        $impresora->text("        Q. ".$platillo->COSTO_PLATILLO."   Q. ".(($detallepedido->CANTIDAD_SOLICITADA * $platillo->COSTO_PLATILLO)+$detallepedido->costo_cambio+$detallepedido->costo_guarnicion));                      
                               
                                    }
                                    else{
                                        $impresora->text("        Q. ".$platillo->COSTO_PLATILLO."    Q. ".(($detallepedido->CANTIDAD_SOLICITADA * $platillo->COSTO_PLATILLO)+$detallepedido->costo_cambio+$detallepedido->costo_guarnicion));                      
                               
                                    }
                                 }
                                
                                else{
                                    $impresora->text("        Q. ".$platillo->COSTO_PLATILLO."  Q. ".(($detallepedido->CANTIDAD_SOLICITADA * $platillo->COSTO_PLATILLO)+$detallepedido->costo_cambio+$detallepedido->costo_guarnicion));                      
                                }

                           //     $impresora->text("        Q. ".$platillo->COSTO_PLATILLO."    Q. ".(($detallepedido->CANTIDAD_SOLICITADA * $platillo->COSTO_PLATILLO)+$detallepedido->costo_cambio+$detallepedido->costo_guarnicion));                      

                            }
                            elseif($var1==16){
                                if(strlen((($detallepedido->CANTIDAD_SOLICITADA * $platillo->COSTO_PLATILLO)+$detallepedido->costo_cambio+$detallepedido->costo_guarnicion))==2){
                                    $impresora->text("       Q. ".$platillo->COSTO_PLATILLO."    Q. ".(($detallepedido->CANTIDAD_SOLICITADA * $platillo->COSTO_PLATILLO)+($detallepedido->costo_cambio-$detallepedido->costo_guarnicion)));                      
                                }
                                else if(strlen((($detallepedido->CANTIDAD_SOLICITADA * $platillo->COSTO_PLATILLO)+$detallepedido->costo_cambio+$detallepedido->costo_guarnicion))==1){
                                    $impresora->text("       Q. ".$platillo->COSTO_PLATILLO."     Q. ".(($detallepedido->CANTIDAD_SOLICITADA * $platillo->COSTO_PLATILLO)+$detallepedido->costo_cambio+$detallepedido->costo_guarnicion));
                                }
                                else if(strlen((($detallepedido->CANTIDAD_SOLICITADA * $platillo->COSTO_PLATILLO)+$detallepedido->costo_cambio+$detallepedido->costo_guarnicion))==3){
                                    if(strlen($platillo->COSTO_PLATILLO)==3){
                                        $impresora->text("       Q. ".$platillo->COSTO_PLATILLO."   Q. ".(($detallepedido->CANTIDAD_SOLICITADA * $platillo->COSTO_PLATILLO)+$detallepedido->costo_cambio+$detallepedido->costo_guarnicion));                      
                               
                                    }
                                    else{
                                        $impresora->text("       Q. ".$platillo->COSTO_PLATILLO."    Q. ".(($detallepedido->CANTIDAD_SOLICITADA * $platillo->COSTO_PLATILLO)+$detallepedido->costo_cambio+$detallepedido->costo_guarnicion));                      
                               
                                    }
                                }
                                
                                else{
                                    $impresora->text("       Q. ".$platillo->COSTO_PLATILLO."  Q. ".(($detallepedido->CANTIDAD_SOLICITADA * $platillo->COSTO_PLATILLO)+$detallepedido->costo_cambio+$detallepedido->costo_guarnicion));                      
                                }
                              //  $impresora->text("       Q. ".$platillo->COSTO_PLATILLO."    Q. ".(($detallepedido->CANTIDAD_SOLICITADA * $platillo->COSTO_PLATILLO)+$detallepedido->costo_cambio+$detallepedido->costo_guarnicion));                      

                            }
                            elseif($var1==17){
                                if(strlen((($detallepedido->CANTIDAD_SOLICITADA * $platillo->COSTO_PLATILLO)+$detallepedido->costo_cambio+$detallepedido->costo_guarnicion))==2){
                                    $impresora->text("      Q. ".$platillo->COSTO_PLATILLO."    Q. ".(($detallepedido->CANTIDAD_SOLICITADA * $platillo->COSTO_PLATILLO)+$detallepedido->costo_cambio+$detallepedido->costo_guarnicion));                      
                                }
                                else if(strlen((($detallepedido->CANTIDAD_SOLICITADA * $platillo->COSTO_PLATILLO)+$detallepedido->costo_cambio+$detallepedido->costo_guarnicion))==1){
                                    $impresora->text("      Q. ".$platillo->COSTO_PLATILLO."     Q. ".(($detallepedido->CANTIDAD_SOLICITADA * $platillo->COSTO_PLATILLO)+$detallepedido->costo_cambio+$detallepedido->costo_guarnicion));
                                }
                                else if(strlen((($detallepedido->CANTIDAD_SOLICITADA * $platillo->COSTO_PLATILLO)+$detallepedido->costo_cambio+$detallepedido->costo_guarnicion))==3){
                                    if(strlen($platillo->COSTO_PLATILLO)==3){
                                        $impresora->text("      Q. ".$platillo->COSTO_PLATILLO."   Q. ".(($detallepedido->CANTIDAD_SOLICITADA * $platillo->COSTO_PLATILLO)+$detallepedido->costo_cambio+$detallepedido->costo_guarnicion));                      
                              
                                    }
                                    else{
                                        $impresora->text("      Q. ".$platillo->COSTO_PLATILLO."    Q. ".(($detallepedido->CANTIDAD_SOLICITADA * $platillo->COSTO_PLATILLO)+$detallepedido->costo_cambio+$detallepedido->costo_guarnicion));                      
                              
                                    }
                                 }
                                
                                else{
                                    $impresora->text("      Q. ".$platillo->COSTO_PLATILLO."  Q. ".(($detallepedido->CANTIDAD_SOLICITADA * $platillo->COSTO_PLATILLO)+$detallepedido->costo_cambio+$detallepedido->costo_guarnicion));                      
                                }
                              //  $impresora->text("      Q. ".$platillo->COSTO_PLATILLO."    Q. ".(($detallepedido->CANTIDAD_SOLICITADA * $platillo->COSTO_PLATILLO)+$detallepedido->costo_cambio+$detallepedido->costo_guarnicion));                      

                            }
                            elseif($var1==18){
                                if(strlen((($detallepedido->CANTIDAD_SOLICITADA * $platillo->COSTO_PLATILLO)+$detallepedido->costo_cambio+$detallepedido->costo_guarnicion))==2){
                                    $impresora->text("     Q. ".$platillo->COSTO_PLATILLO."    Q. ".(($detallepedido->CANTIDAD_SOLICITADA * $platillo->COSTO_PLATILLO)+$detallepedido->costo_cambio+$detallepedido->costo_guarnicion));                      
                                }
                                else if(strlen((($detallepedido->CANTIDAD_SOLICITADA * $platillo->COSTO_PLATILLO)+$detallepedido->costo_cambio+$detallepedido->costo_guarnicion))==1){
                                    $impresora->text("     Q. ".$platillo->COSTO_PLATILLO."     Q. ".(($detallepedido->CANTIDAD_SOLICITADA * $platillo->COSTO_PLATILLO)+$detallepedido->costo_cambio+$detallepedido->costo_guarnicion));
                                }
                                else if(strlen((($detallepedido->CANTIDAD_SOLICITADA * $platillo->COSTO_PLATILLO)+$detallepedido->costo_cambio+$detallepedido->costo_guarnicion))==3){
                                    if(strlen($platillo->COSTO_PLATILLO)==3){
                                        $impresora->text("     Q. ".$platillo->COSTO_PLATILLO."   Q. ".(($detallepedido->CANTIDAD_SOLICITADA * $platillo->COSTO_PLATILLO)+$detallepedido->costo_cambio+$detallepedido->costo_guarnicion));                      
                               
                                    }
                                    else{
                                        $impresora->text("     Q. ".$platillo->COSTO_PLATILLO."    Q. ".(($detallepedido->CANTIDAD_SOLICITADA * $platillo->COSTO_PLATILLO)+$detallepedido->costo_cambio+$detallepedido->costo_guarnicion));                      
                               
                                    }
                                 }
                                
                                else{
                                    $impresora->text("     Q. ".$platillo->COSTO_PLATILLO."  Q. ".(($detallepedido->CANTIDAD_SOLICITADA * $platillo->COSTO_PLATILLO)+$detallepedido->costo_cambio+$detallepedido->costo_guarnicion));                      
                                }
                              //  $impresora->text("     Q. ".$platillo->COSTO_PLATILLO."    Q. ".(($detallepedido->CANTIDAD_SOLICITADA * $platillo->COSTO_PLATILLO)+$detallepedido->costo_cambio+$detallepedido->costo_guarnicion));                      

                            }
                            elseif($var1==19){
                                if(strlen((($detallepedido->CANTIDAD_SOLICITADA * $platillo->COSTO_PLATILLO)+$detallepedido->costo_cambio+$detallepedido->costo_guarnicion))==2){
                                    $impresora->text("    Q. ".$platillo->COSTO_PLATILLO."    Q. ".(($detallepedido->CANTIDAD_SOLICITADA * $platillo->COSTO_PLATILLO)+$detallepedido->costo_cambio+$detallepedido->costo_guarnicion));                      
                                }
                                else if(strlen((($detallepedido->CANTIDAD_SOLICITADA * $platillo->COSTO_PLATILLO)+$detallepedido->costo_cambio+$detallepedido->costo_guarnicion))==1){
                                    $impresora->text("    Q. ".$platillo->COSTO_PLATILLO."     Q. ".(($detallepedido->CANTIDAD_SOLICITADA * $platillo->COSTO_PLATILLO)+$detallepedido->costo_cambio+$detallepedido->costo_guarnicion));
                                }
                                else if(strlen((($detallepedido->CANTIDAD_SOLICITADA * $platillo->COSTO_PLATILLO)+$detallepedido->costo_cambio+$detallepedido->costo_guarnicion))==3){
                                    if(strlen($platillo->COSTO_PLATILLO)==3){
                                        $impresora->text("    Q. ".$platillo->COSTO_PLATILLO."   Q. ".(($detallepedido->CANTIDAD_SOLICITADA * $platillo->COSTO_PLATILLO)+$detallepedido->costo_cambio+$detallepedido->costo_guarnicion));                      
                               
                                    }
                                    else{
                                        $impresora->text("    Q. ".$platillo->COSTO_PLATILLO."    Q. ".(($detallepedido->CANTIDAD_SOLICITADA * $platillo->COSTO_PLATILLO)+$detallepedido->costo_cambio+$detallepedido->costo_guarnicion));                      
                               
                                    }
                                }
                                
                                else{
                                    $impresora->text("    Q. ".$platillo->COSTO_PLATILLO."  Q. ".(($detallepedido->CANTIDAD_SOLICITADA * $platillo->COSTO_PLATILLO)+$detallepedido->costo_cambio+$detallepedido->costo_guarnicion));                      
                                }
                               // $impresora->text("    Q. ".$platillo->COSTO_PLATILLO."    Q. ".(($detallepedido->CANTIDAD_SOLICITADA * $platillo->COSTO_PLATILLO)+$detallepedido->costo_cambio+$detallepedido->costo_guarnicion));                      

                            }
                            elseif($var1==20){
                                if(strlen((($detallepedido->CANTIDAD_SOLICITADA * $platillo->COSTO_PLATILLO)+$detallepedido->costo_cambio+$detallepedido->costo_guarnicion))==2){
                                    $impresora->text("   Q. ".$platillo->COSTO_PLATILLO."    Q. ".(($detallepedido->CANTIDAD_SOLICITADA * $platillo->COSTO_PLATILLO)+$detallepedido->costo_cambio+$detallepedido->costo_guarnicion));                      
                                }
                                else if(strlen((($detallepedido->CANTIDAD_SOLICITADA * $platillo->COSTO_PLATILLO)+$detallepedido->costo_cambio+$detallepedido->costo_guarnicion))==1){
                                    $impresora->text("   Q. ".$platillo->COSTO_PLATILLO."     Q. ".(($detallepedido->CANTIDAD_SOLICITADA * $platillo->COSTO_PLATILLO)+$detallepedido->costo_cambio+$detallepedido->costo_guarnicion));
                                }
                                else if(strlen((($detallepedido->CANTIDAD_SOLICITADA * $platillo->COSTO_PLATILLO)+$detallepedido->costo_cambio+$detallepedido->costo_guarnicion))==3){
                                    if(strlen($platillo->COSTO_PLATILLO)==3){
                                        $impresora->text("   Q. ".$platillo->COSTO_PLATILLO."   Q. ".(($detallepedido->CANTIDAD_SOLICITADA * $platillo->COSTO_PLATILLO)+$detallepedido->costo_cambio+$detallepedido->costo_guarnicion));                      
                               
                                    }
                                    else{
                                        $impresora->text("   Q. ".$platillo->COSTO_PLATILLO."    Q. ".(($detallepedido->CANTIDAD_SOLICITADA * $platillo->COSTO_PLATILLO)+$detallepedido->costo_cambio+$detallepedido->costo_guarnicion));                      
                               
                                    }
                                }
                                
                                else{
                                    $impresora->text("   Q. ".$platillo->COSTO_PLATILLO."  Q. ".(($detallepedido->CANTIDAD_SOLICITADA * $platillo->COSTO_PLATILLO)+$detallepedido->costo_cambio+$detallepedido->costo_guarnicion));                      
                                }
                              //  $impresora->text("   Q. ".$platillo->COSTO_PLATILLO."    Q. ".(($detallepedido->CANTIDAD_SOLICITADA * $platillo->COSTO_PLATILLO)+$detallepedido->costo_cambio+$detallepedido->costo_guarnicion));                      

                            }
                            elseif($var1==21){
                                if(strlen((($detallepedido->CANTIDAD_SOLICITADA * $platillo->COSTO_PLATILLO)+$detallepedido->costo_cambio+$detallepedido->costo_guarnicion))==2){
                                    $impresora->text("  Q. ".$platillo->COSTO_PLATILLO."    Q. ".(($detallepedido->CANTIDAD_SOLICITADA * $platillo->COSTO_PLATILLO)+$detallepedido->costo_cambio+$detallepedido->costo_guarnicion));                      
                                }
                                else if(strlen((($detallepedido->CANTIDAD_SOLICITADA * $platillo->COSTO_PLATILLO)+$detallepedido->costo_cambio+$detallepedido->costo_guarnicion))==1){
                                    $impresora->text("  Q. ".$platillo->COSTO_PLATILLO."     Q. ".(($detallepedido->CANTIDAD_SOLICITADA * $platillo->COSTO_PLATILLO)+$detallepedido->costo_cambio+$detallepedido->costo_guarnicion));
                                }
                                else if(strlen((($detallepedido->CANTIDAD_SOLICITADA * $platillo->COSTO_PLATILLO)+$detallepedido->costo_cambio+$detallepedido->costo_guarnicion))==3){
                                    if(strlen($platillo->COSTO_PLATILLO)==3){
                                        $impresora->text("  Q. ".$platillo->COSTO_PLATILLO."   Q. ".(($detallepedido->CANTIDAD_SOLICITADA * $platillo->COSTO_PLATILLO)+$detallepedido->costo_cambio+$detallepedido->costo_guarnicion));                      
                                
                                    }
                                    else{
                                        $impresora->text("  Q. ".$platillo->COSTO_PLATILLO."    Q. ".(($detallepedido->CANTIDAD_SOLICITADA * $platillo->COSTO_PLATILLO)+$detallepedido->costo_cambio+$detallepedido->costo_guarnicion));                      
                                
                                    }
                                  }
                                
                                else{
                                    $impresora->text("  Q. ".$platillo->COSTO_PLATILLO."  Q. ".(($detallepedido->CANTIDAD_SOLICITADA * $platillo->COSTO_PLATILLO)+$detallepedido->costo_cambio+$detallepedido->costo_guarnicion));                      
                                }
                              //  $impresora->text("  Q. ".$platillo->COSTO_PLATILLO."    Q. ".(($detallepedido->CANTIDAD_SOLICITADA * $platillo->COSTO_PLATILLO)+$detallepedido->costo_cambio+$detallepedido->costo_guarnicion));                      

                            }

                         $impresora->text("\n");    
                    }
                       
                    }
                }
                foreach($this->bebidasc as $bebida){
                    
                    if( $detallepedido->ID_PLATILLO == $bebida->ID_BEBIDA and $detallepedido->extra==0){
                        $this->subtotalp=$this->subtotalp + $detallepedido->SUB_TOTAL;
                        $var1=strlen($bebida->TITUTLO_BEBIDA);
                        if($var1>22 or $var1==22){
                            $impresora->setJustification(Printer::JUSTIFY_LEFT);
                            
                            if(strlen($detallepedido->CANTIDAD_SOLICITADA)==1){
                                $impresora->text($detallepedido->CANTIDAD_SOLICITADA."     ");
                                $impresora->text($bebida->TITUTLO_BEBIDA." ".$detallepedido->OBSERVACION);
                            }
                            else if(strlen($detallepedido->CANTIDAD_SOLICITADA)==2){
                                $impresora->text($detallepedido->CANTIDAD_SOLICITADA."    ");
                                $impresora->text($bebida->TITUTLO_BEBIDA." ".$detallepedido->OBSERVACION);
                            }else if(strlen($detallepedido->CANTIDAD_SOLICITADA)==3){
                                $impresora->text($detallepedido->CANTIDAD_SOLICITADA."   ");
                                $impresora->text($bebida->TITUTLO_BEBIDA." ".$detallepedido->OBSERVACION);
                            }
                            
                            $impresora->text("\n");
                            $impresora->setJustification(Printer::JUSTIFY_RIGHT);
                            if(strlen(($detallepedido->CANTIDAD_SOLICITADA * $bebida->COSTO_BEBIDA))==2){
                                $impresora->text("Q. ".$bebida->COSTO_BEBIDA."    Q. ".($detallepedido->CANTIDAD_SOLICITADA * $bebida->COSTO_BEBIDA)."     ");
                                
                            }
    
                            else if(strlen(($detallepedido->CANTIDAD_SOLICITADA * $bebida->COSTO_BEBIDA))==3){
                                $impresora->text("Q. ".$bebida->COSTO_BEBIDA);
                                $impresora->setJustification(Printer::JUSTIFY_RIGHT);
                                $impresora->text("   Q. ".($detallepedido->CANTIDAD_SOLICITADA * $bebida->COSTO_BEBIDA)."    ");
                             }
                             else{
                                $impresora->text("Q. ".$bebida->COSTO_BEBIDA);
                                $impresora->setJustification(Printer::JUSTIFY_RIGHT);
                               // $impresora->text("     Q. ".($detallepedido->CANTIDAD_SOLICITADA * $bebida->COSTO_BEBIDA)."     ");
                                $impresora->text("     Q. ".($detallepedido->CANTIDAD_SOLICITADA * $bebida->COSTO_BEBIDA)."     ");
                                            
                           
                              //  $impresora->text("      Q. ".(($detallepedido->CANTIDAD_SOLICITADA * $platillo->COSTO_PLATILLO)+$detallepedido->costo_cambio+$detallepedido->costo_guarnicion."      "));
                             
                             }
                            $impresora->text("\n");

                            }else{

                                $impresora->setJustification(Printer::JUSTIFY_LEFT);
                                if(strlen($detallepedido->CANTIDAD_SOLICITADA)==1){
                                    $impresora->text($detallepedido->CANTIDAD_SOLICITADA."     ");
                                    $impresora->text($bebida->TITUTLO_BEBIDA);
                                }
                                else if(strlen($detallepedido->CANTIDAD_SOLICITADA)==2){
                                    $impresora->text($detallepedido->CANTIDAD_SOLICITADA."    ");
                                    $impresora->text($bebida->TITUTLO_BEBIDA);
                                }else if(strlen($detallepedido->CANTIDAD_SOLICITADA)==3){
                                    $impresora->text($detallepedido->CANTIDAD_SOLICITADA."   ");
                                    $impresora->text($bebida->TITUTLO_BEBIDA);
                                }
    
                                $impresora->setJustification(Printer::JUSTIFY_RIGHT);
                                if($var1==2){
                                    if(strlen($detallepedido->CANTIDAD_SOLICITADA * $bebida->COSTO_BEBIDA)==2){

                                        $impresora->text("                     Q. ".$bebida->COSTO_BEBIDA."    Q. ".($detallepedido->CANTIDAD_SOLICITADA * $bebida->COSTO_BEBIDA));
                                    }
                                    else if(strlen($detallepedido->CANTIDAD_SOLICITADA * $bebida->COSTO_BEBIDA)==1){
                                        $impresora->text("                     Q. ".$bebida->COSTO_BEBIDA."     Q. ".($detallepedido->CANTIDAD_SOLICITADA * $bebida->COSTO_BEBIDA));
                                     }
                                    else if(strlen($detallepedido->CANTIDAD_SOLICITADA * $bebida->COSTO_BEBIDA)==3){
                                        if(strlen($platillo->COSTO_PLATILLO)==3){
                                            $impresora->text("                     Q. ".$bebida->COSTO_BEBIDA."  Q. ".($detallepedido->CANTIDAD_SOLICITADA * $bebida->COSTO_BEBIDA));
                                    
                                        }
                                        else{
                                            $impresora->text("                     Q. ".$bebida->COSTO_BEBIDA."   Q. ".($detallepedido->CANTIDAD_SOLICITADA * $bebida->COSTO_BEBIDA));
                                    
                                        }
                                     }
                                    
                                    else{
                                        $impresora->text("                     Q. ".$bebida->COSTO_BEBIDA."  Q. ".($detallepedido->CANTIDAD_SOLICITADA * $bebida->COSTO_BEBIDA));
                                    }
    
                                    
                                    
                                }

                                if($var1==3){
                                    if(strlen($detallepedido->CANTIDAD_SOLICITADA * $bebida->COSTO_BEBIDA)==2){

                                        $impresora->text("                    Q. ".$bebida->COSTO_BEBIDA."    Q. ".($detallepedido->CANTIDAD_SOLICITADA * $bebida->COSTO_BEBIDA));
                                    }
                                    else if(strlen($detallepedido->CANTIDAD_SOLICITADA * $bebida->COSTO_BEBIDA)==1){
                                        $impresora->text("                    Q. ".$bebida->COSTO_BEBIDA."     Q. ".($detallepedido->CANTIDAD_SOLICITADA * $bebida->COSTO_BEBIDA));
                                     }
                                    else if(strlen($detallepedido->CANTIDAD_SOLICITADA * $bebida->COSTO_BEBIDA)==3){
                                        if(strlen($platillo->COSTO_PLATILLO)==3){
                                            $impresora->text("                    Q. ".$bebida->COSTO_BEBIDA."  Q. ".($detallepedido->CANTIDAD_SOLICITADA * $bebida->COSTO_BEBIDA));
                                    
                                        }
                                        else{
                                            $impresora->text("                    Q. ".$bebida->COSTO_BEBIDA."   Q. ".($detallepedido->CANTIDAD_SOLICITADA * $bebida->COSTO_BEBIDA));
                                    
                                        }
                                     }
                                    
                                    else{
                                        $impresora->text("                    Q. ".$bebida->COSTO_BEBIDA."  Q. ".($detallepedido->CANTIDAD_SOLICITADA * $bebida->COSTO_BEBIDA));
                                    }
    
                                    
                                    
                                }

                                if($var1==4){
                                    if(strlen($detallepedido->CANTIDAD_SOLICITADA * $bebida->COSTO_BEBIDA)==2){

                                        $impresora->text("                    Q. ".$bebida->COSTO_BEBIDA."    Q. ".($detallepedido->CANTIDAD_SOLICITADA * $bebida->COSTO_BEBIDA));
                                    }
                                    else if(strlen($detallepedido->CANTIDAD_SOLICITADA * $bebida->COSTO_BEBIDA)==1){
                                        $impresora->text("                    Q. ".$bebida->COSTO_BEBIDA."      Q. ".($detallepedido->CANTIDAD_SOLICITADA * $bebida->COSTO_BEBIDA));
                                     }
                                    else if(strlen($detallepedido->CANTIDAD_SOLICITADA * $bebida->COSTO_BEBIDA)==3){
                                        if(strlen($platillo->COSTO_PLATILLO)==3){
                                            $impresora->text("                    Q. ".$bebida->COSTO_BEBIDA."  Q. ".($detallepedido->CANTIDAD_SOLICITADA * $bebida->COSTO_BEBIDA));
                                    
                                        }
                                        else{
                                            $impresora->text("                    Q. ".$bebida->COSTO_BEBIDA."   Q. ".($detallepedido->CANTIDAD_SOLICITADA * $bebida->COSTO_BEBIDA));
                                    
                                        }
                                     }
                                    
                                    else{
                                        $impresora->text("                    Q. ".$bebida->COSTO_BEBIDA."  Q. ".($detallepedido->CANTIDAD_SOLICITADA * $bebida->COSTO_BEBIDA));
                                    }
    
                                    
                                    
                                }

                                if($var1==5){
                                    if(strlen($detallepedido->CANTIDAD_SOLICITADA * $bebida->COSTO_BEBIDA)==2){

                                        $impresora->text("                  Q. ".$bebida->COSTO_BEBIDA."    Q. ".($detallepedido->CANTIDAD_SOLICITADA * $bebida->COSTO_BEBIDA));
                                    }
                                    else if(strlen($detallepedido->CANTIDAD_SOLICITADA * $bebida->COSTO_BEBIDA)==1){
                                        $impresora->text("                  Q. ".$bebida->COSTO_BEBIDA."     Q. ".($detallepedido->CANTIDAD_SOLICITADA * $bebida->COSTO_BEBIDA));
                                     }
                                    else if(strlen($detallepedido->CANTIDAD_SOLICITADA * $bebida->COSTO_BEBIDA)==3){
                                        if(strlen($platillo->COSTO_PLATILLO)==3){
                                            $impresora->text("                  Q. ".$bebida->COSTO_BEBIDA."  Q. ".($detallepedido->CANTIDAD_SOLICITADA * $bebida->COSTO_BEBIDA));
                                    
                                        }
                                        else{
                                            $impresora->text("                  Q. ".$bebida->COSTO_BEBIDA."   Q. ".($detallepedido->CANTIDAD_SOLICITADA * $bebida->COSTO_BEBIDA));
                                    
                                        }
                                     }
                                    
                                    else{
                                        $impresora->text("                  Q. ".$bebida->COSTO_BEBIDA."  Q. ".($detallepedido->CANTIDAD_SOLICITADA * $bebida->COSTO_BEBIDA));
                                    }
    
                                    
                                    
                                }
                                elseif($var1==6){
                                    if(strlen($detallepedido->CANTIDAD_SOLICITADA * $bebida->COSTO_BEBIDA)==2){
                                         $impresora->text("                 Q. ".$bebida->COSTO_BEBIDA."    Q. ".($detallepedido->CANTIDAD_SOLICITADA * $bebida->COSTO_BEBIDA));                      
    
                                    }
                                    else if(strlen($detallepedido->CANTIDAD_SOLICITADA * $bebida->COSTO_BEBIDA)==1){
                                        $impresora->text("                 Q. ".$bebida->COSTO_BEBIDA."     Q. ".($detallepedido->CANTIDAD_SOLICITADA * $bebida->COSTO_BEBIDA));
                                     }
                                    else if(strlen($detallepedido->CANTIDAD_SOLICITADA * $bebida->COSTO_BEBIDA)==3){
                                        if(strlen($platillo->COSTO_PLATILLO)==3){
                                            $impresora->text("                 Q. ".$bebida->COSTO_BEBIDA."   Q. ".($detallepedido->CANTIDAD_SOLICITADA * $bebida->COSTO_BEBIDA));                      
    
                                        }
                                        else{
                                            $impresora->text("                 Q. ".$bebida->COSTO_BEBIDA."    Q. ".($detallepedido->CANTIDAD_SOLICITADA * $bebida->COSTO_BEBIDA));                      
    
                                        }
                                       
                                    }
                                    
                                    else{
                                         $impresora->text("                 Q. ".$bebida->COSTO_BEBIDA."    Q. ".($detallepedido->CANTIDAD_SOLICITADA * $bebida->COSTO_BEBIDA));                      
    
                                    }
                                    
                                   
                                }
                                elseif($var1==7){
                                    if(strlen($detallepedido->CANTIDAD_SOLICITADA * $bebida->COSTO_BEBIDA)==2){
                                        $impresora->text("                Q. ".$bebida->COSTO_BEBIDA."    Q. ".($detallepedido->CANTIDAD_SOLICITADA * $bebida->COSTO_BEBIDA));                      
    
                                   }
                                   else if(strlen($detallepedido->CANTIDAD_SOLICITADA * $bebida->COSTO_BEBIDA)==1){
                                    $impresora->text("                Q. ".$bebida->COSTO_BEBIDA."     Q. ".($detallepedido->CANTIDAD_SOLICITADA * $bebida->COSTO_BEBIDA));
                                 }
                                   else if(strlen($detallepedido->CANTIDAD_SOLICITADA * $bebida->COSTO_BEBIDA)==3){
                                    if(strlen($platillo->COSTO_PLATILLO)==3){
                                        $impresora->text("                Q. ".$bebida->COSTO_BEBIDA."   Q. ".($detallepedido->CANTIDAD_SOLICITADA * $bebida->COSTO_BEBIDA));                      
    
                                    }
                                    else{
                                        $impresora->text("                Q. ".$bebida->COSTO_BEBIDA."    Q. ".($detallepedido->CANTIDAD_SOLICITADA * $bebida->COSTO_BEBIDA));                      
    
                                    }
                                      
                                   }
                                   
                                   else{
                                        $impresora->text("                Q. ".$bebida->COSTO_BEBIDA."    Q. ".($detallepedido->CANTIDAD_SOLICITADA * $bebida->COSTO_BEBIDA));                      
    
                                   }
                                   
    
                                }
                                elseif($var1==8){
                                    if(strlen($detallepedido->CANTIDAD_SOLICITADA * $bebida->COSTO_BEBIDA)==2){
                                        $impresora->text("               Q. ".$bebida->COSTO_BEBIDA."    Q. ".($detallepedido->CANTIDAD_SOLICITADA * $bebida->COSTO_BEBIDA));                      
    
                                   }
                                   else if(strlen($detallepedido->CANTIDAD_SOLICITADA * $bebida->COSTO_BEBIDA)==1){
                                    $impresora->text("                Q. ".$bebida->COSTO_BEBIDA."     Q. ".($detallepedido->CANTIDAD_SOLICITADA * $bebida->COSTO_BEBIDA));
                                 }
                                   else if(strlen($detallepedido->CANTIDAD_SOLICITADA * $bebida->COSTO_BEBIDA)==3){
                                    if(strlen($platillo->COSTO_PLATILLO)==3){
                                        $impresora->text("               Q. ".$bebida->COSTO_BEBIDA."   Q. ".($detallepedido->CANTIDAD_SOLICITADA * $bebida->COSTO_BEBIDA));                      
    
                                    }
                                    else{
                                        $impresora->text("               Q. ".$bebida->COSTO_BEBIDA."    Q. ".($detallepedido->CANTIDAD_SOLICITADA * $bebida->COSTO_BEBIDA));                      
    
                                    }
                                      
                                   }
                                   
                                   else{
                                        $impresora->text("               Q. ".$bebida->COSTO_BEBIDA."    Q. ".($detallepedido->CANTIDAD_SOLICITADA * $bebida->COSTO_BEBIDA));                      
    
                                   }
    
                                }
                                elseif($var1==9){
                                    if(strlen($detallepedido->CANTIDAD_SOLICITADA * $bebida->COSTO_BEBIDA)==2){
                                        $impresora->text("              Q. ".$bebida->COSTO_BEBIDA."    Q. ".($detallepedido->CANTIDAD_SOLICITADA * $bebida->COSTO_BEBIDA));
                                    }
                                    else if(strlen($detallepedido->CANTIDAD_SOLICITADA * $bebida->COSTO_BEBIDA)==1){
                                        $impresora->text("              Q. ".$bebida->COSTO_BEBIDA."     Q. ".($detallepedido->CANTIDAD_SOLICITADA * $bebida->COSTO_BEBIDA));
                                     }
            
                                    else if(strlen($detallepedido->CANTIDAD_SOLICITADA * $bebida->COSTO_BEBIDA)==3){
                                        if(strlen($platillo->COSTO_PLATILLO)==3){
                                            $impresora->text("              Q. ".$bebida->COSTO_BEBIDA."   Q. ".($detallepedido->CANTIDAD_SOLICITADA * $bebida->COSTO_BEBIDA));                      
    
                                        }
                                        else{
                                            $impresora->text("              Q. ".$bebida->COSTO_BEBIDA."    Q. ".($detallepedido->CANTIDAD_SOLICITADA * $bebida->COSTO_BEBIDA));                      
    
                                        }
                                    
                                    }
                                    
                                    else{
                                        $impresora->text("              Q. ".$bebida->COSTO_BEBIDA."  Q. ".($detallepedido->CANTIDAD_SOLICITADA * $bebida->COSTO_BEBIDA));                      
                                    }
    
    
                                  //  $impresora->text("              Q. ".$bebida->COSTO_BEBIDA."    Q. ".($detallepedido->CANTIDAD_SOLICITADA * $bebida->COSTO_BEBIDA));                      
    
                                }
                                elseif($var1==10){
                                    if(strlen($detallepedido->CANTIDAD_SOLICITADA * $bebida->COSTO_BEBIDA)==2){
                                        $impresora->text("             Q. ".$bebida->COSTO_BEBIDA."    Q. ".($detallepedido->CANTIDAD_SOLICITADA * $bebida->COSTO_BEBIDA));                      
                                    }
                                    else if(strlen($detallepedido->CANTIDAD_SOLICITADA * $bebida->COSTO_BEBIDA)==1){
                                        $impresora->text("             Q. ".$bebida->COSTO_BEBIDA."     Q. ".($detallepedido->CANTIDAD_SOLICITADA * $bebida->COSTO_BEBIDA));
                                     }
                                    else if(strlen($detallepedido->CANTIDAD_SOLICITADA * $bebida->COSTO_BEBIDA)==3){
                                        if(strlen($platillo->COSTO_PLATILLO)==3){
                                            $impresora->text("             Q. ".$bebida->COSTO_BEBIDA."   Q. ".($detallepedido->CANTIDAD_SOLICITADA * $bebida->COSTO_BEBIDA));                      
                                   
                                        }
                                        else{
                                            $impresora->text("             Q. ".$bebida->COSTO_BEBIDA."   Q. ".($detallepedido->CANTIDAD_SOLICITADA * $bebida->COSTO_BEBIDA));                      
                                   
                                        }
                                      }
                                    
                                    else{
                                        $impresora->text("             Q. ".$bebida->COSTO_BEBIDA."  Q. ".($detallepedido->CANTIDAD_SOLICITADA * $bebida->COSTO_BEBIDA));                      
                                    }
    
                                }
                                elseif($var1==11){
                                    if(strlen($detallepedido->CANTIDAD_SOLICITADA * $bebida->COSTO_BEBIDA)==2){
                                        $impresora->text("            Q. ".$bebida->COSTO_BEBIDA."    Q. ".($detallepedido->CANTIDAD_SOLICITADA * $bebida->COSTO_BEBIDA));                      
    
                                   }
                                   else if(strlen($detallepedido->CANTIDAD_SOLICITADA * $bebida->COSTO_BEBIDA)==1){
                                    $impresora->text("            Q. ".$bebida->COSTO_BEBIDA."     Q. ".($detallepedido->CANTIDAD_SOLICITADA * $bebida->COSTO_BEBIDA));
                                 }
                                   else if(strlen($detallepedido->CANTIDAD_SOLICITADA * $bebida->COSTO_BEBIDA)==3){
                                    if(strlen($platillo->COSTO_PLATILLO)==3){
                                        $impresora->text("            Q. ".$bebida->COSTO_BEBIDA."   Q. ".($detallepedido->CANTIDAD_SOLICITADA * $bebida->COSTO_BEBIDA));                      
    
                                    }
                                    else{
                                        $impresora->text("            Q. ".$bebida->COSTO_BEBIDA."    Q. ".($detallepedido->CANTIDAD_SOLICITADA * $bebida->COSTO_BEBIDA));                      
    
                                    }
                                       
                                   }
                                   
                                   else{
                                        $impresora->text("            Q. ".$bebida->COSTO_BEBIDA."    Q. ".($detallepedido->CANTIDAD_SOLICITADA * $bebida->COSTO_BEBIDA));                      
    
                                   }
                                
                                }
                                elseif($var1==12){
                                    if(strlen($detallepedido->CANTIDAD_SOLICITADA * $bebida->COSTO_BEBIDA)==2){
                                        $impresora->text("           Q. ".$bebida->COSTO_BEBIDA."    Q. ".($detallepedido->CANTIDAD_SOLICITADA * $bebida->COSTO_BEBIDA));                      
                                       }
                                       else if(strlen($detallepedido->CANTIDAD_SOLICITADA * $bebida->COSTO_BEBIDA)==1){
                                        $impresora->text("           Q. ".$bebida->COSTO_BEBIDA."     Q. ".($detallepedido->CANTIDAD_SOLICITADA * $bebida->COSTO_BEBIDA));
                                     }
            
                                    else if(strlen($detallepedido->CANTIDAD_SOLICITADA * $bebida->COSTO_BEBIDA)==3){
                                        if(strlen($platillo->COSTO_PLATILLO)==3){
                                            $impresora->text("           Q. ".$bebida->COSTO_BEBIDA."   Q. ".($detallepedido->CANTIDAD_SOLICITADA * $bebida->COSTO_BEBIDA));                      
    
                                        }
                                        else{
                                            $impresora->text("           Q. ".$bebida->COSTO_BEBIDA."    Q. ".($detallepedido->CANTIDAD_SOLICITADA * $bebida->COSTO_BEBIDA));                      
    
                                        }
                                        
                                    }
                                    
                                    else{
                                        $impresora->text("           Q. ".$bebida->COSTO_BEBIDA."    Q. ".($detallepedido->CANTIDAD_SOLICITADA * $bebida->COSTO_BEBIDA));                      
                                      }
    
    
                              
                                }
                                elseif($var1==13){
                                    if(strlen($detallepedido->CANTIDAD_SOLICITADA * $bebida->COSTO_BEBIDA)==2){
                                        $impresora->text("          Q. ".$bebida->COSTO_BEBIDA."    Q. ".($detallepedido->CANTIDAD_SOLICITADA * $bebida->COSTO_BEBIDA));                      
                                    }
                                    else if(strlen($detallepedido->CANTIDAD_SOLICITADA * $bebida->COSTO_BEBIDA)==1){
                                        $impresora->text("          Q. ".$bebida->COSTO_BEBIDA."     Q. ".($detallepedido->CANTIDAD_SOLICITADA * $bebida->COSTO_BEBIDA));
                                     }
            
                                    else if(strlen($detallepedido->CANTIDAD_SOLICITADA * $bebida->COSTO_BEBIDA)==3){
                                        if(strlen($platillo->COSTO_PLATILLO)==3){
                                            $impresora->text("          Q. ".$bebida->COSTO_BEBIDA."   Q. ".($detallepedido->CANTIDAD_SOLICITADA * $bebida->COSTO_BEBIDA));                      
                                   
                                        }
                                        else{
                                            $impresora->text("          Q. ".$bebida->COSTO_BEBIDA."    Q. ".($detallepedido->CANTIDAD_SOLICITADA * $bebida->COSTO_BEBIDA));                      
                                   
                                        }
                                     }
                                    
                                    else{
                                        $impresora->text("          Q. ".$bebida->COSTO_BEBIDA."  Q. ".($detallepedido->CANTIDAD_SOLICITADA * $bebida->COSTO_BEBIDA));                      
                                    }
    
    
                                }
                                elseif($var1==14){
                                    if(strlen($detallepedido->CANTIDAD_SOLICITADA * $bebida->COSTO_BEBIDA)==2){
                                        $impresora->text("         Q. ".$bebida->COSTO_BEBIDA."    Q. ".($detallepedido->CANTIDAD_SOLICITADA * $bebida->COSTO_BEBIDA));                      
                                    }
                                    else if(strlen($detallepedido->CANTIDAD_SOLICITADA * $bebida->COSTO_BEBIDA)==1){
                                        $impresora->text("         Q. ".$bebida->COSTO_BEBIDA."     Q. ".($detallepedido->CANTIDAD_SOLICITADA * $bebida->COSTO_BEBIDA));
                                     }
                                    else if(strlen($detallepedido->CANTIDAD_SOLICITADA * $bebida->COSTO_BEBIDA)==3){
                                        if(strlen($platillo->COSTO_PLATILLO)==3){
                                            $impresora->text("         Q. ".$bebida->COSTO_BEBIDA."   Q. ".($detallepedido->CANTIDAD_SOLICITADA * $bebida->COSTO_BEBIDA));                      
                                 
                                        }
                                        else{
                                            $impresora->text("         Q. ".$bebida->COSTO_BEBIDA."    Q. ".($detallepedido->CANTIDAD_SOLICITADA * $bebida->COSTO_BEBIDA));                      
                                 
                                        }
                                      }
                                    
                                    else{
                                        $impresora->text("         Q. ".$bebida->COSTO_BEBIDA."  Q. ".($detallepedido->CANTIDAD_SOLICITADA * $bebida->COSTO_BEBIDA));                      
                                    }
    
                               //     $impresora->text("         Q. ".$bebida->COSTO_BEBIDA."    Q. ".($detallepedido->CANTIDAD_SOLICITADA * $bebida->COSTO_BEBIDA));                      
    
                                }
                                elseif($var1==15){
                                    if(strlen($detallepedido->CANTIDAD_SOLICITADA * $bebida->COSTO_BEBIDA)==2){
                                        $impresora->text("        Q. ".$bebida->COSTO_BEBIDA."    Q. ".($detallepedido->CANTIDAD_SOLICITADA * $bebida->COSTO_BEBIDA));                      
                                    }
                                    else if(strlen($detallepedido->CANTIDAD_SOLICITADA * $bebida->COSTO_BEBIDA)==1){
                                        $impresora->text("        Q. ".$bebida->COSTO_BEBIDA."     Q. ".($detallepedido->CANTIDAD_SOLICITADA * $bebida->COSTO_BEBIDA));
                                     }
                                    else if(strlen($detallepedido->CANTIDAD_SOLICITADA * $bebida->COSTO_BEBIDA)==3){
                                        if(strlen($platillo->COSTO_PLATILLO)==3){
                                            $impresora->text("        Q. ".$bebida->COSTO_BEBIDA."   Q. ".($detallepedido->CANTIDAD_SOLICITADA * $bebida->COSTO_BEBIDA));                      
                                   
                                        }
                                        else{
                                            $impresora->text("        Q. ".$bebida->COSTO_BEBIDA."    Q. ".($detallepedido->CANTIDAD_SOLICITADA * $bebida->COSTO_BEBIDA));                      
                                   
                                        }
                                     }
                                    
                                    else{
                                        $impresora->text("        Q. ".$bebida->COSTO_BEBIDA."  Q. ".($detallepedido->CANTIDAD_SOLICITADA * $bebida->COSTO_BEBIDA));                      
                                    }
    
                               //     $impresora->text("        Q. ".$bebida->COSTO_BEBIDA."    Q. ".($detallepedido->CANTIDAD_SOLICITADA * $bebida->COSTO_BEBIDA));                      
    
                                }
                                elseif($var1==16){
                                    if(strlen($detallepedido->CANTIDAD_SOLICITADA * $bebida->COSTO_BEBIDA)==2){
                                        $impresora->text("       Q. ".$bebida->COSTO_BEBIDA."    Q. ".($detallepedido->CANTIDAD_SOLICITADA * $bebida->COSTO_BEBIDA));                      
                                    }
                                    else if(strlen($detallepedido->CANTIDAD_SOLICITADA * $bebida->COSTO_BEBIDA)==1){
                                        $impresora->text("       Q. ".$bebida->COSTO_BEBIDA."     Q. ".($detallepedido->CANTIDAD_SOLICITADA * $bebida->COSTO_BEBIDA));
                                     }
                                    else if(strlen($detallepedido->CANTIDAD_SOLICITADA * $bebida->COSTO_BEBIDA)==3){
                                        if(strlen($platillo->COSTO_PLATILLO)==3){
                                            $impresora->text("       Q. ".$bebida->COSTO_BEBIDA."   Q. ".($detallepedido->CANTIDAD_SOLICITADA * $bebida->COSTO_BEBIDA));                      
                                   
                                        }
                                        else{
                                            $impresora->text("       Q. ".$bebida->COSTO_BEBIDA."    Q. ".($detallepedido->CANTIDAD_SOLICITADA * $bebida->COSTO_BEBIDA));                      
                                   
                                        }
                                    }
                                    
                                    else{
                                        $impresora->text("       Q. ".$bebida->COSTO_BEBIDA."  Q. ".($detallepedido->CANTIDAD_SOLICITADA * $bebida->COSTO_BEBIDA));                      
                                    }
                                  //  $impresora->text("       Q. ".$bebida->COSTO_BEBIDA."    Q. ".($detallepedido->CANTIDAD_SOLICITADA * $bebida->COSTO_BEBIDA));                      
    
                                }
                                elseif($var1==17){
                                    if(strlen($detallepedido->CANTIDAD_SOLICITADA * $bebida->COSTO_BEBIDA)==2){
                                        $impresora->text("      Q. ".$bebida->COSTO_BEBIDA."    Q. ".($detallepedido->CANTIDAD_SOLICITADA * $bebida->COSTO_BEBIDA));                      
                                    }
                                    else if(strlen($detallepedido->CANTIDAD_SOLICITADA * $bebida->COSTO_BEBIDA)==1){
                                        $impresora->text("      Q. ".$bebida->COSTO_BEBIDA."     Q. ".($detallepedido->CANTIDAD_SOLICITADA * $bebida->COSTO_BEBIDA));
                                     }
                                    else if(strlen($detallepedido->CANTIDAD_SOLICITADA * $bebida->COSTO_BEBIDA)==3){
                                        if(strlen($platillo->COSTO_PLATILLO)==3){
                                            $impresora->text("      Q. ".$bebida->COSTO_BEBIDA."   Q. ".($detallepedido->CANTIDAD_SOLICITADA * $bebida->COSTO_BEBIDA));                      
                                   
                                        }
                                        else{
                                            $impresora->text("      Q. ".$bebida->COSTO_BEBIDA."    Q. ".($detallepedido->CANTIDAD_SOLICITADA * $bebida->COSTO_BEBIDA));                      
                                   
                                        }
                                     }
                                    
                                    else{
                                        $impresora->text("      Q. ".$bebida->COSTO_BEBIDA."  Q. ".($detallepedido->CANTIDAD_SOLICITADA * $bebida->COSTO_BEBIDA));                      
                                    }
                                  //  $impresora->text("      Q. ".$bebida->COSTO_BEBIDA."    Q. ".($detallepedido->CANTIDAD_SOLICITADA * $bebida->COSTO_BEBIDA));                      
    
                                }
                                elseif($var1==18){
                                    if(strlen($detallepedido->CANTIDAD_SOLICITADA * $bebida->COSTO_BEBIDA)==2){
                                        $impresora->text("     Q. ".$bebida->COSTO_BEBIDA."    Q. ".($detallepedido->CANTIDAD_SOLICITADA * $bebida->COSTO_BEBIDA));                      
                                    }
                                    else if(strlen($detallepedido->CANTIDAD_SOLICITADA * $bebida->COSTO_BEBIDA)==1){
                                        $impresora->text("     Q. ".$bebida->COSTO_BEBIDA."     Q. ".($detallepedido->CANTIDAD_SOLICITADA * $bebida->COSTO_BEBIDA));
                                     }
                                    else if(strlen($detallepedido->CANTIDAD_SOLICITADA * $bebida->COSTO_BEBIDA)==3){
                                        if(strlen($platillo->COSTO_PLATILLO)==3){
                                            $impresora->text("     Q. ".$bebida->COSTO_BEBIDA."   Q. ".($detallepedido->CANTIDAD_SOLICITADA * $bebida->COSTO_BEBIDA));                      
                                   
                                        }
                                        else{
                                            $impresora->text("     Q. ".$bebida->COSTO_BEBIDA."    Q. ".($detallepedido->CANTIDAD_SOLICITADA * $bebida->COSTO_BEBIDA));                      
                                   
                                        }
                                       }
                                    
                                    else{
                                        $impresora->text("     Q. ".$bebida->COSTO_BEBIDA."  Q. ".($detallepedido->CANTIDAD_SOLICITADA * $bebida->COSTO_BEBIDA));                      
                                    }
                                  //  $impresora->text("     Q. ".$bebida->COSTO_BEBIDA."    Q. ".($detallepedido->CANTIDAD_SOLICITADA * $bebida->COSTO_BEBIDA));                      
    
                                }
                                elseif($var1==19){
                                    if(strlen($detallepedido->CANTIDAD_SOLICITADA * $bebida->COSTO_BEBIDA)==2){
                                        $impresora->text("    Q. ".$bebida->COSTO_BEBIDA."    Q. ".($detallepedido->CANTIDAD_SOLICITADA * $bebida->COSTO_BEBIDA));                      
                                    }
                                    else if(strlen($detallepedido->CANTIDAD_SOLICITADA * $bebida->COSTO_BEBIDA)==1){
                                        $impresora->text("    Q. ".$bebida->COSTO_BEBIDA."     Q. ".($detallepedido->CANTIDAD_SOLICITADA * $bebida->COSTO_BEBIDA));
                                     }
                                    else if(strlen($detallepedido->CANTIDAD_SOLICITADA * $bebida->COSTO_BEBIDA)==3){
                                        if(strlen($platillo->COSTO_PLATILLO)==3){
                                            $impresora->text("    Q. ".$bebida->COSTO_BEBIDA."   Q. ".($detallepedido->CANTIDAD_SOLICITADA * $bebida->COSTO_BEBIDA));                      
                                 
                                        }
                                        else{
                                            $impresora->text("    Q. ".$bebida->COSTO_BEBIDA."    Q. ".($detallepedido->CANTIDAD_SOLICITADA * $bebida->COSTO_BEBIDA));                      
                                 
                                        }
                                    }
                                    
                                    else{
                                        $impresora->text("    Q. ".$bebida->COSTO_BEBIDA."  Q. ".($detallepedido->CANTIDAD_SOLICITADA * $bebida->COSTO_BEBIDA));                      
                                    }
                                   // $impresora->text("    Q. ".$bebida->COSTO_BEBIDA."    Q. ".($detallepedido->CANTIDAD_SOLICITADA * $bebida->COSTO_BEBIDA));                      
    
                                }
                                elseif($var1==20){
                                    if(strlen($detallepedido->CANTIDAD_SOLICITADA * $bebida->COSTO_BEBIDA)==2){
                                        $impresora->text("   Q. ".$bebida->COSTO_BEBIDA."    Q. ".($detallepedido->CANTIDAD_SOLICITADA * $bebida->COSTO_BEBIDA));                      
                                    }
                                    else if(strlen($detallepedido->CANTIDAD_SOLICITADA * $bebida->COSTO_BEBIDA)==1){
                                        $impresora->text("   Q. ".$bebida->COSTO_BEBIDA."     Q. ".($detallepedido->CANTIDAD_SOLICITADA * $bebida->COSTO_BEBIDA));
                                     }
                                    else if(strlen($detallepedido->CANTIDAD_SOLICITADA * $bebida->COSTO_BEBIDA)==3){
                                        if(strlen($platillo->COSTO_PLATILLO)==3){
                                            $impresora->text("   Q. ".$bebida->COSTO_BEBIDA."   Q. ".($detallepedido->CANTIDAD_SOLICITADA * $bebida->COSTO_BEBIDA));                      
                                
                                        }
                                        else{
                                            $impresora->text("   Q. ".$bebida->COSTO_BEBIDA."    Q. ".($detallepedido->CANTIDAD_SOLICITADA * $bebida->COSTO_BEBIDA));                      
                                
                                        }
                                      }
                                    
                                    else{
                                        $impresora->text("   Q. ".$bebida->COSTO_BEBIDA."  Q. ".($detallepedido->CANTIDAD_SOLICITADA * $bebida->COSTO_BEBIDA));                      
                                    }
                                  //  $impresora->text("   Q. ".$bebida->COSTO_BEBIDA."    Q. ".($detallepedido->CANTIDAD_SOLICITADA * $bebida->COSTO_BEBIDA));                      
    
                                }
                                elseif($var1==21){
                                    if(strlen($detallepedido->CANTIDAD_SOLICITADA * $bebida->COSTO_BEBIDA)==2){
                                        $impresora->text("  Q. ".$bebida->COSTO_BEBIDA."    Q. ".($detallepedido->CANTIDAD_SOLICITADA * $bebida->COSTO_BEBIDA));                      
                                    }
                                    else if(strlen($detallepedido->CANTIDAD_SOLICITADA * $bebida->COSTO_BEBIDA)==1){
                                        $impresora->text("  Q. ".$bebida->COSTO_BEBIDA."     Q. ".($detallepedido->CANTIDAD_SOLICITADA * $bebida->COSTO_BEBIDA));
                                     }
                                    else if(strlen($detallepedido->CANTIDAD_SOLICITADA * $bebida->COSTO_BEBIDA)==3){
                                        if(strlen($platillo->COSTO_PLATILLO)==3){
                                            $impresora->text("  Q. ".$bebida->COSTO_BEBIDA."   Q. ".($detallepedido->CANTIDAD_SOLICITADA * $bebida->COSTO_BEBIDA));                      
                               
                                        }
                                        else{
                                            $impresora->text("  Q. ".$bebida->COSTO_BEBIDA."    Q. ".($detallepedido->CANTIDAD_SOLICITADA * $bebida->COSTO_BEBIDA));                      
                               
                                        }
                                         }
                                    
                                    else{
                                        $impresora->text("  Q. ".$bebida->COSTO_BEBIDA."  Q. ".($detallepedido->CANTIDAD_SOLICITADA * $bebida->COSTO_BEBIDA));                      
                                    }
                                  //  $impresora->text("  Q. ".$bebida->COSTO_BEBIDA."    Q. ".($detallepedido->CANTIDAD_SOLICITADA * $bebida->COSTO_BEBIDA));                      
    
                                }
    
                             $impresora->text("\n");    
                        }
                           


                    }
                }
            
            }
            $impresora->setJustification(Printer::JUSTIFY_LEFT);
            $impresora->text("\n");
            $impresora->text("Extras\n");
            $impresora->text("================================================\n");
            $impresora->text("\n");
            $impresora->text("Cant. Descripción         ");
            $impresora->setJustification(Printer::JUSTIFY_RIGHT);
            $impresora->text("   Precio   Totales\n");
            $impresora->text("\n");
                        foreach($this->detallepedidos2 as $detallepedido){
                            foreach($this->platillosc as $platillo){
                                if($detallepedido->ID_PLATILLO==$platillo->ID_PLATILLO and $detallepedido->extra==2){
                                    $this->subtotalex=($this->subtotalex+$detallepedido->SUB_TOTAL);;
                                    $var1=strlen($platillo->TITULO_PLATILLO);
                                    $var2=strlen($detallepedido->OBSERVACION);
                                    if(($var1+$var2)>=22 or ($var1+$var2)==22){
                                        $impresora->setJustification(Printer::JUSTIFY_LEFT);
                                        
                                        if(strlen($detallepedido->CANTIDAD_SOLICITADA)==1){
                                            $impresora->text($detallepedido->CANTIDAD_SOLICITADA."     ");
                                           // $impresora->text($platillo->TITULO_PLATILLO." ".$detallepedido->OBSERVACION);
                                            if(($var1+$var2)>30){
                                                $sub1=substr($platillo->TITULO_PLATILLO." ".$detallepedido->OBSERVACION,0,28);
                                                $sub2=substr($platillo->TITULO_PLATILLO." ".$detallepedido->OBSERVACION,29);
                                                $impresora->text($sub1."...");
                                                $impresora->text("\n");
                                                $impresora->text("      ".$sub2);
                                            }
                                            else{
                                                $impresora->text($platillo->TITULO_PLATILLO." ".$detallepedido->OBSERVACION);
                                            }
                
                                            
                                        }
                                        else if(strlen($detallepedido->CANTIDAD_SOLICITADA)==2){
                                            $impresora->text($detallepedido->CANTIDAD_SOLICITADA."    ");
                                            if(($var1+$var2)>30){
                                                $sub1=substr($platillo->TITULO_PLATILLO." ".$detallepedido->OBSERVACION,0,28);
                                                $sub2=substr($platillo->TITULO_PLATILLO." ".$detallepedido->OBSERVACION,29);
                                                $impresora->text($sub1."...");
                                                $impresora->text("\n");
                                                $impresora->text("      ".$sub2);
                                            }
                                            else{
                                                $impresora->text($platillo->TITULO_PLATILLO." ".$detallepedido->OBSERVACION);
                                            }
                                        }else if(strlen($detallepedido->CANTIDAD_SOLICITADA)==3){
                                            $impresora->text($detallepedido->CANTIDAD_SOLICITADA."   ");
                                            if(($var1+$var2)>30){
                                                $sub1=substr($platillo->TITULO_PLATILLO." ".$detallepedido->OBSERVACION,0,28);
                                                $sub2=substr($platillo->TITULO_PLATILLO." ".$detallepedido->OBSERVACION,29);
                                                $impresora->text($sub1."...");
                                                $impresora->text("\n");
                                                $impresora->text("      ".$sub2);
                                            }
                                            else{
                                                $impresora->text($platillo->TITULO_PLATILLO." ".$detallepedido->OBSERVACION);
                                            }
                                        }
                                        
                                        $impresora->text("\n");


                                        $impresora->setJustification(Printer::JUSTIFY_RIGHT);
                                        if(strlen((($detallepedido->CANTIDAD_SOLICITADA * $platillo->COSTO_PLATILLO)+$detallepedido->costo_cambio+$detallepedido->costo_guarnicion))==2){
                                            $impresora->text("Q. ".$platillo->COSTO_PLATILLO."    Q. ".(($detallepedido->CANTIDAD_SOLICITADA * $platillo->COSTO_PLATILLO)+($detallepedido->costo_cambio-$detallepedido->costo_guarnicion)."     "));
                                            
                                        }
                                        else if(strlen((($detallepedido->CANTIDAD_SOLICITADA * $platillo->COSTO_PLATILLO)+$detallepedido->costo_cambio+$detallepedido->costo_guarnicion))==1){
                                            $impresora->text("Q. ".$platillo->COSTO_PLATILLO);
                                            $impresora->setJustification(Printer::JUSTIFY_RIGHT);
                                            $impresora->text("     Q. ".(($detallepedido->CANTIDAD_SOLICITADA * $platillo->COSTO_PLATILLO)+($detallepedido->costo_cambio-$detallepedido->costo_guarnicion)."      "));
                                         
                                         }
                                        else if(strlen((($detallepedido->CANTIDAD_SOLICITADA * $platillo->COSTO_PLATILLO)+$detallepedido->costo_cambio+$detallepedido->costo_guarnicion))==3){
                                            $impresora->text("Q. ".$platillo->COSTO_PLATILLO);
                                            $impresora->setJustification(Printer::JUSTIFY_RIGHT);
                                            $impresora->text("   Q. ".(($detallepedido->CANTIDAD_SOLICITADA * $platillo->COSTO_PLATILLO)+($detallepedido->costo_cambio-$detallepedido->costo_guarnicion)."    "));
                                         }
                                         else
                                        {
                                            $impresora->text("Q. ".$platillo->COSTO_PLATILLO);
                                            $impresora->setJustification(Printer::JUSTIFY_RIGHT);
                                            $impresora->text("     Q. ".(($detallepedido->CANTIDAD_SOLICITADA * $platillo->COSTO_PLATILLO)+($detallepedido->costo_cambio-$detallepedido->costo_guarnicion)."      "));
                                         
                                        }

                                        $impresora->text("\n");
                                        }else{
                                            $impresora->setJustification(Printer::JUSTIFY_LEFT);
                                            if(strlen($detallepedido->CANTIDAD_SOLICITADA)==1){
                                                $impresora->text($detallepedido->CANTIDAD_SOLICITADA."     ");
                                                $impresora->text($platillo->TITULO_PLATILLO);
                                            }
                                            else if(strlen($detallepedido->CANTIDAD_SOLICITADA)==2){
                                                $impresora->text($detallepedido->CANTIDAD_SOLICITADA."    ");
                                                $impresora->text($platillo->TITULO_PLATILLO);
                                            }else if(strlen($detallepedido->CANTIDAD_SOLICITADA)==3){
                                                $impresora->text($detallepedido->CANTIDAD_SOLICITADA."   ");
                                                $impresora->text($platillo->TITULO_PLATILLO);
                                            }
                
                                            $impresora->setJustification(Printer::JUSTIFY_RIGHT);
                                            if($var1==2){
                                                if(strlen((($detallepedido->CANTIDAD_SOLICITADA * $platillo->COSTO_PLATILLO)+$detallepedido->costo_cambio+$detallepedido->costo_guarnicion))==2){
                                                    $impresora->text("                     Q. ".$platillo->COSTO_PLATILLO."    Q. ".(($detallepedido->CANTIDAD_SOLICITADA * $platillo->COSTO_PLATILLO)+$detallepedido->costo_cambio+$detallepedido->costo_guarnicion));
                                                }
                                                else if(strlen((($detallepedido->CANTIDAD_SOLICITADA * $platillo->COSTO_PLATILLO)+$detallepedido->costo_cambio+$detallepedido->costo_guarnicion))==1){
                                                    $impresora->text("                     Q. ".$platillo->COSTO_PLATILLO."     Q. ".(($detallepedido->CANTIDAD_SOLICITADA * $platillo->COSTO_PLATILLO)+$detallepedido->costo_cambio+$detallepedido->costo_guarnicion));
                                                }
                                                else if(strlen((($detallepedido->CANTIDAD_SOLICITADA * $platillo->COSTO_PLATILLO)+$detallepedido->costo_cambio+$detallepedido->costo_guarnicion))==3){
                                                    if(strlen($platillo->COSTO_PLATILLO)==3){
                                                        $impresora->text("                     Q. ".$platillo->COSTO_PLATILLO."   Q. ".(($detallepedido->CANTIDAD_SOLICITADA * $platillo->COSTO_PLATILLO)+$detallepedido->costo_cambio+$detallepedido->costo_guarnicion));
                                                
                                                    }
                                                    else{
                                                        $impresora->text("                     Q. ".$platillo->COSTO_PLATILLO."    Q. ".(($detallepedido->CANTIDAD_SOLICITADA * $platillo->COSTO_PLATILLO)+$detallepedido->costo_cambio+$detallepedido->costo_guarnicion));
                                                
                                                    }
                                                 }
                                                
                                                else{
                                                    $impresora->text("                     Q. ".$platillo->COSTO_PLATILLO."  Q. ".(($detallepedido->CANTIDAD_SOLICITADA * $platillo->COSTO_PLATILLO)+$detallepedido->costo_cambio+$detallepedido->costo_guarnicion));
                                                }
 
                                            }
                                            if($var1==3){
                                                if(strlen((($detallepedido->CANTIDAD_SOLICITADA * $platillo->COSTO_PLATILLO)+$detallepedido->costo_cambio+$detallepedido->costo_guarnicion))==2){
                                                    $impresora->text("                    Q. ".$platillo->COSTO_PLATILLO."    Q. ".(($detallepedido->CANTIDAD_SOLICITADA * $platillo->COSTO_PLATILLO)+$detallepedido->costo_cambio+$detallepedido->costo_guarnicion));
                                                }
                                                else if(strlen((($detallepedido->CANTIDAD_SOLICITADA * $platillo->COSTO_PLATILLO)+$detallepedido->costo_cambio+$detallepedido->costo_guarnicion))==1){
                                                    $impresora->text("                    Q. ".$platillo->COSTO_PLATILLO."     Q. ".(($detallepedido->CANTIDAD_SOLICITADA * $platillo->COSTO_PLATILLO)+$detallepedido->costo_cambio+$detallepedido->costo_guarnicion));
                                                }
                                                else if(strlen((($detallepedido->CANTIDAD_SOLICITADA * $platillo->COSTO_PLATILLO)+$detallepedido->costo_cambio+$detallepedido->costo_guarnicion))==3){
                                                    if(strlen($platillo->COSTO_PLATILLO)==3){
                                                        $impresora->text("                    Q. ".$platillo->COSTO_PLATILLO."   Q. ".(($detallepedido->CANTIDAD_SOLICITADA * $platillo->COSTO_PLATILLO)+$detallepedido->costo_cambio+$detallepedido->costo_guarnicion));
                                                
                                                    }
                                                    else{
                                                        $impresora->text("                    Q. ".$platillo->COSTO_PLATILLO."    Q. ".(($detallepedido->CANTIDAD_SOLICITADA * $platillo->COSTO_PLATILLO)+$detallepedido->costo_cambio+$detallepedido->costo_guarnicion));
                                                
                                                    }
                                                 }
                                                
                                                else{
                                                    $impresora->text("                    Q. ".$platillo->COSTO_PLATILLO."  Q. ".(($detallepedido->CANTIDAD_SOLICITADA * $platillo->COSTO_PLATILLO)+$detallepedido->costo_cambio+$detallepedido->costo_guarnicion));
                                                }
 
                                            }

                                            if($var1==4){
                                                if(strlen((($detallepedido->CANTIDAD_SOLICITADA * $platillo->COSTO_PLATILLO)+$detallepedido->costo_cambio+$detallepedido->costo_guarnicion))==2){
                                                    $impresora->text("                   Q. ".$platillo->COSTO_PLATILLO."    Q. ".(($detallepedido->CANTIDAD_SOLICITADA * $platillo->COSTO_PLATILLO)+$detallepedido->costo_cambio+$detallepedido->costo_guarnicion));
                                                }
                                                else if(strlen((($detallepedido->CANTIDAD_SOLICITADA * $platillo->COSTO_PLATILLO)+$detallepedido->costo_cambio+$detallepedido->costo_guarnicion))==1){
                                                    $impresora->text("                   Q. ".$platillo->COSTO_PLATILLO."     Q. ".(($detallepedido->CANTIDAD_SOLICITADA * $platillo->COSTO_PLATILLO)+$detallepedido->costo_cambio+$detallepedido->costo_guarnicion));
                                                }
                                                else if(strlen((($detallepedido->CANTIDAD_SOLICITADA * $platillo->COSTO_PLATILLO)+$detallepedido->costo_cambio+$detallepedido->costo_guarnicion))==3){
                                                    if(strlen($platillo->COSTO_PLATILLO)==3){
                                                        $impresora->text("                   Q. ".$platillo->COSTO_PLATILLO."   Q. ".(($detallepedido->CANTIDAD_SOLICITADA * $platillo->COSTO_PLATILLO)+$detallepedido->costo_cambio+$detallepedido->costo_guarnicion));
                                                
                                                    }
                                                    else{
                                                        $impresora->text("                   Q. ".$platillo->COSTO_PLATILLO."    Q. ".(($detallepedido->CANTIDAD_SOLICITADA * $platillo->COSTO_PLATILLO)+$detallepedido->costo_cambio+$detallepedido->costo_guarnicion));
                                                
                                                    }
                                                 }
                                                
                                                else{
                                                    $impresora->text("                   Q. ".$platillo->COSTO_PLATILLO."  Q. ".(($detallepedido->CANTIDAD_SOLICITADA * $platillo->COSTO_PLATILLO)+$detallepedido->costo_cambio+$detallepedido->costo_guarnicion));
                                                }
 
                                            }
                                            if($var1==5){
                                                if(strlen((($detallepedido->CANTIDAD_SOLICITADA * $platillo->COSTO_PLATILLO)+$detallepedido->costo_cambio+$detallepedido->costo_guarnicion))==2){
                                                    $impresora->text("                  Q. ".$platillo->COSTO_PLATILLO."    Q. ".(($detallepedido->CANTIDAD_SOLICITADA * $platillo->COSTO_PLATILLO)+$detallepedido->costo_cambio+$detallepedido->costo_guarnicion));
                                                }
                                                else if(strlen((($detallepedido->CANTIDAD_SOLICITADA * $platillo->COSTO_PLATILLO)+$detallepedido->costo_cambio+$detallepedido->costo_guarnicion))==1){
                                                    $impresora->text("                  Q. ".$platillo->COSTO_PLATILLO."     Q. ".(($detallepedido->CANTIDAD_SOLICITADA * $platillo->COSTO_PLATILLO)+$detallepedido->costo_cambio+$detallepedido->costo_guarnicion));
                                                }

                                                else if(strlen((($detallepedido->CANTIDAD_SOLICITADA * $platillo->COSTO_PLATILLO)+$detallepedido->costo_cambio+$detallepedido->costo_guarnicion))==1){
                                                    $impresora->text("                  Q. ".$platillo->COSTO_PLATILLO."     Q. ".(($detallepedido->CANTIDAD_SOLICITADA * $platillo->COSTO_PLATILLO)+$detallepedido->costo_cambio+$detallepedido->costo_guarnicion));
                                                }
                                                else if(strlen((($detallepedido->CANTIDAD_SOLICITADA * $platillo->COSTO_PLATILLO)+$detallepedido->costo_cambio+$detallepedido->costo_guarnicion))==3){
                                                    if(strlen($platillo->COSTO_PLATILLO)==3){
                                                        $impresora->text("                  Q. ".$platillo->COSTO_PLATILLO."   Q. ".(($detallepedido->CANTIDAD_SOLICITADA * $platillo->COSTO_PLATILLO)+$detallepedido->costo_cambio+$detallepedido->costo_guarnicion));
                                                
                                                    }
                                                    else{
                                                        $impresora->text("                  Q. ".$platillo->COSTO_PLATILLO."    Q. ".(($detallepedido->CANTIDAD_SOLICITADA * $platillo->COSTO_PLATILLO)+$detallepedido->costo_cambio+$detallepedido->costo_guarnicion));
                                                
                                                    }
                                                 }
                                                
                                                else{
                                                    $impresora->text("                  Q. ".$platillo->COSTO_PLATILLO."  Q. ".(($detallepedido->CANTIDAD_SOLICITADA * $platillo->COSTO_PLATILLO)+$detallepedido->costo_cambio+$detallepedido->costo_guarnicion));
                                                }
                
                                                
                                                
                                            }
                                            elseif($var1==6){
                                                if(strlen((($detallepedido->CANTIDAD_SOLICITADA * $platillo->COSTO_PLATILLO)+$detallepedido->costo_cambio+$detallepedido->costo_guarnicion))==2){
                                                     $impresora->text("                 Q. ".$platillo->COSTO_PLATILLO."    Q. ".(($detallepedido->CANTIDAD_SOLICITADA * $platillo->COSTO_PLATILLO)+$detallepedido->costo_cambio+$detallepedido->costo_guarnicion));                      
                
                                                }
                                                else if(strlen((($detallepedido->CANTIDAD_SOLICITADA * $platillo->COSTO_PLATILLO)+$detallepedido->costo_cambio+$detallepedido->costo_guarnicion))==1){
                                                    $impresora->text("                 Q. ".$platillo->COSTO_PLATILLO."     Q. ".(($detallepedido->CANTIDAD_SOLICITADA * $platillo->COSTO_PLATILLO)+$detallepedido->costo_cambio+$detallepedido->costo_guarnicion));
                                                }
                                                else if(strlen((($detallepedido->CANTIDAD_SOLICITADA * $platillo->COSTO_PLATILLO)+$detallepedido->costo_cambio+$detallepedido->costo_guarnicion))==3){
                                                    if(strlen($platillo->COSTO_PLATILLO)==3){
                                                        $impresora->text("                 Q. ".$platillo->COSTO_PLATILLO."   Q. ".(($detallepedido->CANTIDAD_SOLICITADA * $platillo->COSTO_PLATILLO)+$detallepedido->costo_cambio+$detallepedido->costo_guarnicion));                      
                
                                                    }
                                                    else{
                                                        $impresora->text("                 Q. ".$platillo->COSTO_PLATILLO."    Q. ".(($detallepedido->CANTIDAD_SOLICITADA * $platillo->COSTO_PLATILLO)+$detallepedido->costo_cambio+$detallepedido->costo_guarnicion));                      
                
                                                    }
                                                    
                                                }
                                                
                                                else{
                                                     $impresora->text("                 Q. ".$platillo->COSTO_PLATILLO."    Q. ".(($detallepedido->CANTIDAD_SOLICITADA * $platillo->COSTO_PLATILLO)+$detallepedido->costo_cambio+$detallepedido->costo_guarnicion));                      
                
                                                }
                                                
                                               
                                            }
                                            elseif($var1==7){
                                                if(strlen((($detallepedido->CANTIDAD_SOLICITADA * $platillo->COSTO_PLATILLO)+$detallepedido->costo_cambio+$detallepedido->costo_guarnicion))==2){
                                                    $impresora->text("                Q. ".$platillo->COSTO_PLATILLO."    Q. ".(($detallepedido->CANTIDAD_SOLICITADA * $platillo->COSTO_PLATILLO)+$detallepedido->costo_cambio+$detallepedido->costo_guarnicion));                      
                
                                               }
                                               else if(strlen((($detallepedido->CANTIDAD_SOLICITADA * $platillo->COSTO_PLATILLO)+$detallepedido->costo_cambio+$detallepedido->costo_guarnicion))==1){
                                                $impresora->text("                Q. ".$platillo->COSTO_PLATILLO."     Q. ".(($detallepedido->CANTIDAD_SOLICITADA * $platillo->COSTO_PLATILLO)+$detallepedido->costo_cambio+$detallepedido->costo_guarnicion));
                                            }
                                               else if(strlen((($detallepedido->CANTIDAD_SOLICITADA * $platillo->COSTO_PLATILLO)+$detallepedido->costo_cambio+$detallepedido->costo_guarnicion))==3){
                                                if(strlen($platillo->COSTO_PLATILLO)==3){
                                                    $impresora->text("                Q. ".$platillo->COSTO_PLATILLO."   Q. ".(($detallepedido->CANTIDAD_SOLICITADA * $platillo->COSTO_PLATILLO)+$detallepedido->costo_cambio+$detallepedido->costo_guarnicion));                      
                
                                                }
                                                else{
                                                    $impresora->text("                Q. ".$platillo->COSTO_PLATILLO."    Q. ".(($detallepedido->CANTIDAD_SOLICITADA * $platillo->COSTO_PLATILLO)+$detallepedido->costo_cambio+$detallepedido->costo_guarnicion));                      
                
                                                }
                                                  
                                               }
                                               
                                               else{
                                                    $impresora->text("                Q. ".$platillo->COSTO_PLATILLO."    Q. ".(($detallepedido->CANTIDAD_SOLICITADA * $platillo->COSTO_PLATILLO)+$detallepedido->costo_cambio+$detallepedido->costo_guarnicion));                      
                
                                               }
                                               
                
                                            }
                                            elseif($var1==8){
                                                if(strlen((($detallepedido->CANTIDAD_SOLICITADA * $platillo->COSTO_PLATILLO)+$detallepedido->costo_cambio+$detallepedido->costo_guarnicion))==2){
                                                    $impresora->text("               Q. ".$platillo->COSTO_PLATILLO."    Q. ".(($detallepedido->CANTIDAD_SOLICITADA * $platillo->COSTO_PLATILLO)+$detallepedido->costo_cambio+$detallepedido->costo_guarnicion));                      
                
                                               }
                                               else if(strlen((($detallepedido->CANTIDAD_SOLICITADA * $platillo->COSTO_PLATILLO)+$detallepedido->costo_cambio+$detallepedido->costo_guarnicion))==1){
                                                $impresora->text("               Q. ".$platillo->COSTO_PLATILLO."     Q. ".(($detallepedido->CANTIDAD_SOLICITADA * $platillo->COSTO_PLATILLO)+$detallepedido->costo_cambio+$detallepedido->costo_guarnicion));
                                            }
                                               else if(strlen((($detallepedido->CANTIDAD_SOLICITADA * $platillo->COSTO_PLATILLO)+$detallepedido->costo_cambio+$detallepedido->costo_guarnicion))==3){
                                                if(strlen($platillo->COSTO_PLATILLO)==3){
                                                    $impresora->text("               Q. ".$platillo->COSTO_PLATILLO."   Q. ".(($detallepedido->CANTIDAD_SOLICITADA * $platillo->COSTO_PLATILLO)+$detallepedido->costo_cambio+$detallepedido->costo_guarnicion));                      
                
                                                }
                                                else{
                                                    $impresora->text("               Q. ".$platillo->COSTO_PLATILLO."    Q. ".(($detallepedido->CANTIDAD_SOLICITADA * $platillo->COSTO_PLATILLO)+$detallepedido->costo_cambio+$detallepedido->costo_guarnicion));                      
                
                                                }
                                                  
                                               }
                                               
                                               else{
                                                    $impresora->text("               Q. ".$platillo->COSTO_PLATILLO."    Q. ".(($detallepedido->CANTIDAD_SOLICITADA * $platillo->COSTO_PLATILLO)+$detallepedido->costo_cambio+$detallepedido->costo_guarnicion));                      
                
                                               }
                
                                            }
                                            elseif($var1==9){
                                                if(strlen((($detallepedido->CANTIDAD_SOLICITADA * $platillo->COSTO_PLATILLO)+$detallepedido->costo_cambio+$detallepedido->costo_guarnicion))==2){
                                                    $impresora->text("              Q. ".$platillo->COSTO_PLATILLO."    Q. ".(($detallepedido->CANTIDAD_SOLICITADA * $platillo->COSTO_PLATILLO)+$detallepedido->costo_cambio+$detallepedido->costo_guarnicion));
                                                }
                                                else if(strlen((($detallepedido->CANTIDAD_SOLICITADA * $platillo->COSTO_PLATILLO)+$detallepedido->costo_cambio+$detallepedido->costo_guarnicion))==1){
                                                    $impresora->text("              Q. ".$platillo->COSTO_PLATILLO."     Q. ".(($detallepedido->CANTIDAD_SOLICITADA * $platillo->COSTO_PLATILLO)+$detallepedido->costo_cambio+$detallepedido->costo_guarnicion));
                                                }
                        
                                                else if(strlen((($detallepedido->CANTIDAD_SOLICITADA * $platillo->COSTO_PLATILLO)+$detallepedido->costo_cambio+$detallepedido->costo_guarnicion))==3){
                                                    if(strlen($platillo->COSTO_PLATILLO)==3){
                                                        $impresora->text("              Q. ".$platillo->COSTO_PLATILLO."   Q. ".(($detallepedido->CANTIDAD_SOLICITADA * $platillo->COSTO_PLATILLO)+$detallepedido->costo_cambio+$detallepedido->costo_guarnicion));                      
                
                                                    }
                                                    else{
                                                        $impresora->text("              Q. ".$platillo->COSTO_PLATILLO."    Q. ".(($detallepedido->CANTIDAD_SOLICITADA * $platillo->COSTO_PLATILLO)+$detallepedido->costo_cambio+$detallepedido->costo_guarnicion));                      
                
                                                    }
                                              
                                                }
                                                
                                                else{
                                                    $impresora->text("                Q. ".$platillo->COSTO_PLATILLO."  Q. ".(($detallepedido->CANTIDAD_SOLICITADA * $platillo->COSTO_PLATILLO)+$detallepedido->costo_cambio+$detallepedido->costo_guarnicion));                      
                                                }
                
                
                                              //  $impresora->text("              Q. ".$platillo->COSTO_PLATILLO."    Q. ".(($detallepedido->CANTIDAD_SOLICITADA * $platillo->COSTO_PLATILLO)+$detallepedido->costo_cambio+$detallepedido->costo_guarnicion));                      
                
                                            }
                                            elseif($var1==10){
                                                if(strlen((($detallepedido->CANTIDAD_SOLICITADA * $platillo->COSTO_PLATILLO)+$detallepedido->costo_cambio+$detallepedido->costo_guarnicion))==2){
                                                    $impresora->text("             Q. ".$platillo->COSTO_PLATILLO."    Q. ".(($detallepedido->CANTIDAD_SOLICITADA * $platillo->COSTO_PLATILLO)+$detallepedido->costo_cambio+$detallepedido->costo_guarnicion));                      
                                                }
                                                else if(strlen((($detallepedido->CANTIDAD_SOLICITADA * $platillo->COSTO_PLATILLO)+$detallepedido->costo_cambio+$detallepedido->costo_guarnicion))==1){
                                                    $impresora->text("             Q. ".$platillo->COSTO_PLATILLO."     Q. ".(($detallepedido->CANTIDAD_SOLICITADA * $platillo->COSTO_PLATILLO)+$detallepedido->costo_cambio+$detallepedido->costo_guarnicion));
                                                }
                                                else if(strlen((($detallepedido->CANTIDAD_SOLICITADA * $platillo->COSTO_PLATILLO)+$detallepedido->costo_cambio+$detallepedido->costo_guarnicion))==3){
                                                    if(strlen($platillo->COSTO_PLATILLO)==3){
                                                        $impresora->text("             Q. ".$platillo->COSTO_PLATILLO."   Q. ".(($detallepedido->CANTIDAD_SOLICITADA * $platillo->COSTO_PLATILLO)+$detallepedido->costo_cambio+$detallepedido->costo_guarnicion));                      
                                               
                                                    }
                                                    else{
                                                        $impresora->text("             Q. ".$platillo->COSTO_PLATILLO."    Q. ".(($detallepedido->CANTIDAD_SOLICITADA * $platillo->COSTO_PLATILLO)+$detallepedido->costo_cambio+$detallepedido->costo_guarnicion));                      
                                               
                                                    }
                                                 }
                                                
                                                else{
                                                    $impresora->text("             Q. ".$platillo->COSTO_PLATILLO."  Q. ".(($detallepedido->CANTIDAD_SOLICITADA * $platillo->COSTO_PLATILLO)+$detallepedido->costo_cambio+$detallepedido->costo_guarnicion));                      
                                                }
                
                                            }
                                            elseif($var1==11){
                                                if(strlen((($detallepedido->CANTIDAD_SOLICITADA * $platillo->COSTO_PLATILLO)+$detallepedido->costo_cambio+$detallepedido->costo_guarnicion))==2){
                                                    $impresora->text("            Q. ".$platillo->COSTO_PLATILLO."    Q. ".(($detallepedido->CANTIDAD_SOLICITADA * $platillo->COSTO_PLATILLO)+$detallepedido->costo_cambio+$detallepedido->costo_guarnicion));                      
                
                                               }
                                               else if(strlen((($detallepedido->CANTIDAD_SOLICITADA * $platillo->COSTO_PLATILLO)+$detallepedido->costo_cambio+$detallepedido->costo_guarnicion))==1){
                                                $impresora->text("            Q. ".$platillo->COSTO_PLATILLO."     Q. ".(($detallepedido->CANTIDAD_SOLICITADA * $platillo->COSTO_PLATILLO)+$detallepedido->costo_cambio+$detallepedido->costo_guarnicion));
                                            }
                                               else if(strlen((($detallepedido->CANTIDAD_SOLICITADA * $platillo->COSTO_PLATILLO)+$detallepedido->costo_cambio+$detallepedido->costo_guarnicion))==3){
                                                if(strlen($platillo->COSTO_PLATILLO)==3){
                                                    $impresora->text("            Q. ".$platillo->COSTO_PLATILLO."   Q. ".(($detallepedido->CANTIDAD_SOLICITADA * $platillo->COSTO_PLATILLO)+$detallepedido->costo_cambio+$detallepedido->costo_guarnicion));                      
                
                                                }
                                                else{
                                                    $impresora->text("            Q. ".$platillo->COSTO_PLATILLO."    Q. ".(($detallepedido->CANTIDAD_SOLICITADA * $platillo->COSTO_PLATILLO)+$detallepedido->costo_cambio+$detallepedido->costo_guarnicion));                      
                
                                                }
                                                 
                                               }
                                               
                                               else{
                                                    $impresora->text("            Q. ".$platillo->COSTO_PLATILLO."    Q. ".(($detallepedido->CANTIDAD_SOLICITADA * $platillo->COSTO_PLATILLO)+$detallepedido->costo_cambio+$detallepedido->costo_guarnicion));                      
                
                                               }
                                            
                                            }
                                            elseif($var1==12){
                                                if(strlen((($detallepedido->CANTIDAD_SOLICITADA * $platillo->COSTO_PLATILLO)+$detallepedido->costo_cambio+$detallepedido->costo_guarnicion))==2){
                                                    $impresora->text("           Q. ".$platillo->COSTO_PLATILLO."    Q. ".(($detallepedido->CANTIDAD_SOLICITADA * $platillo->COSTO_PLATILLO)+$detallepedido->costo_cambio+$detallepedido->costo_guarnicion));                      
                                                   }
                                                   else if(strlen((($detallepedido->CANTIDAD_SOLICITADA * $platillo->COSTO_PLATILLO)+$detallepedido->costo_cambio+$detallepedido->costo_guarnicion))==1){
                                                    $impresora->text("           Q. ".$platillo->COSTO_PLATILLO."     Q. ".(($detallepedido->CANTIDAD_SOLICITADA * $platillo->COSTO_PLATILLO)+$detallepedido->costo_cambio+$detallepedido->costo_guarnicion));
                                                }
                                                else if(strlen((($detallepedido->CANTIDAD_SOLICITADA * $platillo->COSTO_PLATILLO)+$detallepedido->costo_cambio+$detallepedido->costo_guarnicion))==3){
                                                    if(strlen($platillo->COSTO_PLATILLO)==3){
                                                        $impresora->text("           Q. ".$platillo->COSTO_PLATILLO."   Q. ".(($detallepedido->CANTIDAD_SOLICITADA * $platillo->COSTO_PLATILLO)+$detallepedido->costo_cambio+$detallepedido->costo_guarnicion));                      
                
                                                    }
                                                    else{
                                                        $impresora->text("           Q. ".$platillo->COSTO_PLATILLO."    Q. ".(($detallepedido->CANTIDAD_SOLICITADA * $platillo->COSTO_PLATILLO)+$detallepedido->costo_cambio+$detallepedido->costo_guarnicion));                      
                
                                                    }
                                                 
                                                }
                                                
                                                else{
                                                    $impresora->text("           Q. ".$platillo->COSTO_PLATILLO."    Q. ".(($detallepedido->CANTIDAD_SOLICITADA * $platillo->COSTO_PLATILLO)+$detallepedido->costo_cambio+$detallepedido->costo_guarnicion));                      
                                                  }
                
                
                                          
                                            }
                                            elseif($var1==13){
                                                if(strlen((($detallepedido->CANTIDAD_SOLICITADA * $platillo->COSTO_PLATILLO)+$detallepedido->costo_cambio+$detallepedido->costo_guarnicion))==2){
                                                    $impresora->text("          Q. ".$platillo->COSTO_PLATILLO."    Q. ".(($detallepedido->CANTIDAD_SOLICITADA * $platillo->COSTO_PLATILLO)+$detallepedido->costo_cambio+$detallepedido->costo_guarnicion));                      
                                                }
                                                else if(strlen((($detallepedido->CANTIDAD_SOLICITADA * $platillo->COSTO_PLATILLO)+$detallepedido->costo_cambio+$detallepedido->costo_guarnicion))==1){
                                                    $impresora->text("          Q. ".$platillo->COSTO_PLATILLO."     Q. ".(($detallepedido->CANTIDAD_SOLICITADA * $platillo->COSTO_PLATILLO)+$detallepedido->costo_cambio+$detallepedido->costo_guarnicion));
                                                }
                                                else if(strlen((($detallepedido->CANTIDAD_SOLICITADA * $platillo->COSTO_PLATILLO)+$detallepedido->costo_cambio+$detallepedido->costo_guarnicion))==3){
                                                    if(strlen($platillo->COSTO_PLATILLO)==3){
                                                        $impresora->text("          Q. ".$platillo->COSTO_PLATILLO."   Q. ".(($detallepedido->CANTIDAD_SOLICITADA * $platillo->COSTO_PLATILLO)+$detallepedido->costo_cambio+$detallepedido->costo_guarnicion));                      
                                               
                                                    }
                                                    else{
                                                        $impresora->text("          Q. ".$platillo->COSTO_PLATILLO."    Q. ".(($detallepedido->CANTIDAD_SOLICITADA * $platillo->COSTO_PLATILLO)+$detallepedido->costo_cambio+$detallepedido->costo_guarnicion));                      
                                               
                                                    }
                                                 }
                                                
                                                else{
                                                    $impresora->text("          Q. ".$platillo->COSTO_PLATILLO."  Q. ".(($detallepedido->CANTIDAD_SOLICITADA * $platillo->COSTO_PLATILLO)+$detallepedido->costo_cambio+$detallepedido->costo_guarnicion));                      
                                                }
                
                
                                            }
                                            elseif($var1==14){
                                                if(strlen((($detallepedido->CANTIDAD_SOLICITADA * $platillo->COSTO_PLATILLO)+$detallepedido->costo_cambio+$detallepedido->costo_guarnicion))==2){
                                                    $impresora->text("         Q. ".$platillo->COSTO_PLATILLO."    Q. ".(($detallepedido->CANTIDAD_SOLICITADA * $platillo->COSTO_PLATILLO)+$detallepedido->costo_cambio+$detallepedido->costo_guarnicion));                      
                                                }
                                                else if(strlen((($detallepedido->CANTIDAD_SOLICITADA * $platillo->COSTO_PLATILLO)+$detallepedido->costo_cambio+$detallepedido->costo_guarnicion))==1){
                                                    $impresora->text("         Q. ".$platillo->COSTO_PLATILLO."     Q. ".(($detallepedido->CANTIDAD_SOLICITADA * $platillo->COSTO_PLATILLO)+$detallepedido->costo_cambio+$detallepedido->costo_guarnicion));
                                                }
                                                else if(strlen((($detallepedido->CANTIDAD_SOLICITADA * $platillo->COSTO_PLATILLO)+$detallepedido->costo_cambio+$detallepedido->costo_guarnicion))==3){
                                                    if(strlen($platillo->COSTO_PLATILLO)==3){
                                                        $impresora->text("         Q. ".$platillo->COSTO_PLATILLO."   Q. ".(($detallepedido->CANTIDAD_SOLICITADA * $platillo->COSTO_PLATILLO)+$detallepedido->costo_cambio+$detallepedido->costo_guarnicion));                      
                                                
                                                    }
                                                    else{
                                                        $impresora->text("         Q. ".$platillo->COSTO_PLATILLO."    Q. ".(($detallepedido->CANTIDAD_SOLICITADA * $platillo->COSTO_PLATILLO)+$detallepedido->costo_cambio+$detallepedido->costo_guarnicion));                      
                                                
                                                    }
                                                 }
                                                
                                                else{
                                                    $impresora->text("         Q. ".$platillo->COSTO_PLATILLO."  Q. ".(($detallepedido->CANTIDAD_SOLICITADA * $platillo->COSTO_PLATILLO)+$detallepedido->costo_cambio+$detallepedido->costo_guarnicion));                      
                                                }
                
                                           //     $impresora->text("         Q. ".$platillo->COSTO_PLATILLO."    Q. ".(($detallepedido->CANTIDAD_SOLICITADA * $platillo->COSTO_PLATILLO)+$detallepedido->costo_cambio+$detallepedido->costo_guarnicion));                      
                
                                            }
                                            elseif($var1==15){
                                                if(strlen((($detallepedido->CANTIDAD_SOLICITADA * $platillo->COSTO_PLATILLO)+$detallepedido->costo_cambio+$detallepedido->costo_guarnicion))==2){
                                                    $impresora->text("        Q. ".$platillo->COSTO_PLATILLO."    Q. ".(($detallepedido->CANTIDAD_SOLICITADA * $platillo->COSTO_PLATILLO)+$detallepedido->costo_cambio+$detallepedido->costo_guarnicion));                      
                                                }
                                                else if(strlen((($detallepedido->CANTIDAD_SOLICITADA * $platillo->COSTO_PLATILLO)+$detallepedido->costo_cambio+$detallepedido->costo_guarnicion))==1){
                                                    $impresora->text("        Q. ".$platillo->COSTO_PLATILLO."     Q. ".(($detallepedido->CANTIDAD_SOLICITADA * $platillo->COSTO_PLATILLO)+$detallepedido->costo_cambio+$detallepedido->costo_guarnicion));
                                                }
                                                else if(strlen((($detallepedido->CANTIDAD_SOLICITADA * $platillo->COSTO_PLATILLO)+$detallepedido->costo_cambio+$detallepedido->costo_guarnicion))==3){
                                                    if(strlen($platillo->COSTO_PLATILLO)==3){
                                                        $impresora->text("        Q. ".$platillo->COSTO_PLATILLO."   Q. ".(($detallepedido->CANTIDAD_SOLICITADA * $platillo->COSTO_PLATILLO)+$detallepedido->costo_cambio+$detallepedido->costo_guarnicion));                      
                                              
                                                    }
                                                    else{
                                                        $impresora->text("        Q. ".$platillo->COSTO_PLATILLO."    Q. ".(($detallepedido->CANTIDAD_SOLICITADA * $platillo->COSTO_PLATILLO)+$detallepedido->costo_cambio+$detallepedido->costo_guarnicion));                      
                                              
                                                    }
                                                  }
                                                
                                                else{
                                                    $impresora->text("        Q. ".$platillo->COSTO_PLATILLO."  Q. ".(($detallepedido->CANTIDAD_SOLICITADA * $platillo->COSTO_PLATILLO)+$detallepedido->costo_cambio+$detallepedido->costo_guarnicion));                      
                                                }
                
                                           //     $impresora->text("        Q. ".$platillo->COSTO_PLATILLO."    Q. ".(($detallepedido->CANTIDAD_SOLICITADA * $platillo->COSTO_PLATILLO)+$detallepedido->costo_cambio+$detallepedido->costo_guarnicion));                      
                
                                            }
                                            elseif($var1==16){
                                                if(strlen((($detallepedido->CANTIDAD_SOLICITADA * $platillo->COSTO_PLATILLO)+$detallepedido->costo_cambio+$detallepedido->costo_guarnicion))==2){
                                                    $impresora->text("       Q. ".$platillo->COSTO_PLATILLO."    Q. ".(($detallepedido->CANTIDAD_SOLICITADA * $platillo->COSTO_PLATILLO)+$detallepedido->costo_cambio+$detallepedido->costo_guarnicion));                      
                                                }
                                                else if(strlen((($detallepedido->CANTIDAD_SOLICITADA * $platillo->COSTO_PLATILLO)+$detallepedido->costo_cambio+$detallepedido->costo_guarnicion))==1){
                                                    $impresora->text("       Q. ".$platillo->COSTO_PLATILLO."     Q. ".(($detallepedido->CANTIDAD_SOLICITADA * $platillo->COSTO_PLATILLO)+$detallepedido->costo_cambio+$detallepedido->costo_guarnicion));
                                                }
                                                else if(strlen((($detallepedido->CANTIDAD_SOLICITADA * $platillo->COSTO_PLATILLO)+$detallepedido->costo_cambio+$detallepedido->costo_guarnicion))==3){
                                                    if(strlen($platillo->COSTO_PLATILLO)==3){
                                                        $impresora->text("       Q. ".$platillo->COSTO_PLATILLO."   Q. ".(($detallepedido->CANTIDAD_SOLICITADA * $platillo->COSTO_PLATILLO)+$detallepedido->costo_cambio+$detallepedido->costo_guarnicion));                      
                                               
                                                    }
                                                    else{
                                                        $impresora->text("       Q. ".$platillo->COSTO_PLATILLO."    Q. ".(($detallepedido->CANTIDAD_SOLICITADA * $platillo->COSTO_PLATILLO)+$detallepedido->costo_cambio+$detallepedido->costo_guarnicion));                      
                                               
                                                    }
                                                 }
                                                
                                                else{
                                                    $impresora->text("       Q. ".$platillo->COSTO_PLATILLO."  Q. ".(($detallepedido->CANTIDAD_SOLICITADA * $platillo->COSTO_PLATILLO)+$detallepedido->costo_cambio+$detallepedido->costo_guarnicion));                      
                                                }
                                              //  $impresora->text("       Q. ".$platillo->COSTO_PLATILLO."    Q. ".(($detallepedido->CANTIDAD_SOLICITADA * $platillo->COSTO_PLATILLO)+$detallepedido->costo_cambio+$detallepedido->costo_guarnicion));                      
                
                                            }
                                            elseif($var1==17){
                                                if(strlen((($detallepedido->CANTIDAD_SOLICITADA * $platillo->COSTO_PLATILLO)+$detallepedido->costo_cambio+$detallepedido->costo_guarnicion))==2){
                                                    $impresora->text("      Q. ".$platillo->COSTO_PLATILLO."    Q. ".(($detallepedido->CANTIDAD_SOLICITADA * $platillo->COSTO_PLATILLO)+$detallepedido->costo_cambio+$detallepedido->costo_guarnicion));                      
                                                }
                                                else if(strlen((($detallepedido->CANTIDAD_SOLICITADA * $platillo->COSTO_PLATILLO)+$detallepedido->costo_cambio+$detallepedido->costo_guarnicion))==1){
                                                    $impresora->text("      Q. ".$platillo->COSTO_PLATILLO."     Q. ".(($detallepedido->CANTIDAD_SOLICITADA * $platillo->COSTO_PLATILLO)+$detallepedido->costo_cambio+$detallepedido->costo_guarnicion));
                                                }
                                                else if(strlen((($detallepedido->CANTIDAD_SOLICITADA * $platillo->COSTO_PLATILLO)+$detallepedido->costo_cambio+$detallepedido->costo_guarnicion))==3){
                                                    if(strlen($platillo->COSTO_PLATILLO)==3){
                                                        $impresora->text("      Q. ".$platillo->COSTO_PLATILLO."   Q. ".(($detallepedido->CANTIDAD_SOLICITADA * $platillo->COSTO_PLATILLO)+$detallepedido->costo_cambio+$detallepedido->costo_guarnicion));                      
                                             
                                                    }
                                                    else{
                                                        $impresora->text("      Q. ".$platillo->COSTO_PLATILLO."    Q. ".(($detallepedido->CANTIDAD_SOLICITADA * $platillo->COSTO_PLATILLO)+$detallepedido->costo_cambio+$detallepedido->costo_guarnicion));                      
                                             
                                                    }
                                                  }
                                                
                                                else{
                                                    $impresora->text("      Q. ".$platillo->COSTO_PLATILLO."  Q. ".(($detallepedido->CANTIDAD_SOLICITADA * $platillo->COSTO_PLATILLO)+$detallepedido->costo_cambio+$detallepedido->costo_guarnicion));                      
                                                }
                                              //  $impresora->text("      Q. ".$platillo->COSTO_PLATILLO."    Q. ".(($detallepedido->CANTIDAD_SOLICITADA * $platillo->COSTO_PLATILLO)+$detallepedido->costo_cambio+$detallepedido->costo_guarnicion));                      
                
                                            }
                                            elseif($var1==18){
                                                if(strlen((($detallepedido->CANTIDAD_SOLICITADA * $platillo->COSTO_PLATILLO)+$detallepedido->costo_cambio+$detallepedido->costo_guarnicion))==2){
                                                    $impresora->text("     Q. ".$platillo->COSTO_PLATILLO."    Q. ".(($detallepedido->CANTIDAD_SOLICITADA * $platillo->COSTO_PLATILLO)+$detallepedido->costo_cambio+$detallepedido->costo_guarnicion));                      
                                                }
                                                else if(strlen((($detallepedido->CANTIDAD_SOLICITADA * $platillo->COSTO_PLATILLO)+$detallepedido->costo_cambio+$detallepedido->costo_guarnicion))==1){
                                                    $impresora->text("     Q. ".$platillo->COSTO_PLATILLO."     Q. ".(($detallepedido->CANTIDAD_SOLICITADA * $platillo->COSTO_PLATILLO)+$detallepedido->costo_cambio+$detallepedido->costo_guarnicion));
                                                }
                                                else if(strlen((($detallepedido->CANTIDAD_SOLICITADA * $platillo->COSTO_PLATILLO)+$detallepedido->costo_cambio+$detallepedido->costo_guarnicion))==3){
                                                    if(strlen($platillo->COSTO_PLATILLO)==3){
                                                        $impresora->text("     Q. ".$platillo->COSTO_PLATILLO."   Q. ".(($detallepedido->CANTIDAD_SOLICITADA * $platillo->COSTO_PLATILLO)+$detallepedido->costo_cambio+$detallepedido->costo_guarnicion));                      
                                               
                                                    }
                                                    else{
                                                        $impresora->text("     Q. ".$platillo->COSTO_PLATILLO."    Q. ".(($detallepedido->CANTIDAD_SOLICITADA * $platillo->COSTO_PLATILLO)+$detallepedido->costo_cambio+$detallepedido->costo_guarnicion));                      
                                               
                                                    }
                                                 }
                                                
                                                else{
                                                    $impresora->text("     Q. ".$platillo->COSTO_PLATILLO."  Q. ".(($detallepedido->CANTIDAD_SOLICITADA * $platillo->COSTO_PLATILLO)+$detallepedido->costo_cambio+$detallepedido->costo_guarnicion));                      
                                                }
                                              //  $impresora->text("     Q. ".$platillo->COSTO_PLATILLO."    Q. ".(($detallepedido->CANTIDAD_SOLICITADA * $platillo->COSTO_PLATILLO)+$detallepedido->costo_cambio+$detallepedido->costo_guarnicion));                      
                
                                            }
                                            elseif($var1==19){
                                                if(strlen((($detallepedido->CANTIDAD_SOLICITADA * $platillo->COSTO_PLATILLO)+$detallepedido->costo_cambio+$detallepedido->costo_guarnicion))==2){
                                                    $impresora->text("    Q. ".$platillo->COSTO_PLATILLO."    Q. ".(($detallepedido->CANTIDAD_SOLICITADA * $platillo->COSTO_PLATILLO)+$detallepedido->costo_cambio+$detallepedido->costo_guarnicion));                      
                                                }
                                                else if(strlen((($detallepedido->CANTIDAD_SOLICITADA * $platillo->COSTO_PLATILLO)+$detallepedido->costo_cambio+$detallepedido->costo_guarnicion))==1){
                                                    $impresora->text("    Q. ".$platillo->COSTO_PLATILLO."     Q. ".(($detallepedido->CANTIDAD_SOLICITADA * $platillo->COSTO_PLATILLO)+$detallepedido->costo_cambio+$detallepedido->costo_guarnicion));
                                                }
                                                else if(strlen((($detallepedido->CANTIDAD_SOLICITADA * $platillo->COSTO_PLATILLO)+$detallepedido->costo_cambio+$detallepedido->costo_guarnicion))==3){
                                                    if(strlen($platillo->COSTO_PLATILLO)==3){
                                                        $impresora->text("    Q. ".$platillo->COSTO_PLATILLO."   Q. ".(($detallepedido->CANTIDAD_SOLICITADA * $platillo->COSTO_PLATILLO)+$detallepedido->costo_cambio+$detallepedido->costo_guarnicion));                      
                                               
                                                    }
                                                    else{
                                                        $impresora->text("    Q. ".$platillo->COSTO_PLATILLO."    Q. ".(($detallepedido->CANTIDAD_SOLICITADA * $platillo->COSTO_PLATILLO)+$detallepedido->costo_cambio+$detallepedido->costo_guarnicion));                      
                                               
                                                    }
                                                 }
                                                
                                                else{
                                                    $impresora->text("    Q. ".$platillo->COSTO_PLATILLO."  Q. ".(($detallepedido->CANTIDAD_SOLICITADA * $platillo->COSTO_PLATILLO)+$detallepedido->costo_cambio+$detallepedido->costo_guarnicion));                      
                                                }
                                               // $impresora->text("    Q. ".$platillo->COSTO_PLATILLO."    Q. ".(($detallepedido->CANTIDAD_SOLICITADA * $platillo->COSTO_PLATILLO)+$detallepedido->costo_cambio+$detallepedido->costo_guarnicion));                      
                
                                            }
                                            elseif($var1==20){
                                                if(strlen((($detallepedido->CANTIDAD_SOLICITADA * $platillo->COSTO_PLATILLO)+$detallepedido->costo_cambio+$detallepedido->costo_guarnicion))==2){
                                                    $impresora->text("   Q. ".$platillo->COSTO_PLATILLO."    Q. ".(($detallepedido->CANTIDAD_SOLICITADA * $platillo->COSTO_PLATILLO)+$detallepedido->costo_cambio+$detallepedido->costo_guarnicion));                      
                                                }
                                                else if(strlen((($detallepedido->CANTIDAD_SOLICITADA * $platillo->COSTO_PLATILLO)+$detallepedido->costo_cambio+$detallepedido->costo_guarnicion))==1){
                                                    $impresora->text("   Q. ".$platillo->COSTO_PLATILLO."     Q. ".(($detallepedido->CANTIDAD_SOLICITADA * $platillo->COSTO_PLATILLO)+$detallepedido->costo_cambio+$detallepedido->costo_guarnicion));
                                                }
                                                else if(strlen((($detallepedido->CANTIDAD_SOLICITADA * $platillo->COSTO_PLATILLO)+$detallepedido->costo_cambio+$detallepedido->costo_guarnicion))==3){
                                                    if(strlen($platillo->COSTO_PLATILLO)==3){
                                                        $impresora->text("   Q. ".$platillo->COSTO_PLATILLO."   Q. ".(($detallepedido->CANTIDAD_SOLICITADA * $platillo->COSTO_PLATILLO)+$detallepedido->costo_cambio+$detallepedido->costo_guarnicion));                      
                                                
                                                    }
                                                    else{
                                                        $impresora->text("   Q. ".$platillo->COSTO_PLATILLO."    Q. ".(($detallepedido->CANTIDAD_SOLICITADA * $platillo->COSTO_PLATILLO)+$detallepedido->costo_cambio+$detallepedido->costo_guarnicion));                      
                                                
                                                    }
                                                }
                                                
                                                else{
                                                    $impresora->text("   Q. ".$platillo->COSTO_PLATILLO."  Q. ".(($detallepedido->CANTIDAD_SOLICITADA * $platillo->COSTO_PLATILLO)+$detallepedido->costo_cambio+$detallepedido->costo_guarnicion));                      
                                                }
                                              //  $impresora->text("   Q. ".$platillo->COSTO_PLATILLO."    Q. ".(($detallepedido->CANTIDAD_SOLICITADA * $platillo->COSTO_PLATILLO)+$detallepedido->costo_cambio+$detallepedido->costo_guarnicion));                      
                
                                            }
                                            elseif($var1==21){
                                                if(strlen((($detallepedido->CANTIDAD_SOLICITADA * $platillo->COSTO_PLATILLO)+$detallepedido->costo_cambio+$detallepedido->costo_guarnicion))==2){
                                                    $impresora->text("  Q. ".$platillo->COSTO_PLATILLO."    Q. ".(($detallepedido->CANTIDAD_SOLICITADA * $platillo->COSTO_PLATILLO)+$detallepedido->costo_cambio+$detallepedido->costo_guarnicion));                      
                                                }
                                                else if(strlen((($detallepedido->CANTIDAD_SOLICITADA * $platillo->COSTO_PLATILLO)+$detallepedido->costo_cambio+$detallepedido->costo_guarnicion))==1){
                                                    $impresora->text("  Q. ".$platillo->COSTO_PLATILLO."     Q. ".(($detallepedido->CANTIDAD_SOLICITADA * $platillo->COSTO_PLATILLO)+$detallepedido->costo_cambio+$detallepedido->costo_guarnicion));
                                                }
                                                else if(strlen((($detallepedido->CANTIDAD_SOLICITADA * $platillo->COSTO_PLATILLO)+$detallepedido->costo_cambio+$detallepedido->costo_guarnicion))==3){
                                                    if(strlen($platillo->COSTO_PLATILLO)==3){
                                                        $impresora->text("  Q. ".$platillo->COSTO_PLATILLO."   Q. ".(($detallepedido->CANTIDAD_SOLICITADA * $platillo->COSTO_PLATILLO)+$detallepedido->costo_cambio+$detallepedido->costo_guarnicion));                      
                                               
                                                    }
                                                    else{
                                                        $impresora->text("  Q. ".$platillo->COSTO_PLATILLO."    Q. ".(($detallepedido->CANTIDAD_SOLICITADA * $platillo->COSTO_PLATILLO)+$detallepedido->costo_cambio+$detallepedido->costo_guarnicion));                      
                                               
                                                    }
                                                 }
                                                
                                                else{
                                                    $impresora->text("  Q. ".$platillo->COSTO_PLATILLO."  Q. ".(($detallepedido->CANTIDAD_SOLICITADA * $platillo->COSTO_PLATILLO)+$detallepedido->costo_cambio+$detallepedido->costo_guarnicion));                      
                                                }
                                              //  $impresora->text("  Q. ".$platillo->COSTO_PLATILLO."    Q. ".(($detallepedido->CANTIDAD_SOLICITADA * $platillo->COSTO_PLATILLO)+$detallepedido->costo_cambio+$detallepedido->costo_guarnicion));                      
                
                                            }
                
                                         $impresora->text("\n");    
                                    }
                                       
                                }
                            }
                            foreach($this->bebidasc as $bebida){
                                
                                if( $detallepedido->ID_PLATILLO == $bebida->ID_BEBIDA and $detallepedido->extra==2){
                                    $this->subtotalp=$this->subtotalp + $detallepedido->SUB_TOTAL;
                                    $var1=strlen($bebida->TITUTLO_BEBIDA);
                                    if($var1>22 or $var1==22){
                                        $impresora->setJustification(Printer::JUSTIFY_LEFT);
                                        
                                        if(strlen($detallepedido->CANTIDAD_SOLICITADA)==1){
                                            $impresora->text($detallepedido->CANTIDAD_SOLICITADA."     ");
                                            $impresora->text($bebida->TITUTLO_BEBIDA." ".$detallepedido->OBSERVACION);
                                        }
                                        else if(strlen($detallepedido->CANTIDAD_SOLICITADA)==2){
                                            $impresora->text($detallepedido->CANTIDAD_SOLICITADA."    ");
                                            $impresora->text($bebida->TITUTLO_BEBIDA." ".$detallepedido->OBSERVACION);
                                        }else if(strlen($detallepedido->CANTIDAD_SOLICITADA)==3){
                                            $impresora->text($detallepedido->CANTIDAD_SOLICITADA."   ");
                                            $impresora->text($bebida->TITUTLO_BEBIDA." ".$detallepedido->OBSERVACION);
                                        }
                                        
                                        $impresora->text("\n");
                                        $impresora->setJustification(Printer::JUSTIFY_RIGHT);
                                        if(strlen(($detallepedido->CANTIDAD_SOLICITADA * $bebida->COSTO_BEBIDA))==2){
                                            $impresora->text("Q. ".$bebida->COSTO_BEBIDA."    Q. ".($detallepedido->CANTIDAD_SOLICITADA * $bebida->COSTO_BEBIDA)."     ");
                                            
                                        }
                
                                        else if(strlen(($detallepedido->CANTIDAD_SOLICITADA * $bebida->COSTO_BEBIDA))==3){
                                            $impresora->text("Q. ".$bebida->COSTO_BEBIDA);
                                            $impresora->setJustification(Printer::JUSTIFY_RIGHT);
                                            $impresora->text("   Q. ".($detallepedido->CANTIDAD_SOLICITADA * $bebida->COSTO_BEBIDA)."    ");
                                         }
                                         else
                                         {
                                             $impresora->text("Q. ".$platillo->COSTO_PLATILLO);
                                             $impresora->setJustification(Printer::JUSTIFY_RIGHT);
                                             $impresora->text("     Q. ".($detallepedido->CANTIDAD_SOLICITADA * $bebida->COSTO_BEBIDA)."     ");
                                            // $impresora->text("     Q. ".(($detallepedido->CANTIDAD_SOLICITADA * $platillo->COSTO_PLATILLO)+$detallepedido->costo_cambio+$detallepedido->costo_guarnicion."     "));
                                          
                                          
                                         }
                                        $impresora->text("\n");
            
                                        }else{
            
                                            $impresora->setJustification(Printer::JUSTIFY_LEFT);
                                            if(strlen($detallepedido->CANTIDAD_SOLICITADA)==1){
                                                $impresora->text($detallepedido->CANTIDAD_SOLICITADA."     ");
                                                $impresora->text($bebida->TITUTLO_BEBIDA);
                                            }
                                            else if(strlen($detallepedido->CANTIDAD_SOLICITADA)==2){
                                                $impresora->text($detallepedido->CANTIDAD_SOLICITADA."    ");
                                                $impresora->text($bebida->TITUTLO_BEBIDA);
                                            }else if(strlen($detallepedido->CANTIDAD_SOLICITADA)==3){
                                                $impresora->text($detallepedido->CANTIDAD_SOLICITADA."   ");
                                                $impresora->text($bebida->TITUTLO_BEBIDA);
                                            }
                
                                            $impresora->setJustification(Printer::JUSTIFY_RIGHT);
                                            if($var1==2){
                                                if(strlen($detallepedido->CANTIDAD_SOLICITADA * $bebida->COSTO_BEBIDA)==2){
            
                                                    $impresora->text("                     Q. ".$bebida->COSTO_BEBIDA."    Q. ".($detallepedido->CANTIDAD_SOLICITADA * $bebida->COSTO_BEBIDA));
                                                }
                                                else if(strlen($detallepedido->CANTIDAD_SOLICITADA * $bebida->COSTO_BEBIDA)==1){
                                                    $impresora->text("                     Q. ".$bebida->COSTO_BEBIDA."     Q. ".($detallepedido->CANTIDAD_SOLICITADA * $bebida->COSTO_BEBIDA));
                                                 }
                                                else if(strlen($detallepedido->CANTIDAD_SOLICITADA * $bebida->COSTO_BEBIDA)==3){
                                                    if(strlen($platillo->COSTO_PLATILLO)==3){
                                                        $impresora->text("                     Q. ".$bebida->COSTO_BEBIDA."  Q. ".($detallepedido->CANTIDAD_SOLICITADA * $bebida->COSTO_BEBIDA));
                                                
                                                    }
                                                    else{
                                                        $impresora->text("                     Q. ".$bebida->COSTO_BEBIDA."   Q. ".($detallepedido->CANTIDAD_SOLICITADA * $bebida->COSTO_BEBIDA));
                                                
                                                    }
                                                 }
                                                
                                                else{
                                                    $impresora->text("                     Q. ".$bebida->COSTO_BEBIDA."  Q. ".($detallepedido->CANTIDAD_SOLICITADA * $bebida->COSTO_BEBIDA));
                                                }
                
                                                
                                                
                                            }

                                            if($var1==3){
                                                if(strlen($detallepedido->CANTIDAD_SOLICITADA * $bebida->COSTO_BEBIDA)==2){
            
                                                    $impresora->text("                    Q. ".$bebida->COSTO_BEBIDA."    Q. ".($detallepedido->CANTIDAD_SOLICITADA * $bebida->COSTO_BEBIDA));
                                                }
                                                else if(strlen($detallepedido->CANTIDAD_SOLICITADA * $bebida->COSTO_BEBIDA)==1){
                                                    $impresora->text("                    Q. ".$bebida->COSTO_BEBIDA."     Q. ".($detallepedido->CANTIDAD_SOLICITADA * $bebida->COSTO_BEBIDA));
                                                 }
                                                else if(strlen($detallepedido->CANTIDAD_SOLICITADA * $bebida->COSTO_BEBIDA)==3){
                                                    if(strlen($platillo->COSTO_PLATILLO)==3){
                                                        $impresora->text("                    Q. ".$bebida->COSTO_BEBIDA."  Q. ".($detallepedido->CANTIDAD_SOLICITADA * $bebida->COSTO_BEBIDA));
                                                
                                                    }
                                                    else{
                                                        $impresora->text("                    Q. ".$bebida->COSTO_BEBIDA."   Q. ".($detallepedido->CANTIDAD_SOLICITADA * $bebida->COSTO_BEBIDA));
                                                
                                                    }
                                                 }
                                                
                                                else{
                                                    $impresora->text("                    Q. ".$bebida->COSTO_BEBIDA."  Q. ".($detallepedido->CANTIDAD_SOLICITADA * $bebida->COSTO_BEBIDA));
                                                }
                
                                                
                                                
                                            }

                                            if($var1==4){
                                                if(strlen($detallepedido->CANTIDAD_SOLICITADA * $bebida->COSTO_BEBIDA)==2){
            
                                                    $impresora->text("                    Q. ".$bebida->COSTO_BEBIDA."    Q. ".($detallepedido->CANTIDAD_SOLICITADA * $bebida->COSTO_BEBIDA));
                                                }
                                                else if(strlen($detallepedido->CANTIDAD_SOLICITADA * $bebida->COSTO_BEBIDA)==1){
                                                    $impresora->text("                    Q. ".$bebida->COSTO_BEBIDA."     Q. ".($detallepedido->CANTIDAD_SOLICITADA * $bebida->COSTO_BEBIDA));
                                                 }
                                                else if(strlen($detallepedido->CANTIDAD_SOLICITADA * $bebida->COSTO_BEBIDA)==3){
                                                    if(strlen($platillo->COSTO_PLATILLO)==3){
                                                        $impresora->text("                    Q. ".$bebida->COSTO_BEBIDA."  Q. ".($detallepedido->CANTIDAD_SOLICITADA * $bebida->COSTO_BEBIDA));
                                                
                                                    }
                                                    else{
                                                        $impresora->text("                    Q. ".$bebida->COSTO_BEBIDA."   Q. ".($detallepedido->CANTIDAD_SOLICITADA * $bebida->COSTO_BEBIDA));
                                                
                                                    }
                                                 }
                                                
                                                else{
                                                    $impresora->text("                    Q. ".$bebida->COSTO_BEBIDA."  Q. ".($detallepedido->CANTIDAD_SOLICITADA * $bebida->COSTO_BEBIDA));
                                                }
                
                                                
                                                
                                            }

                                            if($var1==5){
                                                if(strlen($detallepedido->CANTIDAD_SOLICITADA * $bebida->COSTO_BEBIDA)==2){
            
                                                    $impresora->text("                  Q. ".$bebida->COSTO_BEBIDA."    Q. ".($detallepedido->CANTIDAD_SOLICITADA * $bebida->COSTO_BEBIDA));
                                                }
                                                else if(strlen($detallepedido->CANTIDAD_SOLICITADA * $bebida->COSTO_BEBIDA)==1){
                                                    $impresora->text("                  Q. ".$bebida->COSTO_BEBIDA."     Q. ".($detallepedido->CANTIDAD_SOLICITADA * $bebida->COSTO_BEBIDA));
                                                 }
                                                else if(strlen($detallepedido->CANTIDAD_SOLICITADA * $bebida->COSTO_BEBIDA)==3){
                                                    if(strlen($platillo->COSTO_PLATILLO)==3){
                                                        $impresora->text("                  Q. ".$bebida->COSTO_BEBIDA."  Q. ".($detallepedido->CANTIDAD_SOLICITADA * $bebida->COSTO_BEBIDA));
                                                
                                                    }
                                                    else{
                                                        $impresora->text("                  Q. ".$bebida->COSTO_BEBIDA."   Q. ".($detallepedido->CANTIDAD_SOLICITADA * $bebida->COSTO_BEBIDA));
                                                
                                                    }
                                                 }
                                                
                                                else{
                                                    $impresora->text("                  Q. ".$bebida->COSTO_BEBIDA."  Q. ".($detallepedido->CANTIDAD_SOLICITADA * $bebida->COSTO_BEBIDA));
                                                }
                
                                                
                                                
                                            }
                                            elseif($var1==6){
                                                if(strlen($detallepedido->CANTIDAD_SOLICITADA * $bebida->COSTO_BEBIDA)==2){
                                                     $impresora->text("                 Q. ".$bebida->COSTO_BEBIDA."    Q. ".($detallepedido->CANTIDAD_SOLICITADA * $bebida->COSTO_BEBIDA));                      
                
                                                }
                                                else if(strlen($detallepedido->CANTIDAD_SOLICITADA * $bebida->COSTO_BEBIDA)==1){
                                                    $impresora->text("                 Q. ".$bebida->COSTO_BEBIDA."     Q. ".($detallepedido->CANTIDAD_SOLICITADA * $bebida->COSTO_BEBIDA));
                                                 }
                                                else if(strlen($detallepedido->CANTIDAD_SOLICITADA * $bebida->COSTO_BEBIDA)==3){
                                                    if(strlen($platillo->COSTO_PLATILLO)==3){
                                                        $impresora->text("                 Q. ".$bebida->COSTO_BEBIDA."   Q. ".($detallepedido->CANTIDAD_SOLICITADA * $bebida->COSTO_BEBIDA));                      
                
                                                    }
                                                    else{
                                                        $impresora->text("                 Q. ".$bebida->COSTO_BEBIDA."    Q. ".($detallepedido->CANTIDAD_SOLICITADA * $bebida->COSTO_BEBIDA));                      
                
                                                    }
                                                   
                                                }
                                                
                                                else{
                                                     $impresora->text("                 Q. ".$bebida->COSTO_BEBIDA."    Q. ".($detallepedido->CANTIDAD_SOLICITADA * $bebida->COSTO_BEBIDA));                      
                
                                                }
                                                
                                               
                                            }
                                            elseif($var1==7){
                                                if(strlen($detallepedido->CANTIDAD_SOLICITADA * $bebida->COSTO_BEBIDA)==2){
                                                    $impresora->text("                Q. ".$bebida->COSTO_BEBIDA."    Q. ".($detallepedido->CANTIDAD_SOLICITADA * $bebida->COSTO_BEBIDA));                      
                
                                               }
                                               else if(strlen($detallepedido->CANTIDAD_SOLICITADA * $bebida->COSTO_BEBIDA)==1){
                                                $impresora->text("                Q. ".$bebida->COSTO_BEBIDA."     Q. ".($detallepedido->CANTIDAD_SOLICITADA * $bebida->COSTO_BEBIDA));
                                             }
                                               else if(strlen($detallepedido->CANTIDAD_SOLICITADA * $bebida->COSTO_BEBIDA)==3){
                                                if(strlen($platillo->COSTO_PLATILLO)==3){
                                                    $impresora->text("                Q. ".$bebida->COSTO_BEBIDA."   Q. ".($detallepedido->CANTIDAD_SOLICITADA * $bebida->COSTO_BEBIDA));                      
                
                                                }
                                                else{
                                                    $impresora->text("                Q. ".$bebida->COSTO_BEBIDA."    Q. ".($detallepedido->CANTIDAD_SOLICITADA * $bebida->COSTO_BEBIDA));                      
                
                                                }
                                                  
                                               }
                                               
                                               else{
                                                    $impresora->text("                Q. ".$bebida->COSTO_BEBIDA."    Q. ".($detallepedido->CANTIDAD_SOLICITADA * $bebida->COSTO_BEBIDA));                      
                
                                               }
                                               
                
                                            }
                                            elseif($var1==8){
                                                if(strlen($detallepedido->CANTIDAD_SOLICITADA * $bebida->COSTO_BEBIDA)==2){
                                                    $impresora->text("               Q. ".$bebida->COSTO_BEBIDA."    Q. ".($detallepedido->CANTIDAD_SOLICITADA * $bebida->COSTO_BEBIDA));                      
                
                                               }
                                               else if(strlen($detallepedido->CANTIDAD_SOLICITADA * $bebida->COSTO_BEBIDA)==1){
                                                $impresora->text("               Q. ".$bebida->COSTO_BEBIDA."     Q. ".($detallepedido->CANTIDAD_SOLICITADA * $bebida->COSTO_BEBIDA));
                                             }
                                               else if(strlen($detallepedido->CANTIDAD_SOLICITADA * $bebida->COSTO_BEBIDA)==3){
                                                if(strlen($platillo->COSTO_PLATILLO)==3){
                                                    $impresora->text("               Q. ".$bebida->COSTO_BEBIDA."   Q. ".($detallepedido->CANTIDAD_SOLICITADA * $bebida->COSTO_BEBIDA));                      
                
                                                }
                                                else{
                                                    $impresora->text("               Q. ".$bebida->COSTO_BEBIDA."    Q. ".($detallepedido->CANTIDAD_SOLICITADA * $bebida->COSTO_BEBIDA));                      
                
                                                }
                                                  
                                               }
                                               
                                               else{
                                                    $impresora->text("               Q. ".$bebida->COSTO_BEBIDA."    Q. ".($detallepedido->CANTIDAD_SOLICITADA * $bebida->COSTO_BEBIDA));                      
                
                                               }
                
                                            }
                                            elseif($var1==9){
                                                if(strlen($detallepedido->CANTIDAD_SOLICITADA * $bebida->COSTO_BEBIDA)==2){
                                                    $impresora->text("              Q. ".$bebida->COSTO_BEBIDA."    Q. ".($detallepedido->CANTIDAD_SOLICITADA * $bebida->COSTO_BEBIDA));
                                                }
                                                else if(strlen($detallepedido->CANTIDAD_SOLICITADA * $bebida->COSTO_BEBIDA)==1){
                                                    $impresora->text("              Q. ".$bebida->COSTO_BEBIDA."     Q. ".($detallepedido->CANTIDAD_SOLICITADA * $bebida->COSTO_BEBIDA));
                                                 }
                        
                                                else if(strlen($detallepedido->CANTIDAD_SOLICITADA * $bebida->COSTO_BEBIDA)==3){
                                                    if(strlen($platillo->COSTO_PLATILLO)==3){
                                                        $impresora->text("              Q. ".$bebida->COSTO_BEBIDA."   Q. ".($detallepedido->CANTIDAD_SOLICITADA * $bebida->COSTO_BEBIDA));                      
                
                                                    }
                                                    else{
                                                        $impresora->text("              Q. ".$bebida->COSTO_BEBIDA."    Q. ".($detallepedido->CANTIDAD_SOLICITADA * $bebida->COSTO_BEBIDA));                      
                
                                                    }
                                                
                                                }
                                                
                                                else{
                                                    $impresora->text("              Q. ".$bebida->COSTO_BEBIDA."  Q. ".($detallepedido->CANTIDAD_SOLICITADA * $bebida->COSTO_BEBIDA));                      
                                                }
                
                
                                              //  $impresora->text("              Q. ".$bebida->COSTO_BEBIDA."    Q. ".($detallepedido->CANTIDAD_SOLICITADA * $bebida->COSTO_BEBIDA));                      
                
                                            }
                                            elseif($var1==10){
                                                if(strlen($detallepedido->CANTIDAD_SOLICITADA * $bebida->COSTO_BEBIDA)==2){
                                                    $impresora->text("             Q. ".$bebida->COSTO_BEBIDA."    Q. ".($detallepedido->CANTIDAD_SOLICITADA * $bebida->COSTO_BEBIDA));                      
                                                }
                                                else if(strlen($detallepedido->CANTIDAD_SOLICITADA * $bebida->COSTO_BEBIDA)==1){
                                                    $impresora->text("             Q. ".$bebida->COSTO_BEBIDA."     Q. ".($detallepedido->CANTIDAD_SOLICITADA * $bebida->COSTO_BEBIDA));
                                                 }
                                                else if(strlen($detallepedido->CANTIDAD_SOLICITADA * $bebida->COSTO_BEBIDA)==3){
                                                    if(strlen($platillo->COSTO_PLATILLO)==3){
                                                        $impresora->text("             Q. ".$bebida->COSTO_BEBIDA."   Q. ".($detallepedido->CANTIDAD_SOLICITADA * $bebida->COSTO_BEBIDA));                      
                                               
                                                    }
                                                    else{
                                                        $impresora->text("             Q. ".$bebida->COSTO_BEBIDA."   Q. ".($detallepedido->CANTIDAD_SOLICITADA * $bebida->COSTO_BEBIDA));                      
                                               
                                                    }
                                                  }
                                                
                                                else{
                                                    $impresora->text("             Q. ".$bebida->COSTO_BEBIDA."  Q. ".($detallepedido->CANTIDAD_SOLICITADA * $bebida->COSTO_BEBIDA));                      
                                                }
                
                                            }
                                            elseif($var1==11){
                                                if(strlen($detallepedido->CANTIDAD_SOLICITADA * $bebida->COSTO_BEBIDA)==2){
                                                    $impresora->text("            Q. ".$bebida->COSTO_BEBIDA."    Q. ".($detallepedido->CANTIDAD_SOLICITADA * $bebida->COSTO_BEBIDA));                      
                
                                               }
                                               else if(strlen($detallepedido->CANTIDAD_SOLICITADA * $bebida->COSTO_BEBIDA)==1){
                                                $impresora->text("            Q. ".$bebida->COSTO_BEBIDA."     Q. ".($detallepedido->CANTIDAD_SOLICITADA * $bebida->COSTO_BEBIDA));
                                             }
                                               else if(strlen($detallepedido->CANTIDAD_SOLICITADA * $bebida->COSTO_BEBIDA)==3){
                                                if(strlen($platillo->COSTO_PLATILLO)==3){
                                                    $impresora->text("            Q. ".$bebida->COSTO_BEBIDA."   Q. ".($detallepedido->CANTIDAD_SOLICITADA * $bebida->COSTO_BEBIDA));                      
                
                                                }
                                                else{
                                                    $impresora->text("            Q. ".$bebida->COSTO_BEBIDA."    Q. ".($detallepedido->CANTIDAD_SOLICITADA * $bebida->COSTO_BEBIDA));                      
                
                                                }
                                                   
                                               }
                                               
                                               else{
                                                    $impresora->text("            Q. ".$bebida->COSTO_BEBIDA."    Q. ".($detallepedido->CANTIDAD_SOLICITADA * $bebida->COSTO_BEBIDA));                      
                
                                               }
                                            
                                            }
                                            elseif($var1==12){
                                                if(strlen($detallepedido->CANTIDAD_SOLICITADA * $bebida->COSTO_BEBIDA)==2){
                                                    $impresora->text("           Q. ".$bebida->COSTO_BEBIDA."    Q. ".($detallepedido->CANTIDAD_SOLICITADA * $bebida->COSTO_BEBIDA));                      
                                                   }
                                                   else if(strlen($detallepedido->CANTIDAD_SOLICITADA * $bebida->COSTO_BEBIDA)==1){
                                                    $impresora->text("           Q. ".$bebida->COSTO_BEBIDA."     Q. ".($detallepedido->CANTIDAD_SOLICITADA * $bebida->COSTO_BEBIDA));
                                                 }
                        
                                                else if(strlen($detallepedido->CANTIDAD_SOLICITADA * $bebida->COSTO_BEBIDA)==3){
                                                    if(strlen($platillo->COSTO_PLATILLO)==3){
                                                        $impresora->text("           Q. ".$bebida->COSTO_BEBIDA."   Q. ".($detallepedido->CANTIDAD_SOLICITADA * $bebida->COSTO_BEBIDA));                      
                
                                                    }
                                                    else{
                                                        $impresora->text("           Q. ".$bebida->COSTO_BEBIDA."    Q. ".($detallepedido->CANTIDAD_SOLICITADA * $bebida->COSTO_BEBIDA));                      
                
                                                    }
                                                    
                                                }
                                                
                                                else{
                                                    $impresora->text("           Q. ".$bebida->COSTO_BEBIDA."    Q. ".($detallepedido->CANTIDAD_SOLICITADA * $bebida->COSTO_BEBIDA));                      
                                                  }
                
                
                                          
                                            }
                                            elseif($var1==13){
                                                if(strlen($detallepedido->CANTIDAD_SOLICITADA * $bebida->COSTO_BEBIDA)==2){
                                                    $impresora->text("          Q. ".$bebida->COSTO_BEBIDA."    Q. ".($detallepedido->CANTIDAD_SOLICITADA * $bebida->COSTO_BEBIDA));                      
                                                }
                                                else if(strlen($detallepedido->CANTIDAD_SOLICITADA * $bebida->COSTO_BEBIDA)==1){
                                                    $impresora->text("          Q. ".$bebida->COSTO_BEBIDA."     Q. ".($detallepedido->CANTIDAD_SOLICITADA * $bebida->COSTO_BEBIDA));
                                                 }
                        
                                                else if(strlen($detallepedido->CANTIDAD_SOLICITADA * $bebida->COSTO_BEBIDA)==3){
                                                    if(strlen($platillo->COSTO_PLATILLO)==3){
                                                        $impresora->text("          Q. ".$bebida->COSTO_BEBIDA."   Q. ".($detallepedido->CANTIDAD_SOLICITADA * $bebida->COSTO_BEBIDA));                      
                                               
                                                    }
                                                    else{
                                                        $impresora->text("          Q. ".$bebida->COSTO_BEBIDA."    Q. ".($detallepedido->CANTIDAD_SOLICITADA * $bebida->COSTO_BEBIDA));                      
                                               
                                                    }
                                                 }
                                                
                                                else{
                                                    $impresora->text("          Q. ".$bebida->COSTO_BEBIDA."  Q. ".($detallepedido->CANTIDAD_SOLICITADA * $bebida->COSTO_BEBIDA));                      
                                                }
                
                
                                            }
                                            elseif($var1==14){
                                                if(strlen($detallepedido->CANTIDAD_SOLICITADA * $bebida->COSTO_BEBIDA)==2){
                                                    $impresora->text("         Q. ".$bebida->COSTO_BEBIDA."    Q. ".($detallepedido->CANTIDAD_SOLICITADA * $bebida->COSTO_BEBIDA));                      
                                                }
                                                else if(strlen($detallepedido->CANTIDAD_SOLICITADA * $bebida->COSTO_BEBIDA)==1){
                                                    $impresora->text("         Q. ".$bebida->COSTO_BEBIDA."     Q. ".($detallepedido->CANTIDAD_SOLICITADA * $bebida->COSTO_BEBIDA));
                                                 }
                                                else if(strlen($detallepedido->CANTIDAD_SOLICITADA * $bebida->COSTO_BEBIDA)==3){
                                                    if(strlen($platillo->COSTO_PLATILLO)==3){
                                                        $impresora->text("         Q. ".$bebida->COSTO_BEBIDA."   Q. ".($detallepedido->CANTIDAD_SOLICITADA * $bebida->COSTO_BEBIDA));                      
                                             
                                                    }
                                                    else{
                                                        $impresora->text("         Q. ".$bebida->COSTO_BEBIDA."    Q. ".($detallepedido->CANTIDAD_SOLICITADA * $bebida->COSTO_BEBIDA));                      
                                             
                                                    }
                                                  }
                                                
                                                else{
                                                    $impresora->text("         Q. ".$bebida->COSTO_BEBIDA."  Q. ".($detallepedido->CANTIDAD_SOLICITADA * $bebida->COSTO_BEBIDA));                      
                                                }
                
                                           //     $impresora->text("         Q. ".$bebida->COSTO_BEBIDA."    Q. ".($detallepedido->CANTIDAD_SOLICITADA * $bebida->COSTO_BEBIDA));                      
                
                                            }
                                            elseif($var1==15){
                                                if(strlen($detallepedido->CANTIDAD_SOLICITADA * $bebida->COSTO_BEBIDA)==2){
                                                    $impresora->text("        Q. ".$bebida->COSTO_BEBIDA."    Q. ".($detallepedido->CANTIDAD_SOLICITADA * $bebida->COSTO_BEBIDA));                      
                                                }
                                                else if(strlen($detallepedido->CANTIDAD_SOLICITADA * $bebida->COSTO_BEBIDA)==1){
                                                    $impresora->text("        Q. ".$bebida->COSTO_BEBIDA."     Q. ".($detallepedido->CANTIDAD_SOLICITADA * $bebida->COSTO_BEBIDA));
                                                 }
                                                else if(strlen($detallepedido->CANTIDAD_SOLICITADA * $bebida->COSTO_BEBIDA)==3){
                                                    if(strlen($platillo->COSTO_PLATILLO)==3){
                                                        $impresora->text("        Q. ".$bebida->COSTO_BEBIDA."   Q. ".($detallepedido->CANTIDAD_SOLICITADA * $bebida->COSTO_BEBIDA));                      
                                               
                                                    }
                                                    else{
                                                        $impresora->text("        Q. ".$bebida->COSTO_BEBIDA."    Q. ".($detallepedido->CANTIDAD_SOLICITADA * $bebida->COSTO_BEBIDA));                      
                                               
                                                    }
                                                 }
                                                
                                                else{
                                                    $impresora->text("        Q. ".$bebida->COSTO_BEBIDA."  Q. ".($detallepedido->CANTIDAD_SOLICITADA * $bebida->COSTO_BEBIDA));                      
                                                }
                
                                           //     $impresora->text("        Q. ".$bebida->COSTO_BEBIDA."    Q. ".($detallepedido->CANTIDAD_SOLICITADA * $bebida->COSTO_BEBIDA));                      
                
                                            }
                                            elseif($var1==16){
                                                if(strlen($detallepedido->CANTIDAD_SOLICITADA * $bebida->COSTO_BEBIDA)==2){
                                                    $impresora->text("       Q. ".$bebida->COSTO_BEBIDA."    Q. ".($detallepedido->CANTIDAD_SOLICITADA * $bebida->COSTO_BEBIDA));                      
                                                }
                                                else if(strlen($detallepedido->CANTIDAD_SOLICITADA * $bebida->COSTO_BEBIDA)==1){
                                                    $impresora->text("       Q. ".$bebida->COSTO_BEBIDA."     Q. ".($detallepedido->CANTIDAD_SOLICITADA * $bebida->COSTO_BEBIDA));
                                                 }
                                                else if(strlen($detallepedido->CANTIDAD_SOLICITADA * $bebida->COSTO_BEBIDA)==3){
                                                    if(strlen($platillo->COSTO_PLATILLO)==3){
                                                        $impresora->text("       Q. ".$bebida->COSTO_BEBIDA."   Q. ".($detallepedido->CANTIDAD_SOLICITADA * $bebida->COSTO_BEBIDA));                      
                                               
                                                    }
                                                    else{
                                                        $impresora->text("       Q. ".$bebida->COSTO_BEBIDA."    Q. ".($detallepedido->CANTIDAD_SOLICITADA * $bebida->COSTO_BEBIDA));                      
                                               
                                                    }
                                                }
                                                
                                                else{
                                                    $impresora->text("       Q. ".$bebida->COSTO_BEBIDA."  Q. ".($detallepedido->CANTIDAD_SOLICITADA * $bebida->COSTO_BEBIDA));                      
                                                }
                                              //  $impresora->text("       Q. ".$bebida->COSTO_BEBIDA."    Q. ".($detallepedido->CANTIDAD_SOLICITADA * $bebida->COSTO_BEBIDA));                      
                
                                            }
                                            elseif($var1==17){
                                                if(strlen($detallepedido->CANTIDAD_SOLICITADA * $bebida->COSTO_BEBIDA)==2){
                                                    $impresora->text("      Q. ".$bebida->COSTO_BEBIDA."    Q. ".($detallepedido->CANTIDAD_SOLICITADA * $bebida->COSTO_BEBIDA));                      
                                                }
                                                else if(strlen($detallepedido->CANTIDAD_SOLICITADA * $bebida->COSTO_BEBIDA)==1){
                                                    $impresora->text("      Q. ".$bebida->COSTO_BEBIDA."     Q. ".($detallepedido->CANTIDAD_SOLICITADA * $bebida->COSTO_BEBIDA));
                                                 }
                                                else if(strlen($detallepedido->CANTIDAD_SOLICITADA * $bebida->COSTO_BEBIDA)==3){
                                                    if(strlen($platillo->COSTO_PLATILLO)==3){
                                                        $impresora->text("      Q. ".$bebida->COSTO_BEBIDA."   Q. ".($detallepedido->CANTIDAD_SOLICITADA * $bebida->COSTO_BEBIDA));                      
                                               
                                                    }
                                                    else{
                                                        $impresora->text("      Q. ".$bebida->COSTO_BEBIDA."    Q. ".($detallepedido->CANTIDAD_SOLICITADA * $bebida->COSTO_BEBIDA));                      
                                               
                                                    }
                                                 }
                                                
                                                else{
                                                    $impresora->text("      Q. ".$bebida->COSTO_BEBIDA."  Q. ".($detallepedido->CANTIDAD_SOLICITADA * $bebida->COSTO_BEBIDA));                      
                                                }
                                              //  $impresora->text("      Q. ".$bebida->COSTO_BEBIDA."    Q. ".($detallepedido->CANTIDAD_SOLICITADA * $bebida->COSTO_BEBIDA));                      
                
                                            }
                                            elseif($var1==18){
                                                if(strlen($detallepedido->CANTIDAD_SOLICITADA * $bebida->COSTO_BEBIDA)==2){
                                                    $impresora->text("     Q. ".$bebida->COSTO_BEBIDA."    Q. ".($detallepedido->CANTIDAD_SOLICITADA * $bebida->COSTO_BEBIDA));                      
                                                }
                                                else if(strlen($detallepedido->CANTIDAD_SOLICITADA * $bebida->COSTO_BEBIDA)==1){
                                                    $impresora->text("     Q. ".$bebida->COSTO_BEBIDA."     Q. ".($detallepedido->CANTIDAD_SOLICITADA * $bebida->COSTO_BEBIDA));
                                                 }
                                                else if(strlen($detallepedido->CANTIDAD_SOLICITADA * $bebida->COSTO_BEBIDA)==3){
                                                    if(strlen($platillo->COSTO_PLATILLO)==3){
                                                        $impresora->text("     Q. ".$bebida->COSTO_BEBIDA."   Q. ".($detallepedido->CANTIDAD_SOLICITADA * $bebida->COSTO_BEBIDA));                      
                                               
                                                    }
                                                    else{
                                                        $impresora->text("     Q. ".$bebida->COSTO_BEBIDA."    Q. ".($detallepedido->CANTIDAD_SOLICITADA * $bebida->COSTO_BEBIDA));                      
                                               
                                                    }
                                                   }
                                                
                                                else{
                                                    $impresora->text("     Q. ".$bebida->COSTO_BEBIDA."  Q. ".($detallepedido->CANTIDAD_SOLICITADA * $bebida->COSTO_BEBIDA));                      
                                                }
                                              //  $impresora->text("     Q. ".$bebida->COSTO_BEBIDA."    Q. ".($detallepedido->CANTIDAD_SOLICITADA * $bebida->COSTO_BEBIDA));                      
                
                                            }
                                            elseif($var1==19){
                                                if(strlen($detallepedido->CANTIDAD_SOLICITADA * $bebida->COSTO_BEBIDA)==2){
                                                    $impresora->text("    Q. ".$bebida->COSTO_BEBIDA."    Q. ".($detallepedido->CANTIDAD_SOLICITADA * $bebida->COSTO_BEBIDA));                      
                                                }
                                                else if(strlen($detallepedido->CANTIDAD_SOLICITADA * $bebida->COSTO_BEBIDA)==1){
                                                    $impresora->text("    Q. ".$bebida->COSTO_BEBIDA."     Q. ".($detallepedido->CANTIDAD_SOLICITADA * $bebida->COSTO_BEBIDA));
                                                 }
                                                else if(strlen($detallepedido->CANTIDAD_SOLICITADA * $bebida->COSTO_BEBIDA)==3){
                                                    if(strlen($platillo->COSTO_PLATILLO)==3){
                                                        $impresora->text("    Q. ".$bebida->COSTO_BEBIDA."   Q. ".($detallepedido->CANTIDAD_SOLICITADA * $bebida->COSTO_BEBIDA));                      
                                             
                                                    }
                                                    else{
                                                        $impresora->text("    Q. ".$bebida->COSTO_BEBIDA."    Q. ".($detallepedido->CANTIDAD_SOLICITADA * $bebida->COSTO_BEBIDA));                      
                                             
                                                    }
                                                }
                                                
                                                else{
                                                    $impresora->text("    Q. ".$bebida->COSTO_BEBIDA."  Q. ".($detallepedido->CANTIDAD_SOLICITADA * $bebida->COSTO_BEBIDA));                      
                                                }
                                               // $impresora->text("    Q. ".$bebida->COSTO_BEBIDA."    Q. ".($detallepedido->CANTIDAD_SOLICITADA * $bebida->COSTO_BEBIDA));                      
                
                                            }
                                            elseif($var1==20){
                                                if(strlen($detallepedido->CANTIDAD_SOLICITADA * $bebida->COSTO_BEBIDA)==2){
                                                    $impresora->text("   Q. ".$bebida->COSTO_BEBIDA."    Q. ".($detallepedido->CANTIDAD_SOLICITADA * $bebida->COSTO_BEBIDA));                      
                                                }
                                                else if(strlen($detallepedido->CANTIDAD_SOLICITADA * $bebida->COSTO_BEBIDA)==1){
                                                    $impresora->text("   Q. ".$bebida->COSTO_BEBIDA."     Q. ".($detallepedido->CANTIDAD_SOLICITADA * $bebida->COSTO_BEBIDA));
                                                 }
                                                else if(strlen($detallepedido->CANTIDAD_SOLICITADA * $bebida->COSTO_BEBIDA)==3){
                                                    if(strlen($platillo->COSTO_PLATILLO)==3){
                                                        $impresora->text("   Q. ".$bebida->COSTO_BEBIDA."   Q. ".($detallepedido->CANTIDAD_SOLICITADA * $bebida->COSTO_BEBIDA));                      
                                            
                                                    }
                                                    else{
                                                        $impresora->text("   Q. ".$bebida->COSTO_BEBIDA."    Q. ".($detallepedido->CANTIDAD_SOLICITADA * $bebida->COSTO_BEBIDA));                      
                                            
                                                    }
                                                  }
                                                
                                                else{
                                                    $impresora->text("   Q. ".$bebida->COSTO_BEBIDA."  Q. ".($detallepedido->CANTIDAD_SOLICITADA * $bebida->COSTO_BEBIDA));                      
                                                }
                                              //  $impresora->text("   Q. ".$bebida->COSTO_BEBIDA."    Q. ".($detallepedido->CANTIDAD_SOLICITADA * $bebida->COSTO_BEBIDA));                      
                
                                            }
                                            elseif($var1==21){
                                                if(strlen($detallepedido->CANTIDAD_SOLICITADA * $bebida->COSTO_BEBIDA)==2){
                                                    $impresora->text("  Q. ".$bebida->COSTO_BEBIDA."    Q. ".($detallepedido->CANTIDAD_SOLICITADA * $bebida->COSTO_BEBIDA));                      
                                                }
                                                else if(strlen($detallepedido->CANTIDAD_SOLICITADA * $bebida->COSTO_BEBIDA)==1){
                                                    $impresora->text("  Q. ".$bebida->COSTO_BEBIDA."     Q. ".($detallepedido->CANTIDAD_SOLICITADA * $bebida->COSTO_BEBIDA));
                                                 }
                                                else if(strlen($detallepedido->CANTIDAD_SOLICITADA * $bebida->COSTO_BEBIDA)==3){
                                                    if(strlen($platillo->COSTO_PLATILLO)==3){
                                                        $impresora->text("  Q. ".$bebida->COSTO_BEBIDA."   Q. ".($detallepedido->CANTIDAD_SOLICITADA * $bebida->COSTO_BEBIDA));                      
                                           
                                                    }
                                                    else{
                                                        $impresora->text("  Q. ".$bebida->COSTO_BEBIDA."    Q. ".($detallepedido->CANTIDAD_SOLICITADA * $bebida->COSTO_BEBIDA));                      
                                           
                                                    }
                                                     }
                                                
                                                else{
                                                    $impresora->text("  Q. ".$bebida->COSTO_BEBIDA."  Q. ".($detallepedido->CANTIDAD_SOLICITADA * $bebida->COSTO_BEBIDA));                      
                                                }
                                              //  $impresora->text("  Q. ".$bebida->COSTO_BEBIDA."    Q. ".($detallepedido->CANTIDAD_SOLICITADA * $bebida->COSTO_BEBIDA));                      
                
                                            }
                
                                         $impresora->text("\n");    
                                    }
            
                            //        $impresora->text($detallepedido->CANTIDAD_SOLICITADA."         ".$bebida->TITUTLO_BEBIDA."                Q. ".$bebida->COSTO_BEBIDA."    Q. ".($detallepedido->CANTIDAD_SOLICITADA * $bebida->COSTO_BEBIDA)."\n");
                                }
                            }
                        
                        }
                        
            }
      
            $this->sumacuenta=$this->subtotalp+$this->subtotalex;
            $impresora->setJustification(Printer::JUSTIFY_CENTER);
            $impresora->setTextSize(1, 1);
            $impresora->text("================================================\n");
            foreach($this->propinas as $propina){
                if($propina->monto_inicial<=$this->sumacuenta and $propina->monto_final>=$this->sumacuenta){
                    $this->valorpro=$propina->monto;
                }
            }

            $impresora->text("Sub-Total             Q. ".$this->subtotalp+$this->subtotalex.".00\n");
            if($this->valorpro==null or $this->valorpro==0){
                $this->valorpro=0;
            }
            if($this->op==4){
                $impresora->text("Propina (opcional)     Q. 0.00\n"); 
            }
            elseif($this->op==3 or $this->op==2){
                $impresora->text("Propina (opcional)     Q. 0.00\n"); 
            }
            else{
                $impresora->text("Propina (opcional)     Q. ".$this->valorpro.".00\n");
            }

            if($this->op==2){
                $impresora->text("Costo a domicilio     Q. ".$this->valoradomicilio.".00\n");
            }
            if($this->op==1 && $this->tpago==2){
                $impresora->text("Recargo tarjeta       Q. ".($this->sumacuenta+$this->valorpro)*0.05."\n");
            }
            if($this->op==2 && $this->tpago==2){
                $impresora->text("Recargo tarjeta       Q. ".($this->sumacuenta+$this->valoradomicilio)*0.05."\n");
            }
            if($this->op==3 && $this->tpago==2){
                $impresora->text("Recargo tarjeta       Q. ".$this->sumacuenta*0.05."\n");
            }
            if($this->op==4 && $this->tpago==2){
                $impresora->text("Recargo tarjeta       Q. ".$this->sumacuenta*0.05."\n");
            }
            if($this->op==1 && $this->tpago==3){
                $impresora->text("Recargo tarjeta       Q. ".$this->recargo_tc2."\n");
            }
            if($this->op==2 && $this->tpago==3){
                $impresora->text("Recargo tarjeta       Q. ".$this->recargo_tc2."\n");
            }
            if($this->op==3 && $this->tpago==3){
                $impresora->text("Recargo tarjeta       Q. ".$this->recargo_tc2."\n");
            }
            if($this->op==4 && $this->tpago==3){
                $impresora->text("Recargo tarjeta       Q. ".$this->recargo_tc2."\n");
            }
            $impresora->text("================================================\n");
            $impresora->text("\n");
            $impresora->setTextSize(1, 2);
            if($this->op==4){
                if($this->tpago==2){
                    $impresora->text("Total Cuenta Q.".($this->sumacuenta)+(($this->sumacuenta)*0.05)." \n");
                }
                elseif($this->tpago==3){
                    $impresora->text("Total Cuenta Q.".($this->sumaefetc." \n"));
                }
                else{
                    $impresora->text("Total Cuenta Q.".($this->sumacuenta)." \n");
                }
                
            }
            elseif($this->op==2){
                if($this->tpago==2){
                    $impresora->text("Total Cuenta Q.".($this->sumacuenta+$this->valoradomicilio)+($this->sumacuenta+$this->valoradomicilio)*0.05."\n");
                }
                elseif($this->tpago==3){
                    $impresora->text("Total Cuenta Q.".($this->sumaefetc." \n"));
                }
                else{
                    $impresora->text("Total Cuenta Q.".($this->sumacuenta+$this->valoradomicilio).".00 \n");
                }
              
            }
            elseif($this->op==3){
                if($this->tpago==2){
                    $impresora->text("Total Cuenta Q.".($this->sumacuenta)+($this->sumacuenta*0.05)." \n");
                }
                elseif($this->tpago==3){
                    $impresora->text("Total Cuenta Q.".($this->sumaefetc." \n"));
                }
                else{
                    $impresora->text("Total Cuenta Q.".($this->sumacuenta).".00 \n");
                }
               
            }
            else{
                if($this->tpago==2){
                    $impresora->text("Total Cuenta Q.".($this->sumacuenta+$this->valorpro)+(($this->sumacuenta+$this->valorpro)*0.05)."\n");   
                }
                elseif($this->tpago==3){
                    $impresora->text("Total Cuenta Q.".($this->sumaefetc." \n"));
                }
                else{
                    $impresora->text("Total Cuenta Q.".($this->sumacuenta+$this->valorpro).".00 \n");   
                }
                
                                
            }
            
            $impresora->setTextSize(1, 1);
            $impresora->text("\n");
            $impresora->text("\n");
            $impresora->text("¡Gracias por su preferencia!");
            $impresora->feed(5);
            $impresora->cut();
            $impresora->close();
            
        }

        public function tipopago($val,$id){
            unset($this->monto_efec);
            unset($this->cambio);
            unset($this->notc);
            unset($this->cuentamasrecargo);
            unset($this->cuentainput);
            $sql = "SELECT * FROM users where id=?";
            $meseros= DB::select($sql,array($this->mesero));
    
            foreach($meseros as $mes){
                $this->nombreMesero=$mes->name;
            }
            if($val==1){
                $this->tpago=1;
            }
            else if($val==2){
                $this->tpago=2;
            }
            
        }
        public function pagomixto($pago,$valor){
            $this->tpago=3;
            if($pago==1){
                $this->tpago=3;
                $this->pago_mixto=3;
            }
            else if($pago==2){
                $this->pago_mixto=2;
            }

        }
        public function pen_pag_tc($monto){
            $this->tpago=3;
            if($this->monto_efec2!=null and $this->monto_efec2!=""){
                $this->monto_tc_par=$monto-$this->monto_efec2;
            }
        }
        public function caltc($a)
        {
            if($this->monto_tc_par!=null && $this->monto_tc_par!="")
            {
                $this->tpago=3;
                $this->cambio=0;
                    $this->cuentamasrecargo=$this->monto_tc_par+($this->monto_tc_par*0.05);
                    $this->recargo_tc2=$this->monto_tc_par*0.05;
                    $this->cuentainput2=$this->cuentamasrecargo;
                    $this->sumaefetc=$this->cuentainput2+$this->monto_efec2;
            }
        }
        public function sumaefec(){
           
        }
        public function calcambio($a){
            if($this->monto_efec!=null && $this->monto_efec!=""){
                $this->cambio=0;
                $this->cambio=$this->monto_efec-$a;
            }
            elseif(empty($this->monto_efec) or $this->monto_efec=="" or $this->monto_efec==null){
                $this->cambio=0;
            }
            else{
                $this->cambio=0;
            }
            
        }

        public function op($valor){
            $op=$valor;

            if($op==1){
                $this->opad=1;
            }
            else if($op==2){
                $this->opad=2;
            }
        }

        public function advalorcambio($iddetalle,$idpedido){

            $sql = "SELECT SUB_TOTAL,costo_guarnicion,costo_cambio FROM tb_detalle_pedidos where ID_DETALLE_PEDIDO=?";
            $dpedido= DB::select($sql,array($iddetalle));
            $dcuenta=0;
            $dcambio=0;
            foreach($dpedido as $dpedid){
                $dcuenta=$dpedid->SUB_TOTAL;
                $dcambio=$dpedid->costo_cambio;
            }

            $sql = "SELECT * FROM tb_pedidos where ID_PEDIDO=?";
            $pedido= DB::select($sql,array($idpedido));
            $cuenta=0;
            foreach($pedido as $pe){
                $cuenta=$pe->MONTO_CUENTA;
            }

            if($this->opad==1){
                

                DB::beginTransaction();

                $detalpedido=DB::table('tb_detalle_pedidos')
                ->where('ID_DETALLE_PEDIDO', $iddetalle)
                ->update(
                    [
                     'SUB_TOTAL' =>$dcuenta+$this->valorcambio,
                     'costo_cambio' =>$dcambio+$this->valorcambio,
                    ]);

               $uppedido=DB::table('tb_pedidos')
               ->where('ID_PEDIDO', $idpedido)
               ->update(
                   [
                    'MONTO_CUENTA' => $cuenta+$this->valorcambio,
                    //'FECHA_CREACION_PEDIDO' =>date('Y-m-d H:i:s'),
                   ]);
               
               if($uppedido && $detalpedido)
                 {
                     DB::commit();
                     session()->forget('creado'); 
                     session(['creado' => ' Asignadas Correctamente.']);
                     $this->reset();
                    

                 }else{
                     DB::rollback();
                     session(['error' => 'validar']);
                 }
            }
            else if($this->opad==2){
               
                
                DB::beginTransaction();

                $detalpedido=DB::table('tb_detalle_pedidos')
                ->where('ID_DETALLE_PEDIDO', $iddetalle)
                ->update(
                    [
                        'SUB_TOTAL' =>$dcuenta-$this->valorcambio,
                        'costo_cambio' =>$dcambio-$this->valorcambio,
                    ]);

               $uppedido=DB::table('tb_pedidos')
               ->where('ID_PEDIDO', $idpedido)
               ->update(
                   [
                    'MONTO_CUENTA' =>$cuenta-$this->valorcambio,
                    //'FECHA_CREACION_PEDIDO' =>date('Y-m-d H:i:s'),
                   ]);
               
                   if($uppedido && $detalpedido)
                 {
                     DB::commit();
                     session()->forget('creado'); 
                     session(['creado' => ' Asignadas Correctamente.']);
                     $this->reset();
                    

                 }else{
                     DB::rollback();
                     session(['error' => 'validar']);
                 }
            }
        }
        
        public function calpagotc($va,$va2,$a){
            if($va==2){
                $this->tpago=2;
              
                $this->cambio=0;
                if($this->op==2){
                    $this->cuentamasrecargo=($a+$this->valoradomicilio)+(($a+$this->valoradomicilio)*0.05);
                $this->cuentainput=$this->cuentamasrecargo;
                $this->cambio=0;
                }
                elseif($this->op==4){
                    $this->cuentamasrecargo=$a+($a*0.05);
                $this->cuentainput=$this->cuentamasrecargo;
                $this->cambio=0;
                }
                else{
                    $this->cuentamasrecargo=$a+($a*0.05);
                    $this->cuentainput=$this->cuentamasrecargo;
                   
                }
             
            }
     
        }

        public function cierrecuentaf($a){
            if($this->tpago==1){
                DB::beginTransaction();
                    $updetalleped=DB::table('tb_detalle_pedidos')
                    ->where('ID_PEDIDIO', $this->idpedido)
                    ->update(
                        [
                         'PAGO' => 1,
                        ]); 

                        if($this->op==2){
                            $resped=DB::table('tb_pedidos')
                            ->where('ID_PEDIDO',  $this->idpedido)
                            ->update(
                                [
                                'MONTO_CUENTA' =>  $this->mo+$this->valoradomicilio,
                                'cancelado' => 3,
                                ]);
                        }

                        else{
                            $resped=DB::table('tb_pedidos')
                            ->where('ID_PEDIDO',  $this->idpedido)
                            ->update(
                                [
                                 'cancelado' => 3,
                                ]);
                        }

                            if(isset($this->m) && $this->m!=null){

                           $upmesa= DB::table('tb_mesas')
                      ->where('ID_MESA', $this->m)
                      ->update(
                          [
                           'disponible' => 0,
                           'FECHA_REGISTRO' =>date('Y-m-d H:i:s'),
                          ]);

                                $guardarpedido=DB::table('tb_pagos_pedidos')->insert(
                                    ['ID_PEDIDO' => $this->idpedido,
                                     'TIPO_PEDIDO'=> $this->t_pedido,
                                     'CANCELADO'=>  3,
                                     'ID_MESA' =>  $this->m,
                                     'MONTO_CUENTA' => $this->mo,
                                     'MONTO_EFECTIVO'=> $this->monto_efec,
                                     'CAMBIO_EFECTIVO'=> $this->cambio,
                                     'FECHA_COBRO_PEDIDO' => date('Y-m-d H:i:s'),
                                     'MONTO_PROPINA'=>$this->mprop,
                                     'FORMA_PAGO'=>$this->tpago,
                                     'MONTO_TC'=>0,
            
                                ]);
                            }
                            elseif($this->op==2){
                                $guardarpedido=DB::table('tb_pagos_pedidos')->insert(
                                    ['ID_PEDIDO' => $this->idpedido,
                                     'TIPO_PEDIDO'=> $this->t_pedido,
                                     'CANCELADO'=>  3,
                                    // 'ID_MESA' =>  $this->m,
                                    'MONTO_CUENTA' =>  $this->mo+$this->valoradomicilio,
                                     'MONTO_EFECTIVO'=> $this->monto_efec,
                                     'CAMBIO_EFECTIVO'=> $this->cambio,
                                     'FECHA_COBRO_PEDIDO' => date('Y-m-d H:i:s'),
                                     'MONTO_PROPINA'=>0,
                                     'MONTO_RECARGO_ENVIO'=>$this->valoradomicilio,
                                     'FORMA_PAGO'=>$this->tpago,
                                     'MONTO_TC'=>0,
            
                                ]);
                            }
                            elseif($this->op==4){
                                $guardarpedido=DB::table('tb_pagos_pedidos')->insert(
                                    ['ID_PEDIDO' => $this->idpedido,
                                     'TIPO_PEDIDO'=> $this->t_pedido,
                                     'CANCELADO'=>  3,
                                     'MONTO_CUENTA' => $this->mo,
                                     'MONTO_EFECTIVO'=> $this->monto_efec,
                                     'CAMBIO_EFECTIVO'=> $this->cambio,
                                     'FECHA_COBRO_PEDIDO' => date('Y-m-d H:i:s'),
                                     'FORMA_PAGO'=>$this->tpago,
                                     'MONTO_TC'=>0,
            
                                ]);
                            }
                            else{
                                $guardarpedido=DB::table('tb_pagos_pedidos')->insert(
                                    ['ID_PEDIDO' => $this->idpedido,
                                     'TIPO_PEDIDO'=> $this->t_pedido,
                                     'CANCELADO'=>  3,
                                     'MONTO_CUENTA' => $this->mo,
                                     'MONTO_EFECTIVO'=> $this->monto_efec,
                                     'CAMBIO_EFECTIVO'=> $this->cambio,
                                     'FECHA_COBRO_PEDIDO' => date('Y-m-d H:i:s'),
                                     'MONTO_PROPINA'=>0,
                                     'FORMA_PAGO'=>$this->tpago,
                                     'MONTO_TC'=>0,
            
                                ]);
                            }


                   
             if(isset($this->m) && $this->m!=null){

                if($resped && $guardarpedido && $updetalleped && $upmesa)
                {
                    DB::commit();
                    session()->forget('creado'); 
                    session(['creado' => ' Asignadas Correctamente.']);

                    if($this->op==3){
                        //$this->cargainfo();
                        $this->cargainfo();
                    }
                    else if($this->op==2){
                        $this->cargainfo();
                        $this->cargainfo();
                    }
                    else if($this->op==4){
                        //$this->cargainfo();
                        $this->cargainfo();
                    }
                    $this->reset();
                    session()->forget('detallepedidos'); 
                    session()->forget('platillosc'); 
                    session()->forget('bebidasc'); 
                    session()->forget('tb_propinas'); 
      
                }else{
                    DB::rollback();
                    session(['error' => 'validar']);
                }
             }else{
                 
                if($resped && $guardarpedido && $updetalleped)
                {
                    DB::commit();
                    session()->forget('creado'); 
                    session(['creado' => ' Asignadas Correctamente.']);
                    if($this->op==3){
                        //$this->cargainfo();
                        $this->cargainfo();
                    }
                    else if($this->op==2){
                        $this->cargainfo();
                        $this->cargainfo();
                    }
                    else if($this->op==4){
                        //$this->cargainfo();
                        //$this->cargainfo();
                    }
                    $this->reset();
                    session()->forget('detallepedidos'); 
                    session()->forget('platillosc'); 
                    session()->forget('bebidasc'); 
                    session()->forget('tb_propinas'); 
      
                }else{
                    DB::rollback();
                    session(['error' => 'validar']);
                }

             }
    
            }
            elseif($this->tpago==2){
                if($this->validate([
                    'notc' => 'required',
                    ])==false){
                    $mensaje="no encontrado";
                   session(['message' => 'no encontrado']);
                    return  back()->withErrors(['mensaje'=>'Validar el input vacio']);
                }else{
                    DB::beginTransaction();
                    $updetalleped=DB::table('tb_detalle_pedidos')
                    ->where('ID_PEDIDIO', $this->idpedido)
                    ->update(
                        [
                         'PAGO' => 1,
                        ]); 

                        if($this->op==2){
                            $resped=DB::table('tb_pedidos')
                            ->where('ID_PEDIDO',  $this->idpedido)
                            ->update(
                                [
                                 'cancelado' => 3,
                                 'MONTO_CUENTA' => ($this->mo+$this->valoradomicilio)+(($this->mo+$this->valoradomicilio)*0.05),
                                 
                                ]);
                        }
                        else{
                            $resped=DB::table('tb_pedidos')
                            ->where('ID_PEDIDO',  $this->idpedido)
                            ->update(
                                [
                                 'cancelado' => 3,
                                 'MONTO_CUENTA' => $this->mo+($this->mo*0.05),
                                ]);
                            }

                            if(isset($this->m) && $this->m!=null){

                           $upmesa= DB::table('tb_mesas')
                      ->where('ID_MESA', $this->m)
                      ->update(
                          [
                           'disponible' => 0,
                           'FECHA_REGISTRO' =>date('Y-m-d H:i:s'),
                          ]);

                                $guardarpedido=DB::table('tb_pagos_pedidos')->insert(
                                    ['ID_PEDIDO' => $this->idpedido,
                                     'TIPO_PEDIDO'=> $this->t_pedido,
                                     'CANCELADO'=>  3,
                                     'ID_MESA' =>  $this->m,
                                     'MONTO_CUENTA' => $this->mo+($this->mo*0.05),
                                     'NO_DOC_POS' => $this->notc,
                                     'MONTO_RECARGO_POS' => $this->mo*0.05,
                                     'FECHA_COBRO_PEDIDO' => date('Y-m-d H:i:s'),
                                     'MONTO_PROPINA'=>$this->mprop,
                                     'FORMA_PAGO'=>$this->tpago,
                                     'MONTO_TC'=>0,
                                ]);
                                
                            }
                            elseif($this->op==2){
                                $guardarpedido=DB::table('tb_pagos_pedidos')->insert(
                                    ['ID_PEDIDO' => $this->idpedido,
                                    'TIPO_PEDIDO'=> $this->t_pedido,
                                    'CANCELADO'=>  3,
                                    'MONTO_CUENTA' => ($this->mo+$this->valoradomicilio)+(($this->mo+$this->valoradomicilio)*0.05),
                                    'NO_DOC_POS' => $this->notc,
                                    'MONTO_RECARGO_POS' => ($this->mo+$this->valoradomicilio)*0.05,
                                    'FECHA_COBRO_PEDIDO' => date('Y-m-d H:i:s'),
                                     'MONTO_PROPINA'=>0,
                                     'MONTO_RECARGO_ENVIO'=>$this->valoradomicilio,
                                     'FORMA_PAGO'=>$this->tpago,
                                     'MONTO_TC'=>0,
            
                                ]);
                            }
                            elseif($this->op==4){
                                $guardarpedido=DB::table('tb_pagos_pedidos')->insert(
                                    ['ID_PEDIDO' => $this->idpedido,
                                     'TIPO_PEDIDO'=> $this->t_pedido,
                                     'CANCELADO'=>  3,
                                     'MONTO_CUENTA' => $this->mo+($this->mo*0.05),
                                     'NO_DOC_POS' => $this->notc,
                                     'MONTO_RECARGO_POS' => $this->mo*0.05,
                                     'FECHA_COBRO_PEDIDO' => date('Y-m-d H:i:s'),
                                     'FORMA_PAGO'=>$this->tpago,
                                     'MONTO_TC'=>0,
            
                                ]);
                            }
                            else{
                                $guardarpedido=DB::table('tb_pagos_pedidos')->insert(
                                    ['ID_PEDIDO' => $this->idpedido,
                                    'TIPO_PEDIDO'=> $this->t_pedido,
                                    'CANCELADO'=>  3,
                                    'MONTO_CUENTA' => $this->mo+($this->mo*0.05),
                                    'NO_DOC_POS' => $this->notc,
                                    'MONTO_RECARGO_POS' => $this->mo*0.05,
                                    'FECHA_COBRO_PEDIDO' => date('Y-m-d H:i:s'),
                                     'MONTO_PROPINA'=>0,
                                     'FORMA_PAGO'=>$this->tpago,
                                     'MONTO_TC'=>0,
            
                                ]);
                            }
                   
             if(isset($this->m) && $this->m!=null){

                if($resped && $guardarpedido && $updetalleped && $upmesa)
                {
                    DB::commit();
                    session()->forget('creado'); 
                    session(['creado' => ' Asignadas Correctamente.']);
                       //$this->cargainfo();
                    $this->reset();
                    session()->forget('detallepedidos'); 
                    session()->forget('platillosc'); 
                    session()->forget('bebidasc'); 
                    session()->forget('tb_propinas'); 
      
                }else{
                    DB::rollback();
                    session(['error' => 'validar']);
                }
             }else{
                 
                if($resped && $guardarpedido && $updetalleped)
                {
                    DB::commit();
                    session()->forget('creado'); 
                    session(['creado' => ' Asignadas Correctamente.']);
                    if($this->op==2){
                        $this->cargainfo();
                        $this->cargainfo();
                    }
                    else if($this->op==3){
                        //$this->cargainfo();
                        $this->cargainfo();
                    }
                    else if($this->op==4){
                        //$this->cargainfo();
                        $this->cargainfo();
                    }
                   // else{
                     //   $this->cargainfo();
                   // }
                    $this->reset();
                    session()->forget('detallepedidos'); 
                    session()->forget('platillosc'); 
                    session()->forget('bebidasc'); 
                    session()->forget('tb_propinas'); 
      
                }else{
                    DB::rollback();
                    session(['error' => 'validar']);
                }

             }

            }
               
            }


//pago mixto
            elseif($this->tpago==3){
                if($this->validate([
                    'notc' => 'required',
                    ])==false){
                    $mensaje="no encontrado";
                   session(['message' => 'no encontrado']);
                    return  back()->withErrors(['mensaje'=>'Validar el input vacio']);
                }else{
                    DB::beginTransaction();
                    $updetalleped=DB::table('tb_detalle_pedidos')
                    ->where('ID_PEDIDIO', $this->idpedido)
                    ->update(
                        [
                         'PAGO' => 1,
                        ]); 

                        if($this->op==2){
                            $resped=DB::table('tb_pedidos')
                            ->where('ID_PEDIDO',  $this->idpedido)
                            ->update(
                                [
                                 'cancelado' => 3,
                                 'MONTO_CUENTA' => $this->sumaefetc,
                                 
                                ]);
                        }
                        else{
                            $resped=DB::table('tb_pedidos')
                            ->where('ID_PEDIDO',  $this->idpedido)
                            ->update(
                                [
                                 'cancelado' => 3,
                                 'MONTO_CUENTA' => $this->sumaefetc,
                                ]);
                            }

                            if(isset($this->m) && $this->m!=null){

                           $upmesa= DB::table('tb_mesas')
                      ->where('ID_MESA', $this->m)
                      ->update(
                          [
                           'disponible' => 0,
                           'FECHA_REGISTRO' =>date('Y-m-d H:i:s'),
                          ]);

                                $guardarpedido=DB::table('tb_pagos_pedidos')->insert(
                                    ['ID_PEDIDO' => $this->idpedido,
                                     'TIPO_PEDIDO'=> $this->t_pedido,
                                     'CANCELADO'=>  3,
                                     'ID_MESA' =>  $this->m,
                                     'MONTO_CUENTA' => $this->sumaefetc,
                                     'NO_DOC_POS' => $this->notc,
                                     'MONTO_RECARGO_POS' => $this->recargo_tc2,
                                     'FECHA_COBRO_PEDIDO' => date('Y-m-d H:i:s'),
                                     'MONTO_PROPINA'=>$this->mprop,
                                     'FORMA_PAGO'=>$this->tpago,
                                     'MONTO_TC'=>$this->cuentainput2,
                                ]);
                                
                            }
                            elseif($this->op==2){
                                $guardarpedido=DB::table('tb_pagos_pedidos')->insert(
                                    ['ID_PEDIDO' => $this->idpedido,
                                    'TIPO_PEDIDO'=> $this->t_pedido,
                                    'CANCELADO'=>  3,
                                    'MONTO_CUENTA' => $this->sumaefetc,
                                    'NO_DOC_POS' => $this->notc,
                                    'MONTO_RECARGO_POS' => $this->recargo_tc2,
                                    'FECHA_COBRO_PEDIDO' => date('Y-m-d H:i:s'),
                                     'MONTO_PROPINA'=>0,
                                     'MONTO_RECARGO_ENVIO'=>$this->valoradomicilio,
                                     'FORMA_PAGO'=>$this->tpago,
                                     'MONTO_TC'=>$this->cuentainput2,
            
                                ]);
                            }
                            elseif($this->op==4){
                                $guardarpedido=DB::table('tb_pagos_pedidos')->insert(
                                    ['ID_PEDIDO' => $this->idpedido,
                                     'TIPO_PEDIDO'=> $this->t_pedido,
                                     'CANCELADO'=>  3,
                                     'MONTO_CUENTA' => $this->sumaefetc,
                                     'NO_DOC_POS' => $this->notc,
                                     'MONTO_RECARGO_POS' =>  $this->recargo_tc2,
                                     'FECHA_COBRO_PEDIDO' => date('Y-m-d H:i:s'),
                                     'FORMA_PAGO'=>$this->tpago,
                                     'MONTO_TC'=>$this->cuentainput2,
            
                                ]);
                            }
                            else{
                                $guardarpedido=DB::table('tb_pagos_pedidos')->insert(
                                    ['ID_PEDIDO' => $this->idpedido,
                                    'TIPO_PEDIDO'=> $this->t_pedido,
                                    'CANCELADO'=>  3,
                                    'MONTO_CUENTA' => $this->sumaefetc,
                                    'NO_DOC_POS' => $this->notc,
                                    'MONTO_RECARGO_POS' =>   $this->recargo_tc2,
                                    'FECHA_COBRO_PEDIDO' => date('Y-m-d H:i:s'),
                                     'MONTO_PROPINA'=>0,
                                     'FORMA_PAGO'=>$this->tpago,
                                     'MONTO_TC'=>$this->cuentainput2,
            
                                ]);
                            }
                   
             if(isset($this->m) && $this->m!=null){

                if($resped && $guardarpedido && $updetalleped && $upmesa)
                {
                    DB::commit();
                    session()->forget('creado'); 
                    session(['creado' => ' Asignadas Correctamente.']);
                       //$this->cargainfo();
                    $this->reset();
                    session()->forget('detallepedidos'); 
                    session()->forget('platillosc'); 
                    session()->forget('bebidasc'); 
                    session()->forget('tb_propinas'); 
      
                }else{
                    DB::rollback();
                    session(['error' => 'validar']);
                }
             }else{
                 
                if($resped && $guardarpedido && $updetalleped)
                {
                    DB::commit();
                    session()->forget('creado'); 
                    session(['creado' => ' Asignadas Correctamente.']);
                    if($this->op==2){
                        $this->cargainfo();
                        $this->cargainfo();
                    }
                    else if($this->op==3){
                        //$this->cargainfo();
                        $this->cargainfo();
                    }
                    else if($this->op==4){
                        //$this->cargainfo();
                        $this->cargainfo();
                    }
                   // else{
                     //   $this->cargainfo();
                   // }
                    $this->reset();
                    session()->forget('detallepedidos'); 
                    session()->forget('platillosc'); 
                    session()->forget('bebidasc'); 
                    session()->forget('tb_propinas'); 
      
                }else{
                    DB::rollback();
                    session(['error' => 'validar']);
                }

             }

            }
               
            }
        }

        public function cargainfo_fel()
        {
            $this->subtotalp=0;
            $this->subtotalex=0;
            $this->sumacuenta=0;
            $this->valorpro=0;
           
            $anio=date("Y");
            $mes=date("m");
            $dia=date("d");
            if($this->op==1){
                $this->nopedido=1;
                $sql = "SELECT * FROM tb_pedidos where cancelado>=1 and ID_MESA=? and YEAR(FECHA_CREACION_PEDIDO)=? and MONTH(FECHA_CREACION_PEDIDO)=? and DAY(FECHA_CREACION_PEDIDO)=?";
                $this->pedidos1= DB::select($sql,array($this->m,$anio,$mes,$dia));
            }
            else{
                
                $sql = "SELECT * FROM tb_pedidos where cancelado>=1 and ID_PEDIDO=? and YEAR(FECHA_CREACION_PEDIDO)=? and MONTH(FECHA_CREACION_PEDIDO)=? and DAY(FECHA_CREACION_PEDIDO)=?";
                $this->pedidos1= DB::select($sql,array($this->idpedg,$anio,$mes,$dia));
            }
              foreach($this->pedidos1 as $pedido1){
                $this->idpedido=$pedido1->ID_PEDIDO;
                $this->noOrden=$pedido1->NO_PEDIDO;
                $this->mesero=$pedido1->ID_EMPLEADO;
                $this->mo=$pedido1->MONTO_CUENTA;
                $this->cancelado=$pedido1->cancelado;
                $this->tpedido=$pedido1->tipo_pedido;
                $this->valoradomicilio1=$pedido1->MONTO_A_DOMICILIO;
            }
            $sql = "SELECT * FROM users where id=?";
            $meseros= DB::select($sql,array($this->mesero));
    
            foreach($meseros as $mes){
                $this->nombreMesero=$mes->name;
            }
    
    
            $sql = "SELECT * FROM tb_detalle_pedidos where ID_PEDIDIO=?";
            $this->detallepedidos= DB::select($sql,array($this->idpedido));

            $sql = "SELECT * FROM tb_detalle_pedidos where ID_PEDIDIO=? and extra=2";
            $this->detallepedidos2= DB::select($sql,array($this->idpedido));
    
            $sql = "SELECT * FROM tb_platillos where eliminado=0 and ESTADO=1";
            $this->platillosc= DB::select($sql);
    
            $sql = "SELECT * FROM tb_bebidas where eliminado=0 and ESTADO=1";
            $this->bebidasc= DB::select($sql);
            if($this->op==1){
                $sql = "SELECT * FROM tb_mesas  where ID_MESA=? and ESTADO=1 AND  disponible=1";
                $this->mesas1= DB::select($sql,array($this->m));
    
            }         
            $sql = "SELECT * FROM tb_propinas";
            $this->propinas= DB::select($sql);
            $this->fel_puerto();


        }

        public function fel_puerto(){
            
 /*            if($this->validate([
                'nitcliente' => 'required',
                'nombcliente' => 'required',
                'direccioncliente' => 'required'
                ])==false){
                return  back()->withErrors(['mensaje'=>'Validar el input vacio']);
            }else
            { */
               // $this->cargainfo_fel();
                $this->subtotalp=0;
                $this->subtotalex=0;
                $this->sumacuenta=0;
                $this->valorpro=0;
                $cod_modeda="GTQ";
                $fecha_emision=date("Y-m-d\TH:i:s");
                $nit_emisor="";
                $nombre_emisor="";
                $nombre_comercial_emisor="";
                $direccion_emisor="";
                $nit_receptor=$this->nitcliente;
                $nombre_receptor=$this->nombcliente;
                $direccion_receptor=$this->direccioncliente;
                $total_iva=0;
                $total_extra=0;
                $xml="<?xml version='1.0' encoding='UTF-8'?>";
                $xml .="<dte:GTDocumento xmlns:xsi=\"http://www.w3.org/2001/XMLSchema-instance\" xmlns:dte=\"http://www.sat.gob.gt/dte/fel/0.2.0\" Version=\"0.1\">";
                 $xml .="<dte:SAT ClaseDocumento=\"dte\">";
                 $xml .="<dte:DTE ID=\"DatosCertificados\">";
                 $xml .="<dte:DatosEmision ID=\"DatosEmision\">";
                 $xml .="<dte:DatosGenerales Tipo=\"FACT\" FechaHoraEmision=\"2022-06-20T22:25:00\" CodigoMoneda=\"GTQ\"/>";
                 $xml .="<dte:Emisor NITEmisor=\"44653948\" NombreEmisor=\"Nombre o Razon Social\" CodigoEstablecimiento=\"1\" NombreComercial=\"Nombre del establecimiento comercial\" AfiliacionIVA=\"GEN\">";
                 $xml .="<dte:DireccionEmisor>";
                 $xml .="<dte:Direccion>CA GUATEMALA, GUATEMALA</dte:Direccion>";
                 $xml .="<dte:CodigoPostal>0100</dte:CodigoPostal>";
                 $xml .="<dte:Municipio>GUATEMALA</dte:Municipio>";
                 $xml .="<dte:Departamento>GUATEMALA</dte:Departamento>";
                 $xml .="<dte:Pais>GT</dte:Pais>";
                 $xml .="</dte:DireccionEmisor>";
                 $xml .="</dte:Emisor>";
                 $xml .="<dte:Receptor NombreReceptor=\"DIGIFACT SERVICIOS\" IDReceptor=\"77454820\">";
                 $xml .="<dte:DireccionReceptor>";
                 $xml .="<dte:Direccion>GUATEMALA</dte:Direccion>";
                 $xml .="<dte:CodigoPostal>01010</dte:CodigoPostal>";
                 $xml .="<dte:Municipio>GUATEMALA</dte:Municipio>";
                 $xml .="<dte:Departamento>GUATEMALA</dte:Departamento>";
                 $xml .="<dte:Pais>GT</dte:Pais>";
                 $xml .="</dte:DireccionReceptor>";
                 $xml .="</dte:Receptor>";
                 $xml .="<dte:Frases>";
                 $xml .="<dte:Frase TipoFrase=\"1\" CodigoEscenario=\"1\"/>";            
                 $xml .="</dte:Frases>";
                //.Inicio recorrido items
                $xml .="<dte:Items>";
                //To dos los items a partir de foreach
                $i=1;
                $total_iva=0;
                     if($this->detallepedidos !=null){
                  
                            foreach($this->detallepedidos as $detallepedido)
                            {
                                $total_extra=$total_extra+($detallepedido->costo_cambio-$detallepedido->costo_guarnicion);
                                    foreach($this->platillosc as $platillo){
                                        if($detallepedido->ID_PLATILLO == $platillo->ID_PLATILLO and $detallepedido->extra==0){                                
                                            $this->subtotalp=($this->subtotalp +($detallepedido->CANTIDAD_SOLICITADA*$platillo->COSTO_PLATILLO));
                           // $xml .="<dte:Items>";
                            $xml .="<dte:Item NumeroLinea=\"{$i}\" BienOServicio=\"B\">";
                            $xml .="<dte:Cantidad>{$detallepedido->CANTIDAD_SOLICITADA}.000</dte:Cantidad>";
                            $xml .="<dte:UnidadMedida>CA</dte:UnidadMedida>";
                            $xml .="<dte:Descripcion>{$platillo->TITULO_PLATILLO}</dte:Descripcion>";
                            $xml .="<dte:PrecioUnitario>{$platillo->COSTO_PLATILLO}.00</dte:PrecioUnitario>";
                            $a=number_format($detallepedido->CANTIDAD_SOLICITADA*$platillo->COSTO_PLATILLO, 2);
                            $xml .="<dte:Precio>{$a}</dte:Precio>";
                            $xml .="<dte:Descuento>0</dte:Descuento>";
                            $xml .="<dte:Impuestos>";
                            $xml .="<dte:Impuesto>";
                            $xml .="<dte:NombreCorto>IVA</dte:NombreCorto>";
                            $xml .="<dte:CodigoUnidadGravable>1</dte:CodigoUnidadGravable>";
                            //$b=($detallepedido->CANTIDAD_SOLICITADA*$platillo->COSTO_PLATILLO)-(($detallepedido->CANTIDAD_SOLICITADA*$platillo->COSTO_PLATILLO)*0.12);
                            $baa=number_format($a/1.12,4);    
                            $xml .="<dte:MontoGravable>{$baa}</dte:MontoGravable>";
                           // $c=($detallepedido->CANTIDAD_SOLICITADA*$platillo->COSTO_PLATILLO)*0.12;
                            $caa=number_format($a-$baa, 4);    
                            $xml .="<dte:MontoImpuesto>{$caa}</dte:MontoImpuesto>";
                            //$total_iva=$total_iva+($detallepedido->CANTIDAD_SOLICITADA*$platillo->COSTO_PLATILLO)*0.12;
                            $total_iva=$total_iva+number_format($caa, 4);     
                            $xml .="</dte:Impuesto>";
                            $xml .="</dte:Impuestos>";
                            $xml .="<dte:Total>{$a}</dte:Total>";
                            $xml .="</dte:Item>";
                          //  $xml .="</dte:Items>";

                                            $i=$i+1;

                                    }
                                }


                                foreach($this->bebidasc as $bebida){
                                    if($detallepedido->ID_PLATILLO == $bebida->ID_BEBIDA  and $detallepedido->extra==0){  
                                        $this->subtotalp=$this->subtotalp + ($detallepedido->CANTIDAD_SOLICITADA*$bebida->COSTO_BEBIDA);                              
                                        // $xml .="<dte:Items>";
                                            $xml .="<dte:Item NumeroLinea=\"{$i}\" BienOServicio=\"B\">";
                                            $xml .="<dte:Cantidad>{$detallepedido->CANTIDAD_SOLICITADA}.000</dte:Cantidad>";
                                            $xml .="<dte:UnidadMedida>CA</dte:UnidadMedida>";
                                            $xml .="<dte:Descripcion>{$bebida->TITUTLO_BEBIDA}</dte:Descripcion>";
                                            $xml .="<dte:PrecioUnitario>{$bebida->COSTO_BEBIDA}.00</dte:PrecioUnitario>";
                                            $a=number_format(($detallepedido->CANTIDAD_SOLICITADA*$bebida->COSTO_BEBIDA), 2);
                                            $xml .="<dte:Precio>{$a}</dte:Precio>";
                                            $xml .="<dte:Descuento>0</dte:Descuento>";
                                            $xml .="<dte:Impuestos>";
                                            $xml .="<dte:Impuesto>";
                                            $xml .="<dte:NombreCorto>IVA</dte:NombreCorto>";
                                            $xml .="<dte:CodigoUnidadGravable>1</dte:CodigoUnidadGravable>";
                                            //$b=($detallepedido->CANTIDAD_SOLICITADA*$platillo->COSTO_PLATILLO)-(($detallepedido->CANTIDAD_SOLICITADA*$platillo->COSTO_PLATILLO)*0.12);
                                            $baa=number_format($a/1.12,4);    
                                            $xml .="<dte:MontoGravable>{$baa}</dte:MontoGravable>";
                                        // $c=($detallepedido->CANTIDAD_SOLICITADA*$platillo->COSTO_PLATILLO)*0.12;
                                            $caa=number_format($a-$baa, 4);    
                                            $xml .="<dte:MontoImpuesto>{$caa}</dte:MontoImpuesto>";
                                            //$total_iva=$total_iva+($detallepedido->CANTIDAD_SOLICITADA*$platillo->COSTO_PLATILLO)*0.12;
                                            $total_iva=$total_iva+number_format($caa, 4);   
                                            $xml .="</dte:Impuesto>";
                                            $xml .="</dte:Impuestos>";
                                            $xml .="<dte:Total>{$a}</dte:Total>";
                                            $xml .="</dte:Item>";
                      //  $xml .="</dte:Items>";

                                        $i=$i+1;

                                }
                            }
                            }


                        }


                        //Extras de pedidos1
                        if($this->detallepedidos2 !=null){
                  
                            foreach($this->detallepedidos2 as $detallepedido)
                            {
                                $total_extra=$total_extra+($detallepedido->costo_cambio-$detallepedido->costo_guarnicion);
                                    foreach($this->platillosc as $platillo){
                                        if($detallepedido->ID_PLATILLO == $platillo->ID_PLATILLO and $detallepedido->extra<=2){                                
                                            $this->subtotalex=($this->subtotalex +($detallepedido->CANTIDAD_SOLICITADA*$platillo->COSTO_PLATILLO)); 
                           // $xml .="<dte:Items>";
                            $xml .="<dte:Item NumeroLinea=\"{$i}\" BienOServicio=\"B\">";
                            $xml .="<dte:Cantidad>{$detallepedido->CANTIDAD_SOLICITADA}.000</dte:Cantidad>";
                            $xml .="<dte:UnidadMedida>CA</dte:UnidadMedida>";
                            $xml .="<dte:Descripcion>{$platillo->TITULO_PLATILLO}</dte:Descripcion>";
                            $xml .="<dte:PrecioUnitario>{$platillo->COSTO_PLATILLO}.00</dte:PrecioUnitario>";
                            $a=number_format($detallepedido->CANTIDAD_SOLICITADA*$platillo->COSTO_PLATILLO, 2);
                            $xml .="<dte:Precio>{$a}</dte:Precio>";
                            $xml .="<dte:Descuento>0</dte:Descuento>";
                            $xml .="<dte:Impuestos>";
                            $xml .="<dte:Impuesto>";
                            $xml .="<dte:NombreCorto>IVA</dte:NombreCorto>";
                            $xml .="<dte:CodigoUnidadGravable>1</dte:CodigoUnidadGravable>";
                            //$b=($detallepedido->CANTIDAD_SOLICITADA*$platillo->COSTO_PLATILLO)-(($detallepedido->CANTIDAD_SOLICITADA*$platillo->COSTO_PLATILLO)*0.12);
                            $baa=number_format($a/1.12,4);    
                            $xml .="<dte:MontoGravable>{$baa}</dte:MontoGravable>";
                           // $c=($detallepedido->CANTIDAD_SOLICITADA*$platillo->COSTO_PLATILLO)*0.12;
                            $caa=number_format($a-$baa, 4);    
                            $xml .="<dte:MontoImpuesto>{$caa}</dte:MontoImpuesto>";
                            //$total_iva=$total_iva+($detallepedido->CANTIDAD_SOLICITADA*$platillo->COSTO_PLATILLO)*0.12;
                            $total_iva=$total_iva+number_format($caa, 4);     
                            $xml .="</dte:Impuesto>";
                            $xml .="</dte:Impuestos>";
                            $xml .="<dte:Total>{$a}</dte:Total>";
                            $xml .="</dte:Item>";
                          //  $xml .="</dte:Items>";

                                            $i=$i+1;

                                    }
                                }


                                foreach($this->bebidasc as $bebida){
                                    if($detallepedido->ID_PLATILLO == $bebida->ID_BEBIDA  and $detallepedido->extra<=2){  
                                        $this->subtotalex=$this->subtotalex +($detallepedido->CANTIDAD_SOLICITADA*$bebida->COSTO_BEBIDA);                            
                                        // $xml .="<dte:Items>";
                                            $xml .="<dte:Item NumeroLinea=\"{$i}\" BienOServicio=\"B\">";
                                            $xml .="<dte:Cantidad>{$detallepedido->CANTIDAD_SOLICITADA}.000</dte:Cantidad>";
                                            $xml .="<dte:UnidadMedida>CA</dte:UnidadMedida>";
                                            $xml .="<dte:Descripcion>{$bebida->TITUTLO_BEBIDA}</dte:Descripcion>";
                                            $xml .="<dte:PrecioUnitario>{$bebida->COSTO_BEBIDA}.00</dte:PrecioUnitario>";
                                            $a=number_format(($detallepedido->CANTIDAD_SOLICITADA*$bebida->COSTO_BEBIDA), 2);
                                            $xml .="<dte:Precio>{$a}</dte:Precio>";
                                            $xml .="<dte:Descuento>0</dte:Descuento>";
                                            $xml .="<dte:Impuestos>";
                                            $xml .="<dte:Impuesto>";
                                            $xml .="<dte:NombreCorto>IVA</dte:NombreCorto>";
                                            $xml .="<dte:CodigoUnidadGravable>1</dte:CodigoUnidadGravable>";
                                            //$b=($detallepedido->CANTIDAD_SOLICITADA*$platillo->COSTO_PLATILLO)-(($detallepedido->CANTIDAD_SOLICITADA*$platillo->COSTO_PLATILLO)*0.12);
                                            $baa=number_format($a/1.12,4);    
                                            $xml .="<dte:MontoGravable>{$baa}</dte:MontoGravable>";
                                        // $c=($detallepedido->CANTIDAD_SOLICITADA*$platillo->COSTO_PLATILLO)*0.12;
                                            $caa=number_format($a-$baa, 4);    
                                            $xml .="<dte:MontoImpuesto>{$caa}</dte:MontoImpuesto>";
                                            //$total_iva=$total_iva+($detallepedido->CANTIDAD_SOLICITADA*$platillo->COSTO_PLATILLO)*0.12;
                                            $total_iva=$total_iva+number_format($caa, 4);   
                                            $xml .="</dte:Impuesto>";
                                            $xml .="</dte:Impuestos>";
                                            $xml .="<dte:Total>{$a}</dte:Total>";
                                            $xml .="</dte:Item>";
                      //  $xml .="</dte:Items>";

                                        $i=$i+1;

                                }
                            }
                            }


                        }
                        if($total_extra>0){
                                      // $xml .="<dte:Items>";
                                      $xml .="<dte:Item NumeroLinea=\"{$i}\" BienOServicio=\"S\">";
                                      $xml .="<dte:Cantidad>1.000</dte:Cantidad>";
                                      $xml .="<dte:UnidadMedida>CA</dte:UnidadMedida>";
                                      $xml .="<dte:Descripcion>Propina</dte:Descripcion>";
                                      $xml .="<dte:PrecioUnitario>{$total_extra}.00</dte:PrecioUnitario>";
                                      $a=number_format($total_extra, 2);
                                      $xml .="<dte:Precio>{$a}</dte:Precio>";
                                      $xml .="<dte:Descuento>0</dte:Descuento>";
                                      $xml .="<dte:Impuestos>";
                                      $xml .="<dte:Impuesto>";
                                      $xml .="<dte:NombreCorto>IVA</dte:NombreCorto>";
                                      $xml .="<dte:CodigoUnidadGravable>1</dte:CodigoUnidadGravable>";
                                      //$b=($detallepedido->CANTIDAD_SOLICITADA*$platillo->COSTO_PLATILLO)-(($detallepedido->CANTIDAD_SOLICITADA*$platillo->COSTO_PLATILLO)*0.12);
                                      $baa=number_format($a/1.12,4);    
                                      $xml .="<dte:MontoGravable>{$baa}</dte:MontoGravable>";
                                  // $c=($detallepedido->CANTIDAD_SOLICITADA*$platillo->COSTO_PLATILLO)*0.12;
                                      $caa=number_format($a-$baa, 4);    
                                      $xml .="<dte:MontoImpuesto>{$caa}</dte:MontoImpuesto>";
                                      //$total_iva=$total_iva+($detallepedido->CANTIDAD_SOLICITADA*$platillo->COSTO_PLATILLO)*0.12;
                                      $total_iva=$total_iva+number_format($caa, 4);    
                                      $xml .="</dte:Impuesto>";
                                      $xml .="</dte:Impuestos>";
                                      $xml .="<dte:Total>{$a}</dte:Total>";
                                      $xml .="</dte:Item>";
                //  $xml .="</dte:Items>";

                                  $i=$i+1;
                        }

                        $this->sumacuenta=$this->subtotalp+$this->subtotalex;
                        if($this->sumacuenta>=80){
                            foreach($this->propinas as $propina){
                                if($propina->monto_inicial<=$this->sumacuenta and $propina->monto_final>=$this->sumacuenta){
                                    $this->valorpro=$propina->monto;
                                  
                                }
                            }
                            $this->sumacuenta= $this->sumacuenta+$this->valorpro;
                                                                    // $xml .="<dte:Items>";
                                            $xml .="<dte:Item NumeroLinea=\"{$i}\" BienOServicio=\"S\">";
                                            $xml .="<dte:Cantidad>1.000</dte:Cantidad>";
                                            $xml .="<dte:UnidadMedida>CA</dte:UnidadMedida>";
                                            $xml .="<dte:Descripcion>Propina</dte:Descripcion>";
                                            $xml .="<dte:PrecioUnitario>{$this->valorpro}.00</dte:PrecioUnitario>";
                                            $a=number_format($this->valorpro, 2);
                                            $xml .="<dte:Precio>{$a}</dte:Precio>";
                                            $xml .="<dte:Descuento>0</dte:Descuento>";
                                            $xml .="<dte:Impuestos>";
                                            $xml .="<dte:Impuesto>";
                                            $xml .="<dte:NombreCorto>IVA</dte:NombreCorto>";
                                            $xml .="<dte:CodigoUnidadGravable>1</dte:CodigoUnidadGravable>";
                                            $baa=number_format($a/1.12,4);    
                                            $xml .="<dte:MontoGravable>{$baa}</dte:MontoGravable>";
                                        // $c=($detallepedido->CANTIDAD_SOLICITADA*$platillo->COSTO_PLATILLO)*0.12;
                                            $caa=number_format($a-$baa, 4);    
                                            $xml .="<dte:MontoImpuesto>{$caa}</dte:MontoImpuesto>";
                                            //$total_iva=$total_iva+($detallepedido->CANTIDAD_SOLICITADA*$platillo->COSTO_PLATILLO)*0.12;
                                            $total_iva=$total_iva+number_format($caa, 4);   
                                            $xml .="</dte:Impuesto>";
                                            $xml .="</dte:Impuestos>";
                                            $xml .="<dte:Total>{$a}</dte:Total>";
                                            $xml .="</dte:Item>";
                      //  $xml .="</dte:Items>";

                                        $i=$i+1;

                        }
                        $xml .="</dte:Items>";
                        //Fin de Items
    
                            $xml .="<dte:Totales>";
                            $xml .="<dte:TotalImpuestos>";
                            $xml .="<dte:TotalImpuesto NombreCorto=\"IVA\" TotalMontoImpuesto=\"{$total_iva}\"/>";
                            $xml .="</dte:TotalImpuestos>";
                            $to=number_format($this->sumacuenta,2);
                            $xml .="<dte:GranTotal>{$to}</dte:GranTotal>";
                            $xml .=" </dte:Totales>";
                            $xml .="</dte:DatosEmision>";
                            $xml .="</dte:DTE> ";
                            $xml .="</dte:SAT>";
                            $xml .="</dte:GTDocumento>";     
                        
                            $response = Http::withHeaders([
                                'Authorization' => 'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJ1bmlxdWVfbmFtZSI6IkdULjAwMDA0NDY1Mzk0OC5GRUxURVNUNDciLCJuYmYiOjE2NTUzNTA3NjUsImV4cCI6MTY4NjQ1NDc2NSwiaWF0IjoxNjU1MzUwNzY1LCJpc3MiOiJodHRwOi8vbG9jYWxob3N0OjQ5MjIwIiwiYXVkIjoiaHR0cDovL2xvY2FsaG9zdDo0OTIyMCJ9.e649FgKEIEvcpqnIXXH0VGR6xmx7ZGuc3mD8Z4_n_VI',
                                'Content-Type' => 'application/json',
                            ])->send('POST', 'https://felgttestaws.digifact.com.gt/gt.com.fel.api.v3/api/FelRequestV2?NIT=000044653948&TIPO=CERTIFICATE_DTE_XML_TOSIGN&FORMAT=XML,PDF&USERNAME=La_Lechita', [
                                'body' => $xml
                            ]);
            $dato2=""; 
            $array = json_decode($response, true);
            $this->respuesta=$array;
            session()->forget('xml'); 
            session(['xml' => $xml]);
            //return redirect()->to('/impresion');
        }

}
