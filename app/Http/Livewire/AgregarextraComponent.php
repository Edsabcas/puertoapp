<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\DB;
use Livewire\WithFileUploads;

class AgregarextraComponent extends Component
{
    public $noMesa,$idMesa,$idCat,$idplatillo;
    public $ID_PLATILLO,$TITULO_PLATILLO,$DESCRIPCION_PLATILLO,$COSTO_PLATILLO,$observaciones,$cantidadp,$BOQUITAS;
    //public $b1,$b2,$b3;
    use WithFileUploads;
    public $observaciones1,$cantidad1;
    public $id_temp,$no_tem_pedido,$id_usuario,$id_platillo,$observacion,$cantidad,$id_mesa,$fecha_creacion_tem_pedido;
    public $notem;
    public $id_ed_pla,$cost_ed_pla,$ed_pla,$tipla,$eliminaritem,$valpedido;
    public $nombre_orden3,$nombre_orden2,$telefono,$direccion,$cat2,$cat3,$cat4,$nombre_empleado,$sin_guarnicion,$cambioaplcat,$varmontoextra;
    public $obscambio,$quitguarnicion;
    public $idboquita1,$nomboquita1;
    public $idboquita2,$nomboquita2;
    public $idboquita3,$nomboquita3;
    public $idboq1,$idboq2,$idboq3;
    public $op,$subtotalp,$subtotalex,$sumacuenta,$valorpro,$fecha,$idpedg;
    public $idpedido,$noOrden,$mesero,$mo,$telef,$tipo_pedido,$dire,$nom_cliente,$cancelado;
    public function render()
    {
       $anio=date("Y");
        $mes=date("m");
        $dia=date("d");

        $sql = "SELECT * FROM tb_pedidos where cancelado<=0 and YEAR(FECHA_CREACION_PEDIDO)=? and MONTH(FECHA_CREACION_PEDIDO)=? and DAY(FECHA_CREACION_PEDIDO)=?";
        $pedidos= DB::select($sql,array($anio,$mes,$dia));
        $sql = "SELECT * FROM tb_mesas  where ESTADO=1 AND  disponible=1";
        $mesas= DB::select($sql);
        $sql = "SELECT * FROM tb_categoria_platillo where ESTADO=1";
        $categorias= DB::select($sql);
        return view('livewire.agregarextra-component',compact('categorias','mesas','pedidos'));
    }
    public function SeleccionMesa($id,$me) {
        unset($this->cat3);
        unset($this->cat2);
        $this->idMesa=$id;  
        $this->noMesa=$me;
       // unset($this->tipo_pedido);
    }

