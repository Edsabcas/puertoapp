<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\DB;
use Livewire\WithFileUploads;

class ValidacionpagoComponent extends Component
{
    public $viewrangofecha='createranfecha';
    use WithFileUploads;
    public $p_laborado_inicio,$p_laborado_fin,$id_empleado;
    public $a,$mostrar1,$a0=1,$Norecibo;
    public $id_descuentod,$descripcion,$id_mes_descuentod,$montod,$cobro_efectuado;
    public $id_deducciones, $id_empleadod, $iggs_laboral, $isr, $descuentos_judiciales,$otros2,$fecha_ingreso;
    public $id_per, $id_empleadop, $salario_ordinario, $bonificacion_mensual, $bonificacion_productividad, $fecha_asignacion;
    public $id_dia_falta,$dias_faltantes,$id_percepcionp,$id_mes_descuento,$observacion,$fecha_registro,$monto_descuento;
    public $nomcompleto, $totalper,$totaldedu,$totalrecibir;
    public $idE,$NoEmpleado,$Primer_Nombre,$Segundo_Nombre,$Primer_Apellido,$Segundo_Apellido,$DPI,$Puesto,$Estado,$Fecha_ingreso,$Correo;
    public  $idmes,$descripcionmes,$dia,$boleta,$fileBoleta,$img,$photo,$ru;
    public $id_validacion_mes,$id_empleadov,$id_mes_pagp,$total_a_recibir,$ruta_cheque,$estado_impresion,$estado_envio,$fecha_registrotbv,$anio_boleta_mensual;
    public function render()
    {
        $fe=date("m");
        $anio=date("Y");
        $sql = "SELECT id,NoEmpleado,Primer_Nombre,Primer_Apellido,Estado FROM tb_empleados WHERE Asignacion='2' OR Asignacion='3'";
        $empleados=DB::select($sql);
        $sql = "SELECT * FROM tb_validacion_recibo_mensual WHERE id_mes_pagp=$fe and anio_boleta_mensual=$anio";
        $tb_boleta_creada_mes=DB::select($sql);
        return view('livewire.validacionpago-component',compact('empleados','tb_boleta_creada_mes'));
    }
    public function cargaEmpleados()
    {
        if($this->validate([
            'p_laborado_inicio' => 'required',
            'p_laborado_fin' => 'required',
            ])==false){
            $mensaje="no encontrado";
           session(['message' => 'no encontrado']);
            return  back()->withErrors(['mensaje'=>'Validar el input vacio']);
        }else{
           
          unset($this->a0);
        $this->mostrar1=1;

        }
    }
    public function validarcargab(){
     
    }

