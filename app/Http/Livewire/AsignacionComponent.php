<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Percepcion;
use App\Models\Deduccion;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
class AsignacionComponent extends Component
{
    public $viewper='createper';
    public $viewdedu='creatededu';
    public $viewdiasfal='creatediasfal';
    public $id_deducciones, $id_empleadod, $iggs_laboral, $isr, $descuentos_judiciales,$otros2,$fecha_ingreso;
    public $id_per, $id_empleadop, $salario_ordinario, $bonificacion_mensual, $bonificacion_productividad, $fecha_asignacion;
    public $a,$a2,$nuevo;
    public $id_dia_falta,$dias_faltantes,$id_percepcionp,$id_mes_descuento,$observacion,$fecha_registro,$monto_descuento;
    public function igss(){
        if($this->salario_ordinario!=null){
            $this->iggs_laboral=number_format($this->salario_ordinario*0.0483,2);
            $this->bonificacion_mensual=number_format(250,2);
        }
    }
    public function desdiasfal(){
            if($this->dias_faltantes!=null){
                $d=(($this->salario_ordinario/30)*$this->dias_faltantes);
                $this->monto_descuento=round($d,2);
            }
            
          //  $this->bonificacion_mensual=number_format(250,2);
    }
    public function render()
    {
       // Session::flush();

        $sql = "SELECT id,NoEmpleado,Primer_Nombre,Primer_Apellido,Estado FROM tb_empleados WHERE Asignacion='0'";
         $percepciones=DB::select($sql);
         $sql = "SELECT id,NoEmpleado,Primer_Nombre,Primer_Apellido FROM tb_empleados WHERE Asignacion='1'";
         $deducciones=DB::select($sql);
         $sql = "SELECT id,NoEmpleado,Primer_Nombre,Primer_Apellido FROM tb_empleados WHERE Asignacion='2' OR Asignacion='3'";
         $asignaciones=DB::select($sql);
         $sql = "SELECT * FROM tb_percepciones_laborales";
         $perce= DB::select($sql);
         $mesactual=date('m');
         $sql = "SELECT * FROM tb_dias_descuento WHERE MONTH(fecha_registro)=?";
         $tb_dias_fal= DB::select($sql,array($mesactual));
        return view('livewire.asignacion-component',compact('perce','percepciones','deducciones','asignaciones','tb_dias_fal'));
   
    }
    public function eliminarasig($id){
        DB::beginTransaction();
        if(DB::table('tb_percepciones_laborales')->where('id_empleado', '=', $id)->delete() && 
        DB::table('tb_deducciones')->where('id_empleado', '=', $id)->delete()&&  
        DB::table('tb_empleados')
                        ->where('id',$id)
                        ->update(['Asignacion' => '0']) ){

            DB::commit();
            session()->forget('delete1'); 
            session(['delete1' => 'si']);
            $this->reset();
        }else{

            DB::rollback();
            session(['error' => 'validar']);
        }
        
    }
    public function eliminardias($id){
        DB::beginTransaction();
        if(DB::table('tb_dias_descuento')->where('id_dia_falta', '=', $id)->delete()) {
            DB::commit();
            session()->forget('delete1'); 
            session(['delete1' => 'si']);
            $this->reset();
        }else{

            DB::rollback();
            session(['error' => 'validar']);
        }
    }
    public function save(){
            if($this->validate([
                'id_empleadop' => 'required',
                'salario_ordinario' => 'required',
                'bonificacion_productividad' => 'required',
                'bonificacion_mensual' => 'required',
                'iggs_laboral'=>'required',
                'isr'=>'required',
                'descuentos_judiciales'=>'required',
                ])==false){
                $mensaje="no encontrado";
               session(['message' => 'no encontrado']);
                return  back()->withErrors(['mensaje'=>'Validar el input vacio']);
            }else{

                    $sql = "SELECT * FROM tb_empleados WHERE id=?";
                    $val= DB::select($sql,array($this->id_empleadop));    
     
                    if(empty($val)){
                        DB::beginTransaction();
                        if(DB::table('tb_empleados')
                        ->where('id', $this->id_empleadop)
                        ->update(['Asignacion' => '2']) &&  DB::table('tb_percepciones_laborales')->insert(
                            ['id_empleado' => $this->id_empleadop,
                             'salario_ordinario' => $this->salario_ordinario,
                             'bonificacion_productividad'=> $this->bonificacion_productividad,
                            'bonificacion_mensual'=> $this->bonificacion_mensual,
                            'fecha_asignacion'=>date('Y-m-d H:i:s')
                          ])  &&  DB::table('tb_deducciones')->insert(
                            ['id_empleado' => $this->id_empleadop,
                             'iggs_laboral' => $this->iggs_laboral,
                             'isr'=> $this->isr,
                             'descuentos_judiciales'=> $this->descuentos_judiciales,
                             'fecha_ingreso'=>date('Y-m-d H:i:s')
                          ]))
                          {

                            DB::commit();
                            session()->forget('var'); 
                            session(['var' => ' Asignadas Correctamente.']);
                            $this->reset();
                            
                          }
                        else{
                            DB::rollback();
                            session(['error' => 'validar']);
                        }
                     
                    }

                    else{
                        session(['var1' => 'existe']);       
                    }
            }
    }

