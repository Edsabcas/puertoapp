<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\DB;

class TpropinaComponent extends Component
{
    public $descripcion,$monto_inicial,$monto_final,$monto,$estado,$fecha_update,$view,$id_propina;
    public function render()
    {
        $sql = "SELECT * FROM tb_propinas";
        $propinas= DB::select($sql);
        return view('livewire.tpropina-component',compact('propinas'));
    }

    public function crearpro(){
        $this->descripcion='Q. '.$this->monto_inicial.' - Q.'.$this->monto_final;
        if($this->validate([
                    'monto_inicial' => 'required',
                    'monto_final' => 'required',
                    'monto' => 'required',
                    'estado' => 'required',
                ])==false){
                    $mensaje="no encontrado";
                session(['message' => 'no encontrado']);
                    return  back()->withErrors(['mensaje'=>'Validar el input vacio']);
                }else{
          
              $aa=DB::table('tb_propinas')->insert(
                ['descripcion' => $this->descripcion,
                 'monto_inicial' => $this->monto_inicial,
                 'monto_final' =>  $this->monto_final,
                 'monto' => $this->monto,
                 'estado' => $this->estado,
                 'fecha_update' => date('Y-m-d H:i:s')]
                );
                        if($aa)
                             {
                                session()->forget('var'); 
                                session(['var' => ' Asignadas Correctamente.']);
                                $this->reset();
                            }
                        else{
                                session(['error' => 'validar']);
                            }
            }
        }
        public function edit($id){
            $sql = "SELECT * FROM tb_propinas WHERE id_propina=?";
            $val1= DB::select($sql,array($id));
            foreach($val1 as $val){
                $this->id_propina=$val->id_propina;
                $this->descripcion=$val->descripcion;
                $this->monto_inicial=$val->monto_inicial;
                $this->monto_final=$val->monto_final;
                $this->monto=$val->monto;
                $this->estado=$val->estado;
                $this->fecha_update=$val->fecha_update;
    
            }
            $this->view = 'edit';
        }
        public function actualizaremp(){
        
            if($this->validate([
                'monto_inicial' => 'required',
                'monto_final' => 'required',
                'monto' => 'required',
                'estado' => 'required',
                ])==false){
                $mensaje="no encontrado";
               session(['message' => 'no encontrado']);
                return  back()->withErrors(['mensaje'=>'Validar el input vacio']);
            }else{
                $this->descripcion='Q. '.$this->monto_inicial.' - Q.'.$this->monto_final;
             if( DB::table('tb_propinas')
             ->where('id_propina', $this->id_propina)
             ->update(['descripcion' => $this->descripcion,
             'monto_inicial' => $this->monto_inicial,
             'monto_final'=>  $this->monto_final,
             'monto'=> $this->monto,
             'estado'=> $this->estado,
             'fecha_update'=> date('Y-m-d H:i:s')
          ])){
            session()->forget('edit'); 
            session(['edit' => 'Descuento Editas Correctamente.']);
            $this->reset();
             }
          }
        
        }
        public function eliminarus($id){

            DB::beginTransaction();
            if(DB::table('tb_propinas')->where('id_propina', '=', $id)->delete()){
               
                DB::commit();
                session()->forget('delete1'); 
                session(['delete1' => 'si']);
                $this->reset();
            }else{
    
                DB::rollback();
                session(['error' => 'validar']);
            }
        }
        public function cancelar() {
           
        }
    
}

