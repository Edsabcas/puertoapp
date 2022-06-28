<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\DB;

class DescuentoComponent extends Component
{

    public $viewdes='createdes';
    public $a,$a2;
    public $id_descuentop,$id_empleado,$descripcion,$id_mes_descuento,$fecha_ingreso,$monto,$cobro_efectuado;
    public function render()
    {
        $sql = "SELECT id,NoEmpleado,Primer_Nombre,Primer_Apellido FROM tb_empleados WHERE Asignacion='2' and Estado='1'";
        $empleados=DB::select($sql);
        $sql = "SELECT id,NoEmpleado,Primer_Nombre,Primer_Apellido FROM tb_empleados WHERE Asignacion='2' and Estado='1' and can_anticipo>0";
        $descuentos=DB::select($sql);
        $mesactual=date('m');
        $anioactual=date('Y');
        $sql = "SELECT * FROM tb_descuentos WHERE cobro_efectuado='0' and YEAR(fecha_ingreso)=? ";
        $descuentos_activos=DB::select($sql,array($anioactual));
        $sql = "SELECT * FROM tb_meses";
        $meses=DB::select($sql);
       
       return view('livewire.descuento-component',compact('empleados','descuentos','meses','mesactual','descuentos_activos'));
    }

    public function eliminardes($id,$id2){
        $sql = "SELECT can_anticipo FROM tb_empleados WHERE id=$id2 and Estado='1'";
        $va=DB::select($sql);
        $can=0;
        foreach($va as $v){
            $can=$v->can_anticipo;
        }
        DB::beginTransaction();
        if(DB::table('tb_descuentos')->where('id_descuento', '=', $id)->delete() &&  DB::table('tb_empleados')
        ->where('id',$id2)
        ->update(['can_anticipo' => $can-1])){
           
            DB::commit();
            session()->forget('delete1'); 
            session(['delete1' => 'si']);
            $this->reset();
        }else{

            DB::rollback();
            session(['error' => 'validar']);
        }
    }
    public function savedes(){
            if($this->validate([
                'id_empleado' => 'required',
                'descripcion' => 'required',
                'monto' => 'required',
                'id_mes_descuento' => 'required',])==false){
                $mensaje="no encontrado";
               session(['message' => 'no encontrado']);
                return  back()->withErrors(['mensaje'=>'Validar el input vacio']);
            }else{
                $sql = "SELECT can_anticipo FROM tb_empleados WHERE id=$this->id_empleado and Estado='1'";
                $va=DB::select($sql);
                $can=0;
                foreach($va as $v){
                    $can=$v->can_anticipo;
                }

                        DB::beginTransaction();
                        if(DB::table('tb_empleados')
                        ->where('id', $this->id_empleado)
                        ->where('can_anticipo','<=',3)
                        ->update(['can_anticipo' => $can+1]) &&  DB::table('tb_descuentos')->insert(
                            ['id_empleado' => $this->id_empleado,
                             'descripcion' => $this->descripcion,
                             'monto' => $this->monto,
                             'id_mes_descuento'=> $this->id_mes_descuento,
                             'fecha_ingreso'=>date('Y-m-d H:i:s'),
                             'cobro_efectuado'=>'0'
                          ]) )
                          {
                            DB::commit();
                            session()->forget('des'); 
                            session(['des' => 'Descuento registrado Asignadas Correctamente.']);
                            $this->reset();
                          }
                        else{
                            DB::rollback();
                            session(['error' => 'validar']);
                        }  
                     
            }
    }
    
    public function edit($id,$nom){
        
        $this->reset();
        $sql = "SELECT * FROM tb_descuentos WHERE id_descuento=?";
        $descuento= DB::select($sql,array($id));
        foreach($descuento as $des){
            $this->id_descuentop=$des->id_descuento;
            $this->id_empleado=$des->id_empleado;
            $this->descripcion=$des->descripcion;
            $this->id_mes_descuento=$des->id_mes_descuento;
            $this->monto=$des->monto;
            $this->fecha_ingreso=$des->fecha_ingreso;
            $this->cobro_efectuado=$des->cobro_efectuado;
        }
        session(['nomb' => $nom]);
        $sql = "SELECT * FROM tb_empleados WHERE id=?";
        $me= DB::select($sql,array($this->id_mes_descuento));
        foreach($me as $m){

            session(['mesdes' => $m->descripcion]); 
        }
        //session(['nomb' => $nom]);
        $this->a='1';
       // session(['editard' => '1']);

    }
    public function actualizardes(){
        
        if($this->validate([
            'id_descuentop' => 'required',
            'id_empleado' => 'required',
            'descripcion' => 'required',
            'id_mes_descuento' => 'required',
            'monto' => 'required',
            ])==false){
            $mensaje="no encontrado";
           session(['message' => 'no encontrado']);
            return  back()->withErrors(['mensaje'=>'Validar el input vacio']);
        }else{
    
         if( DB::table('tb_descuentos')
         ->where('id_descuento', $this->id_descuentop)
         ->update(['id_empleado' => $this->id_empleado,
         'descripcion' => $this->descripcion,
         'id_mes_descuento'=> $this->id_mes_descuento,
         'monto'=> $this->monto,
      ])){
        session()->forget('edit1'); 
        {{session()->forget('nomb');}}
        {{session()->forget('mesdes');}}
        session(['edit1' => 'Descuento Editas Correctamente.']);
        $this->reset();
         }
      }
    
    }
}