    public function mostrarboton2(){
        if($this->validate([
            'id_empleado' => 'required',
            ])==false){
            $mensaje="no encontrado";
           session(['message' => 'no encontrado']);
            return  back()->withErrors(['mensaje'=>'Validar el input vacio']);
        }else{
            unset($this->id_per);
            unset($this->a0);
            session(['mostrar2' => 'mostrar']);

        }
    }
    public function cargardeper(){
        session()->forget('error0');
        session()->forget('error');
        if($this->validate([
            'id_empleado' => 'required',
            ])==false){
            $mensaje="no encontrado";
           session(['message' => 'no encontrado']);
            return  back()->withErrors(['mensaje'=>'Validar el input vacio']);
        }else{

            session()->forget('mostrar2');
            unset($this->a0);
            
            $sql = "SELECT * FROM tb_percepciones_laborales WHERE id_empleado=?";
        $perce= DB::select($sql,array($this->id_empleado));
        $sql = "SELECT * FROM tb_deducciones WHERE id_empleado=?";
        $deduc= DB::select($sql,array($this->id_empleado));
        
        foreach($perce as $per){
            $this->id_per=$per->id_per;
            $this->id_empleadop=$per->id_empleado;
            $this->salario_ordinario=$per->salario_ordinario;
            $this->bonificacion_productividad=$per->bonificacion_productividad;
            $this->bonificacion_mensual=$per->bonificacion_mensual;
        }
       // $this->a='1';
        foreach($deduc as $deducc){
            $this->id_deducciones=$deducc->id_deducciones;
            $this->id_empleadod=$deducc->id_empleado;
            $this->iggs_laboral=$deducc->iggs_laboral;
           $this->isr=$deducc->isr;
           $this->descuentos_judiciales=$deducc->descuentos_judiciales;
        }
      //  $this->a2='1';
       // $mesactual=date('m');
        $sepparator = '-';
        $this->dia = explode($sepparator, $this->p_laborado_inicio);
        $sql = "SELECT * FROM tb_dias_descuento WHERE id_percepcion=? and MONTH(fecha_registro)=?";
        $diasfal= DB::select($sql,array($this->id_per,$this->dia[1]));

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
        $sql = "SELECT * FROM tb_descuentos WHERE id_empleado=? and MONTH(fecha_ingreso)=?";
        $descuentos= DB::select($sql,array($this->id_empleado,$this->dia[1]));
        if($descuentos!=null){
            session(['updiasfal' => 'Edito Correctamente.']);
            $this->montod=0;
            foreach($descuentos as $descuento)
            {
                $this->id_descuentod=$descuento->id_descuento;
                $this->id_empleado=$descuento->id_empleado;
                $this->descripcion=$descuento->descripcion;
                $this->id_mes_descuentod=$descuento->id_mes_descuento;
                $this->montod=$this->montod+$descuento->monto;
                $this->fecha_ingreso=$descuento->fecha_ingreso;
                $this->cobro_efectuado=$descuento->cobro_efectuado;
                
            }
        }
        $sql = "SELECT * FROM tb_empleados WHERE id=?";
        $empleado_b= DB::select($sql,array($this->id_empleado));
        foreach($empleado_b as $empleado)
        {
            $this->NoEmpleado=$empleado->NoEmpleado;
            $this->Primer_Nombre=$empleado->Primer_Nombre;
           $this->Segundo_Nombre=$empleado->Segundo_Nombre;
           $this->Primer_Apellido=$empleado->Primer_Apellido;
            $this->Segundo_Apellido=$empleado->Segundo_Apellido;
            $this->DPI=$empleado->DPI;
            $this->Puesto=$empleado->Puesto;
            $this->Estado=$empleado->Estado;
           $this->Fecha_ingreso=$empleado->Fecha_ingreso;
             $this->Correo=$empleado->Correo;
            
        }

        $sql = "SELECT * FROM tb_meses WHERE id=?";
        $mess= DB::select($sql,array($this->dia[1]));
        foreach($mess as $me){

            $this->idmes=$me->id;
            $this->descripcionmes=$me->descripcion;
        }
        $sepparator = '-';

        $this->dia = explode($sepparator, $this->p_laborado_fin);
        $this->Norecibo = "0".$this->dia[1]."-".$this->NoEmpleado."-".$this->dia[0];
        $this->nomcompleto=$this->Primer_Nombre." ".$this->Segundo_Nombre." ".$this->Primer_Apellido." ". $this->Segundo_Apellido;
        $this->totalper=$this->salario_ordinario+$this->bonificacion_productividad+$this->bonificacion_mensual;
        $this->totaldedu=$this->iggs_laboral+$this->isr+$this->descuentos_judiciales+$this->monto_descuento+$this->montod;
        $this->totalrecibir=$this->totalper-$this->totaldedu;
       // session(['editard' => '1']);
        }
        $sql = "SELECT * FROM tb_validacion_recibo_mensual WHERE id_empleado=? and id_mes_pagp=? and anio_boleta_mensual=?";
        $boletagenerada= DB::select($sql,array($this->id_empleado,$this->dia[1],$this->dia[0]));
        if($boletagenerada!=null){
            foreach($boletagenerada as $boletagenerad){
                $this->id_validacion_mes=$boletagenerad->id_validacion_mes;
                $this->id_empleadov=$boletagenerad->id_empleado;
                $this->id_mes_pagp=$boletagenerad->id_mes_pagp;
                $this->total_a_recibir=$boletagenerad->total_a_recibir;
                $this->ruta_cheque=$boletagenerad->ruta_cheque;
                $this->estado_impresion=$boletagenerad->estado_impresion;
                $this->estado_envio=$boletagenerad->estado_envio;
                $this->fecha_registrotbv=$boletagenerad->fecha_registro;
                $this->anio_boleta_mensual=$boletagenerad->anio_boleta_mensual;          
    
            }
          
        }  else{
            unset($this->id_validacion_mes);
            unset($this->id_empleadov);
            unset($this->id_mes_pagp);
            unset($this->total_a_recibir);
            unset($this->ruta_cheque);
            unset($this->estado_impresion);
            unset($this->estado_envio);
            unset($this->fecha_registrotbv);
            unset($this->anio_boleta_mensual);

        }


    }
     function creartb_validacion_boleta(){
        if($this->validate([
            'photo' => 'required',
            ])==false){
            $mensaje="no encontrado";
           session(['message' => 'no encontrado']);
            return  back()->withErrors(['mensaje'=>'Validar el input vacio']);
        }else{
        $this->boleta=1;
        $val="";
         //$this->ima = $nombreimagen;
         DB::beginTransaction();
         $nombreimagen = "img".time().".".$this->photo->getClientOriginalExtension();
         $this->img=$this->Norecibo.'_'.$nombreimagen;
         $this->ru=$this->dia[0].'/'.$this->dia[1];
             if(DB::table('tb_validacion_recibo_mensual')->insert(
                 ['id_empleado' => $this->id_empleado,
                  'id_mes_pagp' => $this->dia[1],
                  'total_a_recibir'=> $this->totalrecibir,
                  'ruta_cheque'=> $this->img,
                  'estado_impresion'=> '0',
                  'estado_envio'=> '0',
                  'fecha_registro'=>date('Y-m-d H:i:s'),
                  'anio_boleta_mensual'=> $this->dia[0],
               ]))
               {
                 DB::commit();
             $this->photo->storeAS('public/imagen/boleta/'.$this->ru, $this->img,'public_up');
                 session()->forget('var'); 
                 session(['var' => ' Validacion ingresada Correctamente.']);
                 $this->reset(); 
               }
             else{
                 DB::rollback();
                 session(['error' => 'validar']);
             }  

   
        }
    }