    public function tipo_pedido($a){
        unset($this->tipo_pedido);
        unset($this->idMesa);
        unset($this->noMesa);
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

        public function busquedacuenta2($idpedi){
            unset($this->idMesa);
            unset($this->noMesa);
            $this->subtotalp=0;
            $this->subtotalex=0;
            $this->sumacuenta=0;
            $this->valorpro=0;
            unset($this->nopedido);
            //unset($this->cance);
            unset($this->m);
            unset($this->no_mesa);
            $this->fecha= date("d-m-Y H:i:s");
             $anio=date("Y");
        $mes=date("m");
        $dia=date("d");

            $this->idpedg=$idpedi;

            $sql = "SELECT * FROM tb_pedidos where ID_PEDIDO=? and YEAR(FECHA_CREACION_PEDIDO)=? and MONTH(FECHA_CREACION_PEDIDO)=? and DAY(FECHA_CREACION_PEDIDO)=?";
            $pedidos1= DB::select($sql,array($idpedi,$anio,$mes,$dia));

            foreach($pedidos1 as $pedido1){
                $this->idpedido=$pedido1->ID_PEDIDO;
                $this->idMesa=$pedido1->ID_MESA;
                $this->mo=$pedido1->MONTO_CUENTA;
                $this->nom_cliente=$pedido1->nombre_cliente;
                $this->telef=$pedido1->telefono;
                $this->cancelado=$pedido1->cancelado;
                $this->tipo_pedido=$pedido1->tipo_pedido;
                $this->dire=$pedido1->direccion_pedido;
            }

            if($this->idMesa!=null){
                $sql = "SELECT * FROM tb_mesas where ESTADO=1 AND  disponible=1";
                $mesas1= DB::select($sql);
                foreach($mesas1 as $mes){
                    if($mes->ID_MESA==$this->idMesa){
                        $this->noMesa=$mes->NO_MESA;
                    }
                }
            }
       unset($this->op);

    
        }


    public function cargarlista($idc){
        $this->idCat=$idc;
        
        session()->forget('bebidasc'); 
                session()->forget('platillosc'); 
        if($this->idCat!=null && $this->idCat!=''){
            $sql = "SELECT * FROM tb_platillos where ID_CATEGORIA=? and eliminado=0 and ESTADO=1";
            $platillosc= DB::select($sql,array($this->idCat));

            if(empty($platillosc)==true){

                $sql = "SELECT * FROM tb_bebidas where ID_CATEGORIA=? and eliminado=0 and ESTADO=1";
                $bebidasc= DB::select($sql,array($this->idCat));
                session()->forget('platillosc'); 
                session()->forget('bebidasc'); 
                session(['bebidasc' => $bebidasc]);
            //    session(['platillosc' => $platillosc]);
              
                
           
            }else{
              
                session()->forget('bebidasc'); 
                session()->forget('platillosc'); 
                session(['platillosc' => $platillosc]);
            }
          
        }
        
    }

        public function seleccionarplatillo($idcat2,$id,$titulo,$descripcion,$costo,$boquita,$sin_guarnicion) {
           
          
            $this->idplatillo="";
            $this->ID_PLATILLO="";
            $this->TITULO_PLATILLO="";
            $this->DESCRIPCION_PLATILLO="";
            $this->COSTO_PLATILLO="";
            $this->idplatillo=1;
            $this->ID_PLATILLO=$id;
            $this->TITULO_PLATILLO=$titulo;
            $this->DESCRIPCION_PLATILLO=$descripcion;
            $this->COSTO_PLATILLO=$costo;
            $this->observaciones=".";
            $this->cantidadp="";
            $this->sin_guarnicion=$sin_guarnicion;
            $sql = "SELECT * FROM tb_categoria_platillo where ESTADO=1";
            $categorias= DB::select($sql);
            foreach($categorias as $cat){
                if($cat->ID_CATEGORIA==$idcat2){
                    $this->cambioaplcat=$cat->cambio;
                }
              

            }
            if($boquita==0){
                unset($this->BOQUITAS);
            }else{
                $this->BOQUITAS=$boquita;
            }
           
        }
        public function seleccionarplatillob($id,$titulo,$descripcion,$costo,$boquita) {
           
          
            $this->idplatillo="";
            $this->ID_PLATILLO="";
            $this->TITULO_PLATILLO="";
            $this->DESCRIPCION_PLATILLO="";
            $this->COSTO_PLATILLO="";
            $this->idplatillo=1;
            $this->ID_PLATILLO=$id;
            $this->TITULO_PLATILLO=$titulo;
            $this->DESCRIPCION_PLATILLO=$descripcion;
            $this->COSTO_PLATILLO=$costo;
            $this->observaciones=".";
            $this->cantidadp="";
            $sql = "SELECT * FROM tb_categoria_platillo where ESTADO=1";
            $categorias= DB::select($sql);
            if($boquita==0){
                unset($this->BOQUITAS);
            }else{
                $this->BOQUITAS=$boquita;
            }
           
        }
        public function metodopedido($va){
            unset($this->cat);
            unset($this->idMesa);
            unset($this->noMesa);
            session()->forget('platillosc'); 
            session()->forget('bebidasc'); 
            unset($this->tipo_pedido);
            $this->tipo_pedido=$va;
            if($this->tipo_pedido==4){
               $this->cat4=4;
                $this->nombre_empleado=auth()->user()->name;
            }
    
        }

        public function savep2(){
            if($this->validate([
                'nombre_orden2' => 'required',
                'telefono' => 'required',
                'direccion' => 'required',
                ])==false){
                $mensaje="no encontrado";
               session(['message' => 'no encontrado']);
                return  back()->withErrors(['mensaje'=>'Validar el input vacio']);
            }else{
                
                unset($this->cat3);
                unset($this->cat4);
                $this->cat2=$this->tipo_pedido;
                unset($this->tipo_pedido);
            }
        }

        public function savep3(){
            if($this->validate([
                'nombre_orden3' => 'required',
                ])==false){
                $mensaje="no encontrado";
               session(['message' => 'no encontrado']);
                return  back()->withErrors(['mensaje'=>'Validar el input vacio']);
            }else{

                unset($this->cat2);
                unset($this->cat4);
                $this->cat3=$this->tipo_pedido;
                unset($this->tipo_pedido);
            }
        }

        public function savep4(){
            if($this->validate([
                'nombre_empleado' => 'required',
                ])==false){
                $mensaje="no encontrado";
               session(['message' => 'no encontrado']);
                return  back()->withErrors(['mensaje'=>'Validar el input vacio']);
            }else{

                unset($this->cat2);
                unset($this->cat3);
                $this->cat4=$this->tipo_pedido;
                unset($this->tipo_pedido);
            }
        }
        public function guardartemp(){
            if($this->validate([
                'cantidadp' => 'required',
                'observaciones' => 'required',
                ])==false){
                $mensaje="no encontrado";
               session(['message' => 'no encontrado']);
                return  back()->withErrors(['mensaje'=>'Validar el input vacio']);
            }else{
                if($this->notem!=null) {
                }else
                {
                    $fact=date('Y-m-d H:i:s');
                    $this->notem='tempedido_'.rand(5, 50).$fact;
                    
                }
                if($this->idMesa!=null){
                    $sql = "SELECT * FROM tb_tem_pedido where id_platillo=? and no_tem_pedido=? and id_usuario=? and id_mesa=?";
                    $orden= DB::select($sql,array($this->ID_PLATILLO,$this->notem,auth()->user()->id,$this->idMesa));
                
                }else{
                    $sql = "SELECT * FROM tb_tem_pedido where id_platillo=? and no_tem_pedido=? and id_usuario=?";
                    $orden= DB::select($sql,array($this->ID_PLATILLO,$this->notem,auth()->user()->id));
                
                }
                 $a=0;
               $ob="";
               $can="";
               $valorcambio=0;
               $valorguarni=0;
                if($orden!=null){
                    foreach($orden as $or){
                        $a=$or->id_temp;
                        $ob=$or->observacion;
                        $can=$or->cantidad;
                        $valorcambio=$or->costo_cambio;
                        $valorguarni=$or->costo_guarnicion;
                    }
                    
                    $subtot=0;
                    if($this->varmontoextra!=null){
                        $a=$this->varmontoextra;
                        $valorcambio=$valorcambio+($this->varmontoextra*$this->cantidadp);
                        $subtot=(($can+$this->cantidadp)*$this->COSTO_PLATILLO)+$valorcambio;  
                    }
                    else{
                        $this->varmontoextra=0;
                        $subtot=(($can+$this->cantidadp)*$this->COSTO_PLATILLO)+$valorcambio;

                    }
                    $b=0;
                    if($this->quitguarnicion!=null){
                        $valorguarni= $valorguarni+$this->quitguarnicion;
                        $subtot=$subtot-$valorguarni;
                    }else{
                        $this->quitguarnicion=0;
                        $subtot=$subtot-$valorguarni;
                    }
                   
                    DB::beginTransaction();
                    if( DB::table('tb_tem_pedido')
                    ->where('id_temp', $a)
                    ->update( 
                        [
                         'observacion' => $ob.', '.$this->observaciones,
                         'cantidad' =>$can+$this->cantidadp,
                         'subtotal'=> $subtot,
                         'fecha_creacion_tem_pedido'=>date('Y-m-d H:i:s'),
                         'costo_cambio'=>$valorcambio,
                         'costo_guarnicion'=>$valorguarni,
                      ]))
                      {
                        DB::commit();
                        unset($this->quitguarnicion);
                        unset($this->cambioaplcat);
                        unset($this->varmontoextra);
                        session()->forget('edit'); 
                        session()->forget('platillosc'); 
                        session()->forget('bebidasc'); 
                        session(['edit' => ' Agregado Correctamente.']);
                        $this->idplatillo="";
                        $this->ID_PLATILLO="";
                        $this->TITULO_PLATILLO="";
                        $this->DESCRIPCION_PLATILLO="";
                        $this->COSTO_PLATILLO="";
                        $this->cantidadp="";
                        $this->observaciones="";
                        
                      }
                    else{
                        DB::rollback();
                        session(['erroredit' => 'validar']);
                    }
                }else{
                    $subtot=0;
                    if($this->varmontoextra!=null){
                        $a=($this->varmontoextra*$this->cantidadp);
                        $subtot=$a+($this->cantidadp*$this->COSTO_PLATILLO);  

                     
                    }
                    else{
                        $a=0;
                        $subtot=($this->cantidadp*$this->COSTO_PLATILLO);                    
                    }
                    $b=0;
                    if($this->quitguarnicion!=null){
                        $subtot=$subtot-$this->quitguarnicion;
                    }else{
                        $this->quitguarnicion=0;
                    }

                    if($this->idboquita1!=null){
                        DB::beginTransaction();
                        if( DB::table('tb_tem_pedido')->insert(
                            ['no_tem_pedido' => $this->notem,
                             'id_usuario' => auth()->user()->id,
                             'id_platillo'=> $this->idboquita1,
                             'titulo_pla'=> $this->nomboquita1,
                             'observacion' => "",
                             'cantidad' => 1,
                             'id_mesa'=> $this->idMesa,
                             'fecha_creacion_tem_pedido'=>date('Y-m-d H:i:s'),
                             'subtotal'=> 0,
                             'costo'=> 0,
                             'txtboquita'=> 0,
                             'costo_cambio'=>  0,
                             'costo_guarnicion'=> 0,
                             
                          ]))
                          {
                            DB::commit();
                            unset($this->idboquita1);
                            unset($this->nomboquita1);
                          }
                        else{
                            DB::rollback();
                            session(['error' => 'validar']);
                        }
                    }
                    if($this->idboquita2!=null){
                        DB::beginTransaction();
                        if( DB::table('tb_tem_pedido')->insert(
                            ['no_tem_pedido' => $this->notem,
                             'id_usuario' => auth()->user()->id,
                             'id_platillo'=> $this->idboquita2,
                             'titulo_pla'=> $this->nomboquita2,
                             'observacion' => "",
                             'cantidad' => 1,
                             'id_mesa'=> $this->idMesa,
                             'fecha_creacion_tem_pedido'=>date('Y-m-d H:i:s'),
                             'subtotal'=> 0,
                             'costo'=> 0,
                             'txtboquita'=> 0,
                             'costo_cambio'=>  0,
                             'costo_guarnicion'=> 0,
                             
                          ]))
                          {
                            DB::commit();
                            unset($this->idboquita2);
                            unset($this->nomboquita2);

                          }
                        else{
                            DB::rollback();
                            session(['error' => 'validar']);
                        }
                    }

                    if($this->idboq1!=null){
                        DB::beginTransaction();
                        if( DB::table('tb_tem_pedido')->insert(
                            ['no_tem_pedido' => $this->notem,
                             'id_usuario' => auth()->user()->id,
                             'id_platillo'=> $this->idboq1,
                             'titulo_pla'=> $this->nomboquita1,
                             'observacion' => "",
                             'cantidad' => 1,
                             'id_mesa'=> $this->idMesa,
                             'fecha_creacion_tem_pedido'=>date('Y-m-d H:i:s'),
                             'subtotal'=> 0,
                             'costo'=> 0,
                             'txtboquita'=> 0,
                             'costo_cambio'=>  0,
                             'costo_guarnicion'=> 0,
                             
                          ]))
                          {
                            DB::commit();
                            unset($this->idboq1);
                            unset($this->nomboquita1);
                          }
                        else{
                            DB::rollback();
                            session(['error' => 'validar']);
                        }
                    }
                    if($this->idboq2!=null){
                        DB::beginTransaction();
                        if( DB::table('tb_tem_pedido')->insert(
                            ['no_tem_pedido' => $this->notem,
                             'id_usuario' => auth()->user()->id,
                             'id_platillo'=> $this->idboq2,
                             'titulo_pla'=> $this->nomboquita2,
                             'observacion' => "",
                             'cantidad' => 1,
                             'id_mesa'=> $this->idMesa,
                             'fecha_creacion_tem_pedido'=>date('Y-m-d H:i:s'),
                             'subtotal'=> 0,
                             'costo'=> 0,
                             'txtboquita'=> 0,
                             'costo_cambio'=>  0,
                             'costo_guarnicion'=> 0,
                             
                          ]))
                          {
                            DB::commit();
                            unset($this->idboq2);
                            unset($this->nomboquita2);
                          }
                        else{
                            DB::rollback();
                            session(['error' => 'validar']);
                        }
                    }

                    if($this->idboq3!=null){
                        DB::beginTransaction();
                        if( DB::table('tb_tem_pedido')->insert(
                            ['no_tem_pedido' => $this->notem,
                             'id_usuario' => auth()->user()->id,
                             'id_platillo'=> $this->idboq3,
                             'titulo_pla'=> $this->nomboquita3,
                             'observacion' => "",
                             'cantidad' => 1,
                             'id_mesa'=> $this->idMesa,
                             'fecha_creacion_tem_pedido'=>date('Y-m-d H:i:s'),
                             'subtotal'=> 0,
                             'costo'=> 0,
                             'txtboquita'=> 0,
                             'costo_cambio'=>  0,
                             'costo_guarnicion'=> 0,
                             
                          ]))
                          {
                            DB::commit();
                            unset($this->idboq3);
                            unset($this->nomboquita3);
                          }
                        else{
                            DB::rollback();
                            session(['error' => 'validar']);
                        }
                    }
                    
                    DB::beginTransaction();
                    if( DB::table('tb_tem_pedido')->insert(
                        ['no_tem_pedido' => $this->notem,
                         'id_usuario' => auth()->user()->id,
                         'id_platillo'=> $this->ID_PLATILLO,
                         'titulo_pla'=> $this->TITULO_PLATILLO,
                         'observacion' => $this->observaciones,
                         'cantidad' => $this->cantidadp,
                         'id_mesa'=> $this->idMesa,
                         'fecha_creacion_tem_pedido'=>date('Y-m-d H:i:s'),
                         'subtotal'=> $subtot,
                         'costo'=> $this->COSTO_PLATILLO,
                         'txtboquita'=> $this->COSTO_PLATILLO,
                         'costo_cambio'=>  $a,
                         'costo_guarnicion'=>  $this->quitguarnicion,
                         
                      ]))
                      {
                        DB::commit();
                        unset($this->cambioaplcat);
                        unset($this->quitguarnicion);
                        unset($this->varmontoextra);
                        session()->forget('var'); 
                        session()->forget('platillosc'); 
                        session()->forget('bebidasc'); 
                        session(['var' => ' Asignadas Correctamente.']);
                        $this->valpedido=1;
                        $this->idplatillo="";
                        $this->ID_PLATILLO="";
                        $this->TITULO_PLATILLO="";
                        $this->DESCRIPCION_PLATILLO="";
                        $this->COSTO_PLATILLO="";
                        $this->cantidadp="";
                        $this->observaciones="";
                        
                      }
                    else{
                        DB::rollback();
                        session(['error' => 'validar']);
                    }

                }
         
                
            }

        }
        public function cargaedititem($id,$costop,$cant,$obs,$tipla,$montocambio){
            $this->ed_pla=1;
            $this->id_ed_pla=$id;
            $this->cost_ed_pla=$costop;
            $this->cantidad1=$cant;
            $this->observaciones1=$obs;
            $this->tipla=$tipla;
            $this->varmontoextra=$montocambio;
        }

        public function edititem(){
            if($this->validate([
                'cantidad1' => 'required',
                'observaciones1' => 'required',
                ])==false){
                $mensaje="no encontrado";
               session(['message' => 'no encontrado']);
                return  back()->withErrors(['mensaje'=>'Validar el input vacio']);
            }else{
                DB::beginTransaction();
                    if(DB::table('tb_tem_pedido')
                    ->where('id_temp', $this->id_ed_pla)
                    ->update(
                        [
                         'observacion' => $this->observaciones1,
                         'cantidad' =>$this->cantidad1,
                         'subtotal'=> ($this->cantidad1* $this->cost_ed_pla)+$this->varmontoextra,
                         'fecha_creacion_tem_pedido'=>date('Y-m-d H:i:s'),
                      ]))
                      {
                        DB::commit();
                        session()->forget('platillosc'); 
                        session()->forget('edit'); 
                        session(['edit' => ' Agregado Correctamente.']);
                        unset($this->quitguarnicion);
                        $this->idplatillo="";
                        $this->ID_PLATILLO="";
                        $this->cantidad1="";
                        $this->observaciones1="";
                        unset($this->ed_pla);
                        unset($this->varmontoextra);
                        $this->id_ed_pla="";
                        $this->cost_ed_pla="";
                        $this->cantidad1="";
                        $this->observaciones1="";
                        $this->tipla="";
                        $this->verOrden();
                        
                      }
                    else{
                        DB::rollback();
                        session(['erroredit' => 'validar']);
                    }
            }

        }


        public function verOrden(){
            if($this->idMesa!=null){
                $sql = "SELECT * FROM tb_tem_pedido where no_tem_pedido=? and id_usuario=? and id_mesa=?";
                $orden= DB::select($sql,array($this->notem,auth()->user()->id,$this->idMesa));
                session()->forget('orden'); 
                session(['orden' => $orden]);
            }else{
                $sql = "SELECT * FROM tb_tem_pedido where no_tem_pedido=? and id_usuario=?";
                $orden= DB::select($sql,array($this->notem,auth()->user()->id));
                session()->forget('orden'); 
                session(['orden' => $orden]);
            }
   
        }

        public function cancelaro(){
            DB::beginTransaction();
            if(DB::table('tb_tem_pedido')->where('no_tem_pedido', '=', $this->notem)->delete()) {
                DB::commit();
                session()->forget('orden'); 
                session()->forget('delete1'); 
                session(['delete1' => 'si']);
                $this->reset();
            }else{
    
                DB::rollback();
                session(['error' => 'validar']);
            }
        }
        public function cancelarelim(){
            unset($this->eliminaritem);
        }
        
        public function mostrarbtneliminar($id) {
            $this->eliminaritem=1;
            $this->id_ed_pla=$id;
        }

        public function eliminarItem(){
            DB::beginTransaction();
            if(DB::table('tb_tem_pedido')->where('id_temp', '=',  $this->id_ed_pla)->delete()) {
                DB::commit();
                session()->forget('delete1');
                session(['delete1' => 'si']);
                $this->id_ed_pla="";
                unset($this->eliminaritem);
                $this->verOrden();
            }else{
    
                DB::rollback();
                session(['error' => 'validar']);
            }
        }
        public function valcrearpedidos(){
            $this->valpedido=1;
        }
        public function continuarp(){
            unset($this->valpedido);
        }
        public function boquitaop1($va){
            unset($this->idboquita1);
            unset($this->nomboquita1);
            if($va==1){
                $this->idboquita1=135;
                $this->nomboquita1='Cevichitos';
            }
            elseif($va==2){
                $this->idboquita1=136;
                $this->nomboquita1='Sopitas con camarones';
            }

        }
        public function boquitaop2($va){
            unset($this->idboquita2);
            unset($this->nomboquita2);
            if($va==1){
                $this->idboquita2=135;
                $this->nomboquita2='Cevichitos';
            }
            elseif($va==2){
                $this->idboquita2=136;
                $this->nomboquita2='Sopitas con camarones';
            }
            elseif($va==3){
                $this->idboquita2=137;
                $this->nomboquita2='Camarones fritos';
            }
        }
        public function boquitaop3($va){
            if($va==1){
                if($this->idboq1!=null){
                    unset($this->idboq1);
                }else{
                    $this->idboq1=135;
                    $this->nomboquita1='Cevichitos';
                }
            }
            elseif($va==2){
                if($this->idboq2!=null){
                    unset($this->idboq2);
                }else{
                    $this->idboq2=136;
                    $this->nomboquita2='Sopitas con camarones';
                }
            }
            elseif($va==3){
                if($this->idboq3!=null){
                    unset($this->idboq3);
                }else{
                    $this->idboq3=137;
                    $this->nomboquita3='Camarones fritos';
                }
            }
           
        }

        public function crearpedido(){
            $montoMesa=0;
            $estadoPedido=0;
            if($this->idpedido!=null){
                $sql = "SELECT * FROM tb_tem_pedido where no_tem_pedido=? and id_usuario=?";
                $orden= DB::select($sql,array($this->notem,auth()->user()->id));
    
            }

            if($this->idpedido!=null){
                foreach($orden as $ord){
                    $mon=0;
                    if($this->cat4!=null){
                        $mon= $ord->subtotal/2;
                    }else{
                        $mon= $ord->subtotal;
                    }
                    $montoMesa = $montoMesa + $ord->subtotal;
                    DB::beginTransaction();
                    if(DB::table('tb_detalle_pedidos')->insert(
                        ['ID_PLATILLO' => $ord->id_platillo,
                         'ID_PEDIDIO'=> $this->idpedido,
                         'CANTIDAD_SOLICITADA'=>  $ord->cantidad,
                         'SUB_TOTAL' =>  $mon,
                         'OBSERVACION' => $ord->observacion,
                         'FECHA_DETALLE_EXTRA'=> date('Y-m-d H:i:s'),
                         'costo_cambio' => $ord->costo_cambio,
                         'extra' => 1,
                         'costo_guarnicion' => $ord->costo_guarnicion,
                      ]))
                      {
                        DB::commit();
                      }
                    else{
                        DB::rollback();
                        session(['error' => 'validar']);
                    }
               }

               if($this->op==4){
                $montoMesa=$montoMesa/2;
               }

               DB::beginTransaction();
               if(DB::table('tb_tem_pedido')->where('no_tem_pedido', '=', $this->notem)->delete()) {
                   DB::commit();
               }else{
                   DB::rollback();
               }
               DB::beginTransaction();
               $uppedido=DB::table('tb_pedidos')
               ->where('ID_PEDIDO', $this->idpedido)
               ->update(
                   [
                    'extra' => 1,
                    'cancelado' => 0,
                    'MONTO_CUENTA' =>$this->mo+ $montoMesa,
                    'ESTADO_EXTRA' => 0,
                    'leido_ex' => 0,
                    'FECHA_CREACION_EXTRA' =>date('Y-m-d H:i:s'),
                   ]);
               
               if($uppedido)
                 {
                     DB::commit();
                     session()->forget('creado'); 
                     session(['creado' => ' Asignadas Correctamente.']);
                     $this->reset();
                    

                 }else{
                     DB::rollback();
                     session(['error' => 'validar']);
                 }
            }else{

            }

        }    
        public function agregarextra($a){
            if($a==1){
                $this->varmontoextra=25;
                $this->observaciones="Extra marisco 4oz. , ".$this->observaciones;

            }
            elseif($a==2){
                $this->varmontoextra=40;
                $this->observaciones="Extra marisco 6oz., ".$this->observaciones;
            }
            elseif($a==3){
                $this->varmontoextra=10;
                $this->observaciones="., ".$this->observaciones;
            }
            elseif($a==0){
                unset($this->varmontoextra);
                $this->observaciones=".";
            }
        }
        public function quitarguarnicion($a)
        {
            if($a==1){
                $this->quitguarnicion=10;
                $this->observaciones="Sin guarnición, ".$this->observaciones;

            }
            if($a==2){
                $this->quitguarnicion=5;
                $this->observaciones="Sin guarnición, ".$this->observaciones;

            }
            elseif($a==0){
                unset($this->quitguarnicion);
                $this->observaciones=".";
            }
        }
}
