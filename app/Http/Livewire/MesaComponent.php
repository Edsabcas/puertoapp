<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\DB;
use Livewire\WithFileUploads;

class MesaComponent extends Component
{
    use WithFileUploads;
    public $ID_MESA,$NO_MESA,$UBICACION,$ESTADO,$FECHA_REGISTRO,$FECHA_CREACION,$a,$img;
    public function render()
    {
        $sql = "SELECT * FROM tb_mesas";
        $mesas= DB::select($sql);
        return view('livewire.mesa-component',compact('mesas'));
    }
    public function guardarmesa(){
        if($this->validate([
            'NO_MESA' => 'required',
            'UBICACION' => 'required',
            'ESTADO' => 'required',
            ])==false){
            $mensaje="no encontrado";
           session(['message' => 'no encontrado']);
            return  back()->withErrors(['mensaje'=>'Validar el input vacio']);
        }else{
            $sql = "SELECT * FROM tb_mesas WHERE NO_MESA=?";
            $val= DB::select($sql,array($this->NO_MESA));    
            if(empty($val)){
                DB::beginTransaction();
                if( DB::table('tb_mesas')->insert(
                    ['NO_MESA' => $this->NO_MESA,
                     'UBICACION' => $this->UBICACION,
                     'ESTADO'=> $this->ESTADO,
                     'FECHA_REGISTRO'=>date('Y-m-d H:i:s')
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
            }else{
                session(['var1' => 'existe']);  
            }
           

        }
    }

    public function eliminarMesa($id){
        DB::beginTransaction();
        if(DB::table('tb_mesas')->where('ID_MESA', '=', $id)->delete()) {
            DB::commit();
            session()->forget('delete1'); 
            session(['delete1' => 'si']);
            $this->reset();
        }else{

            DB::rollback();
            session(['error' => 'validar']);
        }
    }

    public function edit($id){
        $this->reset();
        $sql = "SELECT * FROM tb_mesas WHERE ID_MESA=?";
        $descuento= DB::select($sql,array($id));
        foreach($descuento as $des){
            $this->ID_MESA=$des->ID_MESA;
            $this->NO_MESA=$des->NO_MESA;
            $this->ESTADO=$des->ESTADO;
            $this->FECHA_REGISTRO=$des->FECHA_REGISTRO;
            $this->UBICACION=$des->UBICACION;
        }
        //session(['nomb' => $nom]);
        $this->a='1';
       // session(['editard' => '1']);

    }
    public function actualizazmesa(){
        
        if($this->validate([
            'NO_MESA' => 'required',
            'ESTADO' => 'required',
            'UBICACION' => 'required',
            ])==false){
            $mensaje="no encontrado";
           session(['message' => 'no encontrado']);
            return  back()->withErrors(['mensaje'=>'Validar el input vacio']);
        }else{
    
         if( DB::table('tb_mesas')
         ->where('ID_MESA', $this->ID_MESA)
         ->update(['ESTADO' => $this->ESTADO,
         'UBICACION' => $this->UBICACION,
         'NO_MESA'=> $this->NO_MESA,
         'FECHA_REGISTRO'=>date('Y-m-d H:i:s'),
      ])){
        session()->forget('edit'); 
        session(['edit' => 'mesa Edita Correctamente.']);
        $this->reset();
         }
         else{
            session()->forget('error'); 
            session(['error' => 'mesa Edita Correctamente.']);
         }
      }
    
    }
    public function cancelar() {}
}
