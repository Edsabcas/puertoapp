<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\DB;

class VerPedidoComponent extends Component
{
    public $cadena="", $r=0,$fpedido,$leido,$leido2,$con;
    public function render()
    {
        $anio=date("Y");
        $mes=date("m");
        $dia=date("d");

        $sql = "SELECT count(ID_PEDIDO) as cantidad FROM tb_pedidos where (ESTADO_PEDIDO=0 or ESTADO_PEDIDO=1)  and YEAR(FECHA_CREACION_PEDIDO)=? and MONTH(FECHA_CREACION_PEDIDO)=? and DAY(FECHA_CREACION_PEDIDO)=?";
        $can_pedidos= DB::select($sql,array($anio,$mes,$dia));

        $sql = "SELECT tb.*,me.name FROM tb_pedidos tb
        inner join
        users me on tb.ID_EMPLEADO=me.id
         where ESTADO_PEDIDO>=0 and YEAR(FECHA_CREACION_PEDIDO)=? and MONTH(FECHA_CREACION_PEDIDO)=? and DAY(FECHA_CREACION_PEDIDO)=?";
        $pedidos= DB::select($sql,array($anio,$mes,$dia));

        $sql = "SELECT ID_PEDIDO,leido FROM tb_pedidos where ESTADO_PEDIDO>=0 and leido=0 and YEAR(FECHA_CREACION_PEDIDO)=? and MONTH(FECHA_CREACION_PEDIDO)=? and DAY(FECHA_CREACION_PEDIDO)=?";
        $pedidos2= DB::select($sql,array($anio,$mes,$dia));


        $sql = "SELECT ID_PEDIDO,leido_ex FROM tb_pedidos where extra=1 and leido_ex=0 and YEAR(FECHA_CREACION_PEDIDO)=? and MONTH(FECHA_CREACION_PEDIDO)=? and DAY(FECHA_CREACION_PEDIDO)=?";
        $pedidos_extra2= DB::select($sql,array($anio,$mes,$dia));



        $rol=session('rolus');
        //$this->leido=0;
        if($rol==4){
            foreach($pedidos2 as $pedido){
                if($pedido->leido==0){
                    $this->leido=$this->leido+1;
                    DB::table('tb_pedidos')
                    ->where('ID_PEDIDO', $pedido->ID_PEDIDO)
                    ->update(
                        [
                         'leido' => 1,
                      //   'FECHA_CREACION_PEDIDO' =>date('Y-m-d H:i:s'),
                        ]);
                }
            }
            foreach($pedidos_extra2 as $pedidos_extr){
                if($pedidos_extr->leido_ex==0){
                    $this->leido2=$this->leido2+1;
                    DB::table('tb_pedidos')
                    ->where('ID_PEDIDO', $pedidos_extr->ID_PEDIDO)
                    ->update(
                        [
                         'leido_ex' => 1,
                      //   'FECHA_CREACION_PEDIDO' =>date('Y-m-d H:i:s'),
                        ]);
                }
            }
        }

        $sql = "SELECT * FROM tb_categoria_platillo";
        $categorias= DB::select($sql);
        $sql = "SELECT * FROM tb_platillos WHERE eliminado=0";
        $platillos= DB::select($sql);
        $sql = "SELECT * FROM tb_bebidas where eliminado=0";
        $bebidas= DB::select($sql);
        $sql = "SELECT * FROM tb_mesas where disponible=1";
        $mesas= DB::select($sql);
        $sql = "SELECT * FROM tb_detalle_pedidos where extra=0 and YEAR(FECHA_DETALLE_EXTRA)=? and MONTH(FECHA_DETALLE_EXTRA)=? and DAY(FECHA_DETALLE_EXTRA)=?";
        $detalle_pe= DB::select($sql,array($anio,$mes,$dia));
        $sql = "SELECT * FROM rol_users1s";
        $rol= DB::select($sql);

        $sql = "SELECT tb.*,me.name FROM tb_pedidos tb
        inner join
        users me on tb.ID_EMPLEADO=me.id
        where extra=1 and YEAR(FECHA_CREACION_PEDIDO)=? and MONTH(FECHA_CREACION_PEDIDO)=? and DAY(FECHA_CREACION_PEDIDO)=? and ESTADO_EXTRA<3";
        $pedidos_extra= DB::select($sql,array($anio,$mes,$dia));

       

        $sql = "SELECT * FROM tb_detalle_pedidos where extra=1 and YEAR(FECHA_DETALLE_EXTRA)=? and MONTH(FECHA_DETALLE_EXTRA)=? and DAY(FECHA_DETALLE_EXTRA)=?";
        $detalle_pe_ex= DB::select($sql,array($anio,$mes,$dia));

        return view('livewire.ver-pedido-component',compact('can_pedidos','pedidos_extra','detalle_pe_ex','pedidos','categorias','platillos','bebidas','detalle_pe','mesas','rol'));
    }

