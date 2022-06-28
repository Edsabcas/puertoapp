<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\DB;
use Mike42\Escpos\PrintConnectors\WindowsPrintConnector;
use Mike42\Escpos\Printer;
use Illuminate\Support\Facades\Http;
use DOMDocument;

class ComprobantemesaordenComponent extends Component
{
    public $nopedido,$subtotalp,$subtotalex,$sumacuenta,$total;
    public $pedidos1,$detallepedidos,$platillosc,$bebidasc,$mesas1,$cancelado;
    public $noOrden,$no_mesa,$mesero,$fecha,$mon,$idpedido,$tpago,$nombreMesero;
    public $m,$cance,$op,$nom_cliente,$telef,$dire,$propinas,$valorpro,$monto_efec,$tpedido;
    public $valorinput,$notc,$cuentamasrecargo,$detallepedidos2;
    public $array1=array(),$cambio,$mo,$cuentainput;
    public $idpedg,$opad,$valorcambio,$t_pedido,$mprop,$valoradomicilio,$valoradomicilio1;
    public $estado_p,$estado_ex,$productos,$cui_unic;
    public $pago_mixto,$monto_tc_par,$cuentainput2,$monto_efec2,$sumaefetc,$recargo_tc2;
    public $array2=array(),$mensaje,$existe,$respuesta,$forma_fac,$avalorpro;
    public $fel,$nitcliente,$nombcliente,$direccioncliente,$nitclientereg,$nombclientereg,$direccionclientereg;
    public $tipo_selc_impri,$serie,$autorizacion,$dte,$nit_cert,$nomb_cert,$fecha_cert,$nombre_emisor,$nombre_comercial_emisor,$direccion_emisor,$nit_emisor;
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
                $this->tipo_selc_impri=$val;
            }
            else if($val==2){
                $this->reset([
                    'nitcliente',
                    'nombcliente',
                    'direccioncliente',
    
                ]);
                $this->nitcliente="CF";
                $this->nombcliente="Consumidor final";
                $this->direccioncliente=".";
                $this->tipo_selc_impri=$val; 
            }
            else
            {
                $this->reset([
                    'nitcliente',
                    'nombcliente',
                    'direccioncliente',
    
                ]);
                $this->tipo_selc_impri=$val; 
            }
        }
        public function guardar_tipo_doc(){
            if($this->tipo_selc_impri==1){
                $this->cargainfo_fel();
            }
            else if($this->tipo_selc_impri==2){
                $this->cargainfo_fel();
            }
            else if($this->tipo_selc_impri==3){

            }
        }
        function generateUuidv4()
        {
            return sprintf('%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
            // 32 bits for "time_low"
            mt_rand(0, 0xffff), mt_rand(0, 0xffff),
            // 16 bits for "time_mid"
            mt_rand(0, 0xffff),
            // 16 bits for "time_hi_and_version",
            // four most significant bits holds version number 4
            mt_rand(0, 0x0fff) | 0x4000,
            // 16 bits, 8 bits for "clk_seq_hi_res",
            // 8 bits for "clk_seq_low",
            // two most significant bits holds zero and one for variant DCE1.1
            mt_rand(0, 0x3fff) | 0x8000,
            // 48 bits for "node"
            mt_rand(0, 0xffff), mt_rand(0, 0xffff), mt_rand(0, 0xffff)
            );
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

              /*   $sql = "SELECT * FROM tb_clientes where nit=?";
                $buscliente= DB::select($sql,array($this->nitcliente));
                $encuentra=0; */
                $response = Http::withHeaders([
                    'Authorization' => 'Bearer eyJhbGciOiJSUzI1NiIsInR5cCI6IkpXVCJ9.eyJzY29wZSI6WyJvcGVuaWQiXSwiZXhwIjoxNjU4NjA3OTkzLCJhdXRob3JpdGllcyI6WyJST0xFX0VNSVNPUiJdLCJqdGkiOiI0N2Q5ZGNkNS05YTNhLTRmMzEtOTJhMS0yZTA2NmQ3ODE3ZmMiLCJjbGllbnRfaWQiOiI5NTQ1MTMxIn0.yB6teT0p3C5RT1DIfcgnbddwrS_fwDgENuha_GXXl89Omb5Z_XRJEtJpdo2cIJ06xksrQtjmgxcTV8SasNXqWi-fPz7YkYQTjuNkeatxHgdHAkpq3EtTJ-gDUnall1xCrfCgp4p5rWoz0ui6Dr4plZctEpnFc6527AOwwqMoM5VM_HU-RUvRj-idvbuliBsMMPm91wVx4cuEuJ6ihQhjmnitmbB4IuTiw1BiUGC-T5MG1D50YFObvVeChDqLrRYGAVJksL2RtJBI6Y-hMS5dXCSt2Vua-rk1Mm2ClHrhF4buN5jSBWKqnf2ikJjmQ41Ggyo7pMYO4NDac7ppm4HAxQ',
                    'Content-Type' => 'aapplication/xml',
                ])->send('POST', 'https://dev2.api.ifacere-fel.com/api/retornarDatosCliente', [
                    'body' =>'<?xml version="1.0" encoding="UTF-8"?>
                    <RetornaDatosClienteRequest>
                    <nit>'.$this->nitcliente.'</nit>
                    </RetornaDatosClienteRequest>'
                ]);
                //$this->nombcliente=$response;
                $buscar0= strpos($response, "<tipo_respuesta>0</tipo_respuesta>");   
                if($buscar0==true){
                    $remp1=str_replace ('<direcciones>','' , $response);
                    $remp2=str_replace ('</direcciones>','' , $remp1);
                    $remp3=preg_replace("/[\r\n|\n|\r]+/", PHP_EOL, $remp2);
                    $xmlObject = simplexml_load_string($remp3);
                   // $this->nombcliente=$xmlObject->direccion[0];
                    $json = json_encode($xmlObject);
                    $phpArray = json_decode($json, true); 
                    foreach ($phpArray as $clave => $valor) {
                        // $array[3] se actualizará con cada valor de $array...
                        if($clave=='direccion'){
                          $this->direccioncliente=$valor;
                        }
                        else if($clave=='nombre'){
                          $this->nombcliente=$valor;
                        }
                       // echo "{$clave} => {$valor} ";
                        //print_r($array);
                    }
                // $this->nombcliente=$Xml->direcciones[0]->direccion;
                    //$this->nombcliente=$response;
                }else{
                    $this->existe=2;
                    //$this->nitcliente="";
                   //$this->nombcliente="";
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
        public function formafac($val){
            $this->forma_fac=$val;
        }
        public function fel_puerto(){
            
            if($this->validate([
                'nitcliente' => 'required',
                'nombcliente' => 'required',
                'direccioncliente' => 'required'
                ])==false){
                return  back()->withErrors(['mensaje'=>'Validar el input vacio']);
            }else
            {
               // $this->cargainfo_fel();
               $cui_unico=strtoupper($this->generateUuidv4());
               $this->cui_unic=$cui_unico;
               $nombre_fel_txt='Fe_puerto/fel_'.$cui_unico.'.txt';
                $cod_modeda="GTQ";
                $fecha_emision=date("Y-m-d\TH:i:s");
                $this->nit_emisor="9545131";
                $this->nombre_emisor="OTTO EZEQUIEL GALVEZ CORTES";
                $this->nombre_comercial_emisor="RESTAURANTE DE MARISCOS EL PUERTO";
                $this->direccion_emisor="CARRETERA INTERAMERICANA KM 53 5 ALDEA LOS PLANES Chimaltenango,";
                $departamento_di_emisor="CHIMALTENANGO";
                $nit_receptor=$this->nitcliente;
                $nombre_receptor=$this->nombcliente;
                $direccion_receptor=$this->direccioncliente;
                $total_iva=0;
                $total_extra=0;
               
                $xml="<?xml version='1.0' encoding='UTF-8' standalone=\"no\"?>";
                $xml .="<dte:GTDocumento xmlns:dte=\"http://www.sat.gob.gt/dte/fel/0.2.0\" Version=\"0.1\">";
                 $xml .="<dte:SAT ClaseDocumento=\"dte\">";
                 $xml .="<dte:DTE ID=\"DatosCertificados\">";
                 $xml .="<dte:DatosEmision ID=\"DatosEmision\">";
                 $xml .="<dte:DatosGenerales Tipo=\"FACT\" FechaHoraEmision=\"{$fecha_emision}\" CodigoMoneda=\"GTQ\"/>";
                 $xml .="<dte:Emisor AfiliacionIVA=\"GEN\" CodigoEstablecimiento=\"1\"  NITEmisor=\"{$this->nit_emisor}\" NombreComercial=\"{$this->nombre_comercial_emisor}\" NombreEmisor=\"{$this->nombre_emisor}\">";
                 $xml .="<dte:DireccionEmisor>";
                 $xml .="<dte:Direccion>{$this->direccion_emisor}</dte:Direccion>";
                 $xml .="<dte:CodigoPostal>0</dte:CodigoPostal>";
                 $xml .="<dte:Municipio>{$departamento_di_emisor}</dte:Municipio>";
                 $xml .="<dte:Departamento>{$departamento_di_emisor}</dte:Departamento>";
                 $xml .="<dte:Pais>GT</dte:Pais>";
                 $xml .="</dte:DireccionEmisor>";
                 $xml .="</dte:Emisor>";
                 $xml .="<dte:Receptor CorreoReceptor=\"\" IDReceptor=\"{$nit_receptor}\" NombreReceptor=\"{$nombre_receptor}\" >";
                 $xml .="<dte:DireccionReceptor>";
                 $xml .="<dte:Direccion>{$direccion_receptor}</dte:Direccion>";
                 $xml .="<dte:CodigoPostal>0</dte:CodigoPostal>";
                 $xml .="<dte:Municipio>GUATEMALA</dte:Municipio>";
                 $xml .="<dte:Departamento>GUATEMALA</dte:Departamento>";
                 $xml .="<dte:Pais>GT</dte:Pais>";
                 $xml .="</dte:DireccionReceptor>";
                 $xml .="</dte:Receptor>";
                 $xml .="<dte:Frases>";
                 $xml .="<dte:Frase CodigoEscenario=\"1\" TipoFrase=\"1\"/>";       
                 $xml .="</dte:Frases>";
                //.Inicio recorrido items
                $xml .="<dte:Items>";


                $i=1;
                $total_iva=0;
                if($this->forma_fac!=null &&  $this->forma_fac==1){
                    $this->subtotalp=0;
                    $this->subtotalex=0;
                    $this->sumacuenta=0;
                    $this->valorpro=0;
                //To dos los items a partir de foreach
                     if($this->detallepedidos !=null){
                  
                            foreach($this->detallepedidos as $detallepedido)
                            {
                                $total_extra=$total_extra+($detallepedido->costo_cambio-$detallepedido->costo_guarnicion);
                                    foreach($this->platillosc as $platillo){
                                        if($detallepedido->ID_PLATILLO == $platillo->ID_PLATILLO and $detallepedido->extra==0){                                
                                            $this->subtotalp=($this->subtotalp +($detallepedido->CANTIDAD_SOLICITADA*$platillo->COSTO_PLATILLO));
                           // $xml .="<dte:Items>";
                            $xml .="<dte:Item BienOServicio=\"B\" NumeroLinea=\"{$i}\">";
                            $xml .="<dte:Cantidad>{$detallepedido->CANTIDAD_SOLICITADA}.00</dte:Cantidad>";
                            $xml .="<dte:UnidadMedida>UNI</dte:UnidadMedida>";
                            $xml .="<dte:Descripcion>{$platillo->TITULO_PLATILLO}</dte:Descripcion>";
                            $xml .="<dte:PrecioUnitario>{$platillo->COSTO_PLATILLO}.00</dte:PrecioUnitario>";
                            $a=number_format($detallepedido->CANTIDAD_SOLICITADA*$platillo->COSTO_PLATILLO, 2);
                            $xml .="<dte:Precio>{$a}</dte:Precio>";
                            $xml .="<dte:Descuento>0</dte:Descuento>";
                            $xml .="<dte:Impuestos>";
                            $xml .="<dte:Impuesto>";
                            $xml .="<dte:NombreCorto>IVA</dte:NombreCorto>";
                            $xml .="<dte:CodigoUnidadGravable>1</dte:CodigoUnidadGravable>";
                            $baa=number_format($a/1.12,4);    
                            $xml .="<dte:MontoGravable>{$baa}</dte:MontoGravable>";
                            $caa=number_format($a-$baa, 4);    
                            $xml .="<dte:MontoImpuesto>{$caa}</dte:MontoImpuesto>";
                            $total_iva=$total_iva+number_format($caa, 4);     
                            $xml .="</dte:Impuesto>";
                            $xml .="</dte:Impuestos>";
                            $xml .="<dte:Total>{$a}</dte:Total>";
                            $xml .="</dte:Item>";
                                            $i=$i+1;
                                    }
                                }
                                foreach($this->bebidasc as $bebida){
                                    if($detallepedido->ID_PLATILLO == $bebida->ID_BEBIDA  and $detallepedido->extra==0){  
                                        $this->subtotalp=$this->subtotalp + ($detallepedido->CANTIDAD_SOLICITADA*$bebida->COSTO_BEBIDA);                              
                                        // $xml .="<dte:Items>";
                                            $xml .="<dte:Item BienOServicio=\"B\" NumeroLinea=\"{$i}\">";
                                            $xml .="<dte:Cantidad>{$detallepedido->CANTIDAD_SOLICITADA}.00</dte:Cantidad>";
                                            $xml .="<dte:UnidadMedida>UNI</dte:UnidadMedida>";
                                            $xml .="<dte:Descripcion>{$bebida->TITUTLO_BEBIDA}</dte:Descripcion>";
                                            $xml .="<dte:PrecioUnitario>{$bebida->COSTO_BEBIDA}.00</dte:PrecioUnitario>";
                                            $a=number_format(($detallepedido->CANTIDAD_SOLICITADA*$bebida->COSTO_BEBIDA), 2);
                                            $xml .="<dte:Precio>{$a}</dte:Precio>";
                                            $xml .="<dte:Descuento>0</dte:Descuento>";
                                            $xml .="<dte:Impuestos>";
                                            $xml .="<dte:Impuesto>";
                                            $xml .="<dte:NombreCorto>IVA</dte:NombreCorto>";
                                            $xml .="<dte:CodigoUnidadGravable>1</dte:CodigoUnidadGravable>";
                                            $baa=number_format($a/1.12,4);    
                                            $xml .="<dte:MontoGravable>{$baa}</dte:MontoGravable>";
                                            $caa=number_format($a-$baa, 4);    
                                            $xml .="<dte:MontoImpuesto>{$caa}</dte:MontoImpuesto>";
                                            $total_iva=$total_iva+number_format($caa, 4);   
                                            $xml .="</dte:Impuesto>";
                                            $xml .="</dte:Impuestos>";
                                            $xml .="<dte:Total>{$a}</dte:Total>";
                                            $xml .="</dte:Item>";
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
                            $xml .="<dte:Item BienOServicio=\"B\" NumeroLinea=\"{$i}\">";
                            $xml .="<dte:Cantidad>{$detallepedido->CANTIDAD_SOLICITADA}.00</dte:Cantidad>";
                            $xml .="<dte:UnidadMedida>UNI</dte:UnidadMedida>";
                            $xml .="<dte:Descripcion>{$platillo->TITULO_PLATILLO}</dte:Descripcion>";
                            $xml .="<dte:PrecioUnitario>{$platillo->COSTO_PLATILLO}.00</dte:PrecioUnitario>";
                            $a=number_format($detallepedido->CANTIDAD_SOLICITADA*$platillo->COSTO_PLATILLO, 2);
                            $xml .="<dte:Precio>{$a}</dte:Precio>";
                            $xml .="<dte:Descuento>0</dte:Descuento>";
                            $xml .="<dte:Impuestos>";
                            $xml .="<dte:Impuesto>";
                            $xml .="<dte:NombreCorto>IVA</dte:NombreCorto>";
                            $xml .="<dte:CodigoUnidadGravable>1</dte:CodigoUnidadGravable>";
                            $baa=number_format($a/1.12,4);    
                            $xml .="<dte:MontoGravable>{$baa}</dte:MontoGravable>";
                            $caa=number_format($a-$baa, 4);    
                            $xml .="<dte:MontoImpuesto>{$caa}</dte:MontoImpuesto>";
                            $total_iva=$total_iva+number_format($caa, 4);     
                            $xml .="</dte:Impuesto>";
                            $xml .="</dte:Impuestos>";
                            $xml .="<dte:Total>{$a}</dte:Total>";
                            $xml .="</dte:Item>";
                                            $i=$i+1;

                                    }
                                }


                                foreach($this->bebidasc as $bebida){
                                    if($detallepedido->ID_PLATILLO == $bebida->ID_BEBIDA  and $detallepedido->extra<=2){  
                                        $this->subtotalex=$this->subtotalex +($detallepedido->CANTIDAD_SOLICITADA*$bebida->COSTO_BEBIDA);                            
                                        // $xml .="<dte:Items>";
                                            $xml .="<dte:Item BienOServicio=\"B\" NumeroLinea=\"{$i}\">";
                                            $xml .="<dte:Cantidad>{$detallepedido->CANTIDAD_SOLICITADA}.00</dte:Cantidad>";
                                            $xml .="<dte:UnidadMedida>UNI</dte:UnidadMedida>";
                                            $xml .="<dte:Descripcion>{$bebida->TITUTLO_BEBIDA}</dte:Descripcion>";
                                            $xml .="<dte:PrecioUnitario>{$bebida->COSTO_BEBIDA}.00</dte:PrecioUnitario>";
                                            $a=number_format(($detallepedido->CANTIDAD_SOLICITADA*$bebida->COSTO_BEBIDA), 2);
                                            $xml .="<dte:Precio>{$a}</dte:Precio>";
                                            $xml .="<dte:Descuento>0</dte:Descuento>";
                                            $xml .="<dte:Impuestos>";
                                            $xml .="<dte:Impuesto>";
                                            $xml .="<dte:NombreCorto>IVA</dte:NombreCorto>";
                                            $xml .="<dte:CodigoUnidadGravable>1</dte:CodigoUnidadGravable>";
                                            $baa=number_format($a/1.12,4);    
                                            $xml .="<dte:MontoGravable>{$baa}</dte:MontoGravable>";
                                            $caa=number_format($a-$baa, 4);    
                                            $xml .="<dte:MontoImpuesto>{$caa}</dte:MontoImpuesto>";
                                            $total_iva=$total_iva+number_format($caa, 4);   
                                            $xml .="</dte:Impuesto>";
                                            $xml .="</dte:Impuestos>";
                                            $xml .="<dte:Total>{$a}</dte:Total>";
                                            $xml .="</dte:Item>";
                                        $i=$i+1;

                                }
                            }
                            }


                        }
                        if($total_extra>0){
                                      // $xml .="<dte:Items>";
                                      $xml .="<dte:Item BienOServicio=\"S\" NumeroLinea=\"{$i}\">";
                                      $xml .="<dte:Cantidad>1.00</dte:Cantidad>";
                                      $xml .="<dte:UnidadMedida>UNI</dte:UnidadMedida>";
                                      $xml .="<dte:Descripcion>Extras y cambios</dte:Descripcion>";
                                      $xml .="<dte:PrecioUnitario>{$total_extra}.00</dte:PrecioUnitario>";
                                      $a=number_format($total_extra, 2);
                                      $xml .="<dte:Precio>{$a}</dte:Precio>";
                                      $xml .="<dte:Descuento>0</dte:Descuento>";
                                      $xml .="<dte:Impuestos>";
                                      $xml .="<dte:Impuesto>";
                                      $xml .="<dte:NombreCorto>IVA</dte:NombreCorto>";
                                      $xml .="<dte:CodigoUnidadGravable>1</dte:CodigoUnidadGravable>";
                                      $baa=number_format($a/1.12,4);    
                                      $xml .="<dte:MontoGravable>{$baa}</dte:MontoGravable>";
                                      $caa=number_format($a-$baa, 4);    
                                      $xml .="<dte:MontoImpuesto>{$caa}</dte:MontoImpuesto>";
                                      $total_iva=$total_iva+number_format($caa, 4);    
                                      $xml .="</dte:Impuesto>";
                                      $xml .="</dte:Impuestos>";
                                      $xml .="<dte:Total>{$a}</dte:Total>";
                                      $xml .="</dte:Item>";

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
                                            $xml .="<dte:Item BienOServicio=\"S\" NumeroLinea=\"{$i}\">";
                                            $xml .="<dte:Cantidad>1.00</dte:Cantidad>";
                                            $xml .="<dte:UnidadMedida>UNI</dte:UnidadMedida>";
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
                                            $caa=number_format($a-$baa, 4);    
                                            $xml .="<dte:MontoImpuesto>{$caa}</dte:MontoImpuesto>";
                                            $total_iva=$total_iva+number_format($caa, 4);   
                                            $xml .="</dte:Impuesto>";
                                            $xml .="</dte:Impuestos>";
                                            $xml .="<dte:Total>{$a}</dte:Total>";
                                            $xml .="</dte:Item>";
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

                    }

                    elseif($this->forma_fac!=null &&  $this->forma_fac==2){


                        $total=$this->sumacuenta+$this->avalorpro;
                        $xml .="<dte:Item BienOServicio=\"S\" NumeroLinea=\"{$i}\">";
                        $xml .="<dte:Cantidad>1.00</dte:Cantidad>";
                        $xml .="<dte:UnidadMedida>UNI</dte:UnidadMedida>";
                        $xml .="<dte:Descripcion>Por consumo de alimentos.</dte:Descripcion>";
                        $xml .="<dte:PrecioUnitario>{$total}.00</dte:PrecioUnitario>";
                        $a=number_format($total, 2);
                        $xml .="<dte:Precio>{$a}</dte:Precio>";
                        $xml .="<dte:Descuento>0</dte:Descuento>";
                        $xml .="<dte:Impuestos>";
                        $xml .="<dte:Impuesto>";
                        $xml .="<dte:NombreCorto>IVA</dte:NombreCorto>";
                        $xml .="<dte:CodigoUnidadGravable>1</dte:CodigoUnidadGravable>";
                        $baa=number_format($a/1.12,4);    
                        $xml .="<dte:MontoGravable>{$baa}</dte:MontoGravable>";
                        $caa=number_format($a-$baa, 4);    
                        $xml .="<dte:MontoImpuesto>{$caa}</dte:MontoImpuesto>";
                        $total_iva=$total_iva+number_format($caa, 4);   
                        $xml .="</dte:Impuesto>";
                        $xml .="</dte:Impuestos>";
                        $xml .="<dte:Total>{$a}</dte:Total>";
                        $xml .="</dte:Item>";

                        $xml .="</dte:Items>";
                        //Fin de Items
    
                            $xml .="<dte:Totales>";
                            $xml .="<dte:TotalImpuestos>";
                            $xml .="<dte:TotalImpuesto NombreCorto=\"IVA\" TotalMontoImpuesto=\"{$total_iva}\"/>";
                            $xml .="</dte:TotalImpuestos>";
                            $to=number_format($this->total,2);
                            $xml .="<dte:GranTotal>{$to}</dte:GranTotal>";
                            $xml .=" </dte:Totales>";
                            $xml .="</dte:DatosEmision>";
                            $xml .="</dte:DTE> ";
                            $xml .="</dte:SAT>";
                            $xml .="</dte:GTDocumento>";

                    }

                     
                            
                        //Firmar DTE
                            $response = Http::withHeaders([
                                'Authorization' => 'Bearer eyJhbGciOiJSUzI1NiIsInR5cCI6IkpXVCJ9.eyJzY29wZSI6WyJvcGVuaWQiXSwiZXhwIjoxNjU4NTE5MDQzLCJhdXRob3JpdGllcyI6WyJST0xFX0VNSVNPUiJdLCJqdGkiOiJmMDRjZmNkYS1iZTM3LTQzZmItYWYwNC0xNDkxNDA4NGY2NDYiLCJjbGllbnRfaWQiOiI5NTQ1MTMxIn0.BsHBhsEXRZAKciDJyrIddPhfYpW_XTrqjnhWybc-raEAl71TGVMF8RzcaB29TTVtppJz2QvbgmnoQQGiWZ-8lmM7BMNj8rto0pi4DtF7AswQiK7nzg-IJsDzIqReuStIEP0yTghPbZOrWwDlzkTZgiIOhjYQUwXH__GIn4sL1JKghIouH5ZD6k0CNI3Gy3WQptQZXsVZWbYe2Iw8tyPojHURckHcLbu-UhCwNHBrBD_aDz0Q8zOdZ0HZYnBYL9cahp829gGS5JBauDn6AI0BV2MaZfZDObk99S4ZLeucV1yO2Ggs_GvSPLAb9XcKosxFrAQcxKWind-UsIOHWLGrVA',
                                'Content-Type' => 'application/xml',
                            ])->send('POST', 'https://dev.api.soluciones-mega.com/api/solicitaFirma', [
                                'body' =>'<?xml version="1.0" encoding="UTF-8"?>
                                <FirmaDocumentoRequest id="'.$cui_unico.'">
                                <xml_dte><![CDATA['.$xml.']]></xml_dte>
                                </FirmaDocumentoRequest>'
                            ]);
                            $buscar0= strpos($response, "<tipo_respuesta>0</tipo_respuesta>");
                            if($buscar0==true){
                                $remp1=str_replace ('&lt;','<' , $response);
                                $remp2=str_replace ('&gt;','>' , $remp1);
                                $remp3=str_replace ('&amp;#13;','' , $remp2);
                                $remp3=str_replace ('<?xml version="1.0" encoding="UTF-8" standalone="yes"?><FirmaDocumentoResponse><xml_dte>','' , $remp3);
                                $remp4 = stristr( $remp3, "</xml_dte>", true );

                                //Registrar XML Firmado
                                $response = Http::withHeaders([
                                    'Authorization' => 'Bearer eyJhbGciOiJSUzI1NiIsInR5cCI6IkpXVCJ9.eyJzY29wZSI6WyJvcGVuaWQiXSwiZXhwIjoxNjU4NTE5MDQzLCJhdXRob3JpdGllcyI6WyJST0xFX0VNSVNPUiJdLCJqdGkiOiJmMDRjZmNkYS1iZTM3LTQzZmItYWYwNC0xNDkxNDA4NGY2NDYiLCJjbGllbnRfaWQiOiI5NTQ1MTMxIn0.BsHBhsEXRZAKciDJyrIddPhfYpW_XTrqjnhWybc-raEAl71TGVMF8RzcaB29TTVtppJz2QvbgmnoQQGiWZ-8lmM7BMNj8rto0pi4DtF7AswQiK7nzg-IJsDzIqReuStIEP0yTghPbZOrWwDlzkTZgiIOhjYQUwXH__GIn4sL1JKghIouH5ZD6k0CNI3Gy3WQptQZXsVZWbYe2Iw8tyPojHURckHcLbu-UhCwNHBrBD_aDz0Q8zOdZ0HZYnBYL9cahp829gGS5JBauDn6AI0BV2MaZfZDObk99S4ZLeucV1yO2Ggs_GvSPLAb9XcKosxFrAQcxKWind-UsIOHWLGrVA',
                                    'Content-Type' => 'application/xml',
                                ])->send('POST', 'https://dev2.api.ifacere-fel.com/api/registrarDocumentoXML', [
                                    'body' =>'<?xml version="1.0" encoding="UTF-8"?>
                                    <RegistraDocumentoXMLRequest id="'.$cui_unico.'">
                                    <xml_dte><![CDATA['.$remp4.']]></xml_dte>
                                    </RegistraDocumentoXMLRequest>'
                                ]);

                                $buscar0 = strpos($response, "<tipo_respuesta>0</tipo_respuesta>");
                            if($buscar0==true){
                                $fh = fopen($nombre_fel_txt, 'w') or die("Se produjo un error al crear el archivo");                
                                $texto = $response;                            
                                fwrite($fh, $texto) or die("No se pudo escribir en el archivo");                            
                                fclose($fh);
                                $remp1=str_replace ('&lt;','<' , $response);
                                $remp2=str_replace ('&gt;','>' , $remp1);
                                $remp3=str_replace ('&amp;#13;','' , $remp2);
                                $remp31=str_replace ('<?xml version="1.0" encoding="UTF-8" standalone="yes"?><RegistraDocumentoXMLResponse><xml_dte>','' , $remp3);
                                $remp4 = stristr($remp31, "</xml_dte>", true );
                                $remp5=str_replace ('dte:','' , $remp4);
                                $this->respuesta=1;
                                session()->forget('xml'); 
                                session(['xml' => $remp5]);
                                $xmlObject = simplexml_load_string($remp5);
                                $document = new DOMDocument('1.0', 'UTF-8');
                                $document->loadXML($remp5);
                                // $this->nombcliente=$xmlObject->direccion[0];
                                // $json = json_encode($xmlObject);
                                 //$phpArray = json_decode($json, true); 
                                 $factura_xml = $document->getElementsByTagName('SAT');
                                // $this->fel_xml=$factura_xml;
                                 foreach($factura_xml as $factura){
                                    $idElem = $factura->getElementsByTagName('DTE');
                                  //  $nombre = $factura->getElementsByTagName('NombreComercial')->item(0)->nodeValue;
                                     
                                    foreach($idElem as $hijo){
                                       $ced = $hijo->getElementsByTagName('Certificacion');
                                        $items= $hijo->getElementsByTagName('Items');
                                       //$this->productos=$items;
                                      /*  foreach($items as $item){
                                       } */

                                        foreach($ced as $cedulita){
                                            $this->nit_cert=$cedulita->getElementsByTagName('NITCertificador')->item(0)->nodeValue;
                                            $this->nomb_cert=$cedulita->getElementsByTagName('NombreCertificador')->item(0)->nodeValue;
                                            $this->fecha_cert=$cedulita->getElementsByTagName('FechaHoraCertificacion')->item(0)->nodeValue;
                                            $this->autorizacion = $cedulita->getElementsByTagName('NumeroAutorizacion')->item(0)->nodeValue;
                                            $this->serie = $cedulita->getElementsByTagName('NumeroAutorizacion')->item(0)->getAttribute('Serie');
                                            $this->dte = $cedulita->getElementsByTagName('NumeroAutorizacion')->item(0)->getAttribute('Numero');
                                        }
                                    }
                                 }

                            }
                            else{
                                $this->respuesta=1;
                                session()->forget('xml'); 
                                session(['xml' => $response]);
                            }
                            }
                            else{
                                $this->respuesta=1;
                                session()->forget('xml'); 
                                session(['xml' => $response]);
                            }
            }
           /*  $array = json_decode($response, true); */
          
            //return
        }

        public function insert_tb_fel(){
            if($this->validate([
                'nitcliente' => 'required',
                'nombcliente' => 'required',
                'direccioncliente' => 'required',
                'fecha_cert' => 'required',
                'autorizacion' => 'required',
                'serie' => 'required',
                'dte' => 'required',  
                'cui_unic' => 'required',
                'forma_fac'=>'required'
                ])==false){
                return  back()->withErrors(['mensaje'=>'Validar el input vacio']);
            }else
            {
                $id=$this->idpedg;
                
                
            }
        }

}