    public function updatepd(){
        if($this->validate([
            'id_empleadop' => 'required',
            'salario_ordinario' => 'required',
            'bonificacion_productividad' => 'required',
            'bonificacion_mensual' => 'required',
            'iggs_laboral'=>'required',
            'isr'=>'required',
            'descuentos_judiciales'=>'required',])==false){

            $mensaje="no encontrado";
           session(['message' => 'no encontrado']);
            return  back()->withErrors(['mensaje'=>'Validar el input vacio']);

        }
        else{

            DB::beginTransaction();
            $per= DB::table('tb_percepciones_laborales')
            ->where('id_per', $this->id_per)
            ->update( ['id_empleado' => $this->id_empleadop,
            'salario_ordinario' => $this->salario_ordinario,
            'bonificacion_productividad'=> $this->bonificacion_productividad,
           'bonificacion_mensual'=> $this->bonificacion_mensual,
           'fecha_asignacion'=> date("Y-m-d H:i:s"),
        ]);
        $de=DB::table('tb_deducciones')
        ->where('id_deducciones', $this->id_deducciones)
        ->update(['id_empleado' => $this->id_empleadod,
        'iggs_laboral' => $this->iggs_laboral,
        'isr'=> $this->isr,
        'descuentos_judiciales'=> $this->descuentos_judiciales,
        'fecha_ingreso'=> date("Y-m-d H:i:s"),
  
    ]);
    $insertdias='';
if(session('a5')!=null && session('nuevo')=='1'){
    if($this->validate([
        'dias_faltantes' => 'required',
        'id_mes_descuento' => 'required',
        'bonificacion_mensual' => 'required',
        'observacion'=>'required',
        ])==false){

        $mensaje="no encontrado";
       session(['message' => 'no encontrado']);
        return  back()->withErrors(['mensaje'=>'Validar el input vacio']);

    }
    else{

        $insertdias=DB::table('tb_dias_descuento')->insert(
            ['dias_faltantes' => $this->dias_faltantes,
             'id_percepcion' => $this->id_per,
             'id_mes_descuento'=> $this->id_mes_descuento,
             'observacion'=> $this->observacion,
             'fecha_registro'=> date("Y-m-d H:i:s"),
             'monto_descuento'=> $this->monto_descuento,
        ]);
    }
}
if(session('updiasfal')!=null && session('nuevo2')=='1'){

    if($this->validate([
        'dias_faltantes' => 'required',
        'id_mes_descuento' => 'required',
        'bonificacion_mensual' => 'required',
        'observacion'=>'required',])==false){

        $mensaje="no encontrado";
       session(['message' => 'no encontrado']);
        return  back()->withErrors(['mensaje'=>'Validar el input vacio']);

    }
    else{

        $insertdias=DB::table('tb_dias_descuento')
        ->where('id_dia_falta', $this->id_dia_falta)
        ->update([
            'dias_faltantes' => $this->dias_faltantes,
             'id_percepcion' => $this->id_percepcionp,
             'id_mes_descuento'=> $this->id_mes_descuento,
             'observacion'=> $this->observacion,
             'fecha_registro'=> date("Y-m-d H:i:s"),
             'monto_descuento'=> $this->monto_descuento,
        ]);
    }
}
         if($per|| $de || $insertdias ){
        DB::commit();
        session()->forget('nuevo');
        session()->forget('a5');
        session()->forget('updiasfal');
        session()->forget('edit'); 
        session()->forget('nomb');
        session(['edit' => 'Edito Correctamente.']);
        session()->forget('nomb'); 
        $this->reset();
         }
         else{
            DB::rollback();
            session(['error' => 'validar']);
             }

         }
}
public function activediasfal(){
    session(['a5' => '1']);
    $sql = "SELECT * FROM tb_meses";
    $meses=DB::select($sql);
    $mesactual=date('m');
    session()->forget('mesactual');
    session()->forget('meses');
    session(['meses' => $meses]);
    session(['mesactual' => $mesactual]);
    $this->viewdiasfal='creatediasfal';

}
public function desactdiasfal(){
    session()->forget('a5');
}
    public function edit($id,$nom){
        $this->reset();
        $sql = "SELECT * FROM tb_percepciones_laborales WHERE id_empleado=?";
        $perce= DB::select($sql,array($id));
        $sql = "SELECT * FROM tb_deducciones WHERE id_empleado=?";
        $deduc= DB::select($sql,array($id));
        
        foreach($perce as $per){
            $this->id_per=$per->id_per;
            $this->id_empleadop=$per->id_empleado;
            $this->salario_ordinario=$per->salario_ordinario;
            $this->bonificacion_productividad=$per->bonificacion_productividad;
            $this->bonificacion_mensual=$per->bonificacion_mensual;
        }
       
        session(['nomb' => $nom]);
        $this->a='1';
        foreach($deduc as $deducc){
            $this->id_deducciones=$deducc->id_deducciones;
            $this->id_empleadod=$deducc->id_empleado;
            $this->iggs_laboral=$deducc->iggs_laboral;
           $this->isr=$deducc->isr;
           $this->descuentos_judiciales=$deducc->descuentos_judiciales;
        }
        $this->a2='1';
        $anioactual=date('Y');
        $mesactual=date('m');
        $sql = "SELECT * FROM tb_dias_descuento WHERE id_percepcion=? and MONTH(fecha_registro)=? YEAR(fecha_registro)=?";
        $diasfal= DB::select($sql,array($this->id_per,$mesactual,$anioactual));

        if($diasfal!=null){
            session(['updiasfal' => 'Edito Correctamente.']);
            foreach($diasfal as $diasfa)
            {
                $this->id_dia_falta =$diasfa->id_dia_falta;
                $this->dias_faltantes =$diasfa->dias_faltantes;
                $this->id_percepcionp =$diasfa->id_percepcion;
                $this->id_mes_descuento =$diasfa->id_mes_descuento;
                $this->observacion =$diasfa->observacion;
                $this->fecha_registro =$diasfa->fecha_registro;
                $this->monto_descuento =$diasfa->monto_descuento;
                
            }
            
        }
        else{
            session()->forget('a5');
        }
       // session(['editard' => '1']);
    }

}