    function editartb_validacion_boleta(){
        if($this->validate([
            'photo' => 'required',
            ])==false){
            $mensaje="no encontrado";
           session(['message' => 'no encontradso']);
            return  back()->withErrors(['mensaje'=>'Validar el input vacio']);
        }else{
        $this->boleta=1;

         //$this->ima = $nombreimagen;
         DB::beginTransaction();
         $nombreimagen = "img".time().".".$this->photo->getClientOriginalExtension();
         $this->img=$this->Norecibo.'_'.$nombreimagen;
         $this->ru=$this->dia[0].'/'.$this->dia[1];
             if(DB::table('tb_validacion_recibo_mensual')
             ->where('id_validacion_mes', $this->id_validacion_mes)
             ->update( 
                 ['id_empleado' => $this->id_empleado,
                  'id_mes_pagp' => $this->dia[1],
                  'total_a_recibir'=> $this->totalrecibir,
                  'ruta_cheque'=> $this->img,
                  'estado_impresion'=> '0',
                  'estado_envio'=> '0',
                  'fecha_registro'=>date('Y-m-d H:i:s'),
                  'anio_boleta_mensual'=> $this->dia[0],
               ]))
               {
                 DB::commit();
             $this->photo->storeAS('public/imagen/boleta/'.$this->ru, $this->img,'public_up');
                 session()->forget('var'); 
                 session(['var' => ' Validacion ingresada Correctamente.']);
                 $this->reset(); 
               }
             else{
                 DB::rollback();
                 session(['error' => 'validar']);
             }  
        }
    }
}