    public function cambio_cocina_pla($pedido,$estado,$f,$val){
        $cambioestado=0;
        if($estado ==1 or $estado ==0){
            $cambioestado=2;
            $this->uptable($pedido,$cambioestado,$f,$val);
        }

    }
    public function cambio_cocina_cevi1($pedido,$estado,$f,$val){
        $cambioestado=0;
        if($estado ==1 or $estado ==0){
            $cambioestado=2;
            $this->uptable($pedido,$cambioestado,$f,$val);
        }

    }
    public function cambio_cocina_cevi2($pedido,$estado,$f,$val){
        $cambioestado=0;
        if($estado ==1 or $estado ==0){
            $cambioestado=2;
            $this->uptable($pedido,$cambioestado,$f,$val);
        }

    }
    public function cambio_cocina_gene($pedido,$estado,$f,$val){
        $cambioestado=0;
        if($estado ==1 or $estado ==0){
            $cambioestado=2;
            $this->uptable($pedido,$cambioestado,$f,$val);
        }

    }
    public function cambio_cocina_gene2($pedido,$estado,$f,$val){
        $cambioestado=0;
        if($estado ==1 or $estado ==0){
            $cambioestado=2;
            $this->uptable($pedido,$cambioestado,$f,$val);
        }

    }
    public function cambio_bebi($pedido,$estado,$f,$val){
        $cambioestado=0;
        if($estado ==0){
            $cambioestado=1;
            $this->uptable($pedido,$cambioestado,$f,$val);
        }      
    }
    public function cambio_entrega_pla($pedido,$estado,$f,$val){
        $cambioestado=0;
        if($estado ==2 or $estado ==0){
            $cambioestado=3;
            $this->uptable($pedido,$cambioestado,$f,$val);
        }      
    }
    //El cambio de estado 3 a 4 ocurre cuando realizan el pedido del extra.

    public function cambio_cocina_extra($pedido,$estado,$f,$val){
        $cambioestado=0;
        if($estado ==0 or $estado ==1){
            $cambioestado=2;
            $this->uptableex($pedido,$cambioestado,$f,$val);
        }      
    }
    public function cambio_servicio_extra($pedido,$estado,$f,$val){
        $cambioestado=0;
        if($estado ==0){
            $cambioestado=1;
            $this->uptableex($pedido,$cambioestado,$f,$val);
        }      
    }   
    public function cambio_entrega_extra($pedido,$estado,$f,$val){
        $cambioestado=0;
        if($estado ==2 or $estado ==1 or $estado ==0){
            $cambioestado=3;
            $this->uptableex($pedido,$cambioestado,$f,$val);
        }      
    } 
    

    public function uptable($pedido,$es,$f,$va){
        $id_us=auth()->user()->id;
        $ro_us="";
        $sql="SELECT * FROM rol_users1s where id_user=?";
        $rols=DB::SELECT($sql,array($id_us));
        foreach($rols as $rol){
            $ro_us=$rol->id_tipo_rol;
        }

        DB::beginTransaction();
    if(DB::table('tb_pedidos')
        ->where('ID_PEDIDO', $pedido)
        ->update(
            [
             'ESTADO_PEDIDO' => $es,
            ]) && 
           DB::table('tb_salida_pedidos_log')->insert(
                ['id_rol' => $ro_us,
                 'id_usuario' => auth()->user()->id,
                 'id_pedido'=> $pedido,
                 'tiempo_cambio_e'=> $va,
                 'fecha_pedido' => $f,
                 'fecha_cambio' => date('Y-m-d H:i:s'),
              ])
            )
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
    public function uptableex($pedido,$es,$f,$va){
        $id_us=auth()->user()->id;
        $ro_us="";
        $sql="SELECT * FROM rol_users1s where id_user=?";
        $rols=DB::SELECT($sql,array($id_us));
        foreach($rols as $rol){
            $ro_us=$rol->id_tipo_rol;
        }

        DB::beginTransaction();
    $upp= DB::table('tb_pedidos')
        ->where('ID_PEDIDO', $pedido)
        ->update(
            [
             'ESTADO_EXTRA' => $es,
          //   'FECHA_CREACION_PEDIDO' =>date('Y-m-d H:i:s'),
            ]);

            if($es==3){
                $upex= DB::table('tb_detalle_pedidos')
                ->where('ID_PEDIDIO', $pedido)
                ->where('extra', 1)
                ->update(
                    [
                     'extra' => 2,
                    ]); 
                    
            }
 
       $uplog= DB::table('tb_salida_pedidos_log')->insert(
                    ['id_rol' => $ro_us,
                    'id_usuario' => auth()->user()->id,
                    'id_pedido'=> $pedido,
                    'tiempo_cambio_e'=> $va,
                    'fecha_pedido' => $f,
                     'fecha_cambio' => date('Y-m-d H:i:s'),
                ]);
                if($es==3){
                    if($upp && $upex && $uplog)
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
                else{
                    if($upp && $uplog)
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
}
