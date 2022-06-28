<?php

namespace App\Http\Livewire;

use Livewire\Component;
use app\Models\Empleado;
use Livewire\WithPagination;
use Illuminate\Support\Facades\DB;

class EmpleadoComponent extends Component
{
    use withPagination;
    public $view='create';
    public $mensaje="";
    public $idE,$NoEmpleado,$Primer_Nombre,$Segundo_Nombre,$Primer_Apellido,$Segundo_Apellido,$DPI,$Puesto,$Estado,$Fecha_ingreso,$Correo;
    public function render()
    {
         $sql = "SELECT * FROM tb_empleados where estado=0";
         $empleados=DB::select($sql);
        return view('livewire.empleado-component',compact('empleados'));
    }
    public function delete($id){
        session()->forget('delete');
        session()->forget('id');
        session(['delete' => 'pregunta']);
        session(['id' => $id]);

    }
    public function destroy(){
        DB::table('tb_empleados')->where('id', '=', session('id'))->delete();
        session(['delete1' => 'si']);
    }
    public function save(){

            if($this->validate([
                'NoEmpleado' => 'required',
                'Primer_Nombre' => 'required',
                'Segundo_Nombre' => 'required',
                'Primer_Apellido' => 'required',
                'Segundo_Apellido' => 'required',
                'DPI' => 'required',
                'Puesto' => 'required',
                'Estado' => 'required',
                'Fecha_ingreso' => 'required',
                'Correo' => 'required',
            ])==false){
                $mensaje="no encontrado";
               session(['message' => 'no encontrado']);
                return  back()->withErrors(['mensaje'=>'Validar el input vacio']);

            }else{

                if(filter_var($this->Correo, FILTER_VALIDATE_EMAIL)) {
                    $sql = "SELECT * FROM tb_empleados WHERE NoEmpleado=?";
                    $val= DB::select($sql,array($this->NoEmpleado));    
     
                    if(empty($val)==null){
                     session(['var1' => 'existe']);
                    }
                    else{
                     $sql = "SELECT * FROM tb_empleados WHERE DPI=?";
                     $val1= DB::select($sql,array($this->DPI));    
                     if(empty($val1)==null){
                         session(['var2' => 'existe']);
                        }
                        else{
     
                         DB::table('tb_empleados')->insert(
                             ['NoEmpleado' => $this->NoEmpleado,
                              'Primer_Nombre' => $this->Primer_Nombre,
                              'Segundo_Nombre'=> $this->Segundo_Nombre,
                             'Primer_Apellido'=> $this->Primer_Apellido,
                             'Segundo_Apellido'=> $this->Segundo_Apellido,
                             'DPI'=> $this->DPI,
                             'Puesto'=> $this->Puesto,
                             'Estado'=> $this->Estado,
                             'Fecha_ingreso'=> $this->Fecha_ingreso,
                             'Correo'=> $this->Correo,]);
                             session(['var' => 'modificado']);
                             $this->reset();
     
                        }
     
                    }
                    
                }
                else{
                    session(['var3' => 'correo mal ingresado']);
                }

               

            }
      
    }
    public function edit($id){
        $this->idE=$id;
        $sql = "SELECT * FROM tb_empleados WHERE ID_EMPLEADO=?";
        $val1= DB::select($sql,array($id));
        foreach($val1 as $val){

            $this->NoEmpleado=$val->NoEmpleado;
            $this->Primer_Nombre=$val->Primer_Nombre;
           $this->Segundo_Nombre=$val->Segundo_Nombre;
           $this->Primer_Apellido=$val->Primer_Apellido;
            $this->Segundo_Apellido=$val->Segundo_Apellido;
            $this->DPI=$val->DPI;
            $this->Puesto=$val->Puesto;
            $this->Estado=$val->Estado;
           $this->Fecha_ingreso=$val->Fecha_ingreso;
             $this->Correo=$val->Correo;
        }
        $this->view = 'edit';
    }
    public function update(){

        if($this->validate([
            'NoEmpleado' => 'required',
            'Primer_Nombre' => 'required',
            'Segundo_Nombre' => 'required',
            'Primer_Apellido' => 'required',
            'Segundo_Apellido' => 'required',
            'DPI' => 'required',
            'Puesto' => 'required',
            'Estado' => 'required',
            'Fecha_ingreso' => 'required',
            'Correo' => 'required',
        ])==false){
            $mensaje="no encontrado";
           session(['message' => 'no encontrado']);
            return  back()->withErrors(['mensaje'=>'Validar el input vacio']);

        }else{

            if(filter_var($this->Correo, FILTER_VALIDATE_EMAIL)) {
                DB::beginTransaction();
                if(DB::table('tb_empleados')
                ->where('id', $this->idE)
                ->update(['NoEmpleado' => $this->NoEmpleado,
                'Primer_Nombre' => $this->Primer_Nombre,
                'Segundo_Nombre'=> $this->Segundo_Nombre,
               'Primer_Apellido'=> $this->Primer_Apellido,
               'Segundo_Apellido'=> $this->Segundo_Apellido,
               'DPI'=> $this->DPI,
               'Puesto'=> $this->Puesto,
               'Estado'=> $this->Estado,
               'Fecha_ingreso'=> $this->Fecha_ingreso,
               'Correo'=> $this->Correo,]) )
                  {
                    DB::commit();
                    session(['edit' => 'modificado']);
                    $this->reset();
                    $this->view='create';
                  }
                else{
                    DB::rollback();
                    session(['error' => 'validar']);
                } 

            }
            else{
                session(['var3' => 'correo mal ingresado']);
            }

           

        }
  
}

}
