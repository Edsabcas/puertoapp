<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\DB;
use Livewire\WithFileUploads;

class BebidaComponent extends Component
{
    use WithFileUploads;
    public $bebidabus,$beb, $COSTO_BEBIDA,$BOQUITAS,$tb_bebidas,$ID_CATEGORIA,$TITUTLO_BEBIDA,$DESCRIPCION_BEBIDA,$FOTO_BEBIDA,$FOTO_BEBIDA1,$ESTADO,$FECHA_CREACION,$a,$img,$ID_BEBIDA;
    public function render()
    {
        if($this->beb!=null and $this->beb!=""){
            $sql = "SELECT * FROM tb_categoria_platillo where ESTADO=1";
            $categorias= DB::select($sql);
            $sql = "SELECT * FROM tb_bebidas where eliminado=0 and TITUTLO_BEBIDA like '%$this->beb%'";
            $bebidas= DB::select($sql);
        }else{
            $sql = "SELECT * FROM tb_categoria_platillo where ESTADO=1";
            $categorias= DB::select($sql);
            $sql = "SELECT * FROM tb_bebidas where eliminado=0";
            $bebidas= DB::select($sql);
        }

        return view('livewire.bebida-component',compact('categorias','bebidas'));
    }
    public function nuevo(){
        $this->reset();
        session()->forget('passup'); 
        session()->forget('usuario1'); 
    }
    public function buscar(){
        
        $this->beb=$this->bebidabus;

    }
    public function guardarbebida(){
        if($this->validate([
            'TITUTLO_BEBIDA' => 'required',
            'DESCRIPCION_BEBIDA' => 'required',
            'ESTADO' => 'required',
            'ID_CATEGORIA'=>'required',
            'COSTO_BEBIDA'=>'required',
            'BOQUITAS'=>'required',
            ])==false){
            $mensaje="no encontrado";
           session(['message' => 'no encontrado']);
            return  back()->withErrors(['mensaje'=>'Validar el input vacio']);
        }else{

            $nombreimagen="";
            if($this->FOTO_BEBIDA!=null){
              //  $mensaje="no encontrado";
               //session(['message' => 'no encontradso']);
                //return  back()->withErrors(['mensaje'=>'Validar el input vacio']);



                $nombreimagen = "img".time().".".$this->FOTO_BEBIDA->getClientOriginalExtension();
                $this->img=$this->TITUTLO_BEBIDA.'_'.$nombreimagen;
                $this->FOTO_BEBIDA->storeAS('public/imagen/bebidas/', $this->img,'public_up');

                
            }
                    DB::beginTransaction();
                    if( DB::table('tb_bebidas')->insert(
                        ['TITUTLO_BEBIDA' => $this->TITUTLO_BEBIDA,
                         'DESCRIPCION_BEBIDA' => $this->DESCRIPCION_BEBIDA,
                         'FOTO_BEBIDA'=> $this->img,
                         'ESTADO'=> $this->ESTADO,
                         'ID_CATEGORIA'=> $this->ID_CATEGORIA,
                         'FECHA_CREACION'=>date('Y-m-d H:i:s'),
                         'COSTO_BEBIDA'=> $this->COSTO_BEBIDA,
                         'boquitas'=> $this->BOQUITAS,
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
    }
    public function eliminarbebida($id){
        DB::beginTransaction();
        if(DB::table('tb_bebidas')
        ->where('ID_BEBIDA', $id)
        ->update( 
            ['eliminado'=> '1',
             'FECHA_ELIMINADO'=>date('Y-m-d H:i:s'),
          ])) {
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
        $sql = "SELECT * FROM tb_bebidas WHERE ID_BEBIDA=?";
        $categoria= DB::select($sql,array($id));
        foreach($categoria as $cat){
            $this->ID_BEBIDA=$cat->ID_BEBIDA;
            $this->ID_CATEGORIA=$cat->ID_CATEGORIA;
            $this->TITUTLO_BEBIDA=$cat->TITUTLO_BEBIDA;
            $this->DESCRIPCION_BEBIDA=$cat->DESCRIPCION_BEBIDA;
            $this->FOTO_BEBIDA=$cat->FOTO_BEBIDA;
            $this->FOTO_BEBIDA1=$cat->FOTO_BEBIDA;
            $this->ESTADO=$cat->ESTADO;
            $this->FECHA_CREACION=$cat->FECHA_CREACION;
            $this->COSTO_BEBIDA=$cat->COSTO_BEBIDA;
            $this->BOQUITAS=$cat->boquitas;
          //  $this->cobro_efectuado=$des->cobro_efectuado;
        }
       // session(['nomb' => $nom]);
        //session(['nomb' => $nom]);
        $this->a='1';
       // session(['editard' => '1']);

    }
    function updateBebida(){
        if($this->FOTO_BEBIDA==$this->FOTO_BEBIDA1){
            $this->img=$this->FOTO_BEBIDA;
        }else{
            if($this->FOTO_BEBIDA!=null){
                //  $mensaje="no encontrado";
                 //session(['message' => 'no encontradso']);
                  //return  back()->withErrors(['mensaje'=>'Validar el input vacio']);
                  $nombreimagen = "img".time().".".$this->FOTO_BEBIDA->getClientOriginalExtension();
                  $this->img=$this->TITUTLO_BEBIDA.'_'.$nombreimagen;
                  $this->FOTO_BEBIDA->storeAS('public/imagen/bebidas/', $this->img,'public_up');
              }
        }
        if($this->validate([
            'TITUTLO_BEBIDA' => 'required',
            'DESCRIPCION_BEBIDA' => 'required',
            'ESTADO' => 'required',
            'COSTO_BEBIDA'=>'required',
            'ID_CATEGORIA'=>'required',
            'BOQUITAS'=>'required',
            ])==false){
            $mensaje="no encontrado";
           session(['message' => 'no encontradso']);
            return  back()->withErrors(['mensaje'=>'Validar el input vacio']);
        }else{
         //$this->ima = $nombreimagen;
         DB::beginTransaction();
             if(DB::table('tb_bebidas')
             ->where('ID_BEBIDA', $this->ID_BEBIDA)
             ->update( 
                 ['TITUTLO_BEBIDA' => $this->TITUTLO_BEBIDA,
                  'DESCRIPCION_BEBIDA' => $this->DESCRIPCION_BEBIDA,
                  'FOTO_BEBIDA'=> $this->img,
                  'ESTADO'=> $this->ESTADO,
                  'COSTO_BEBIDA'=> $this->COSTO_BEBIDA,
                  'ID_CATEGORIA'=> $this->ID_CATEGORIA,
                  'FECHA_CREACION'=>date('Y-m-d H:i:s'),
                  'boquitas'=> $this->BOQUITAS,
               ]))
               {
                 DB::commit();
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
    public function cancelar() {
    }
}
