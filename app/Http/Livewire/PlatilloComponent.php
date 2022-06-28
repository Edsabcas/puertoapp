<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\DB;
use Livewire\WithFileUploads;

class PlatilloComponent extends Component
{
    use WithFileUploads;
    public $platillobus,$pla,$TITULO_PLATILLO,$DESCRIPCION_PLATILLO,$FOTO_PLATILLO,$ESTADO,$ID_CATEGORIA,$COSTO_PLATILLO,$FOTO_PLATILLO1,$a,$img,$ID_PLATILLO,$FECHA_CREACION;
    public function render()
    {
        if($this->pla!=null  and $this->pla!=""){
            $sql = "SELECT * FROM tb_categoria_platillo where ESTADO=1";
            $categorias= DB::select($sql);
            $sql = "SELECT * FROM tb_platillos WHERE eliminado=0 and TITULO_PLATILLO like '%$this->platillobus%'";
            $platillos= DB::select($sql);
        }else{
            $sql = "SELECT * FROM tb_categoria_platillo where ESTADO=1";
            $categorias= DB::select($sql);
            $sql = "SELECT * FROM tb_platillos WHERE eliminado=0";
            $platillos= DB::select($sql);
        }
       
        return view('livewire.platillo-component',compact('categorias','platillos'));
    }
    public function nuevo(){
        $this->reset();
        session()->forget('passup'); 
        session()->forget('usuario1'); 
    }
    public function buscar(){
        
        $this->pla=$this->platillobus;

    }
    public function guardarplatillo(){
        if($this->validate([
            'TITULO_PLATILLO' => 'required',
            'DESCRIPCION_PLATILLO' => 'required',
            'ESTADO' => 'required',
            'ID_CATEGORIA'=>'required',
            'COSTO_PLATILLO'=>'required',
            ])==false){
            $mensaje="no encontrado";
           session(['message' => 'no encontrado']);
            return  back()->withErrors(['mensaje'=>'Validar el input vacio']);
        }else{
            $nombreimagen="";
            if($this->FOTO_PLATILLO!=null){
              //  $mensaje="no encontrado";
               //session(['message' => 'no encontradso']);
                //return  back()->withErrors(['mensaje'=>'Validar el input vacio']);
                $nombreimagen = "img".time().".".$this->FOTO_PLATILLO->getClientOriginalExtension();
                $this->img=$this->TITULO_PLATILLO.'_'.$nombreimagen;
                $this->FOTO_PLATILLO->storeAS('public/imagen/platillos/', $this->img,'public_up');
            }

                    DB::beginTransaction();
                    if( DB::table('tb_platillos')->insert(
                        ['TITULO_PLATILLO' => $this->TITULO_PLATILLO,
                         'DESCRIPCION_PLATILLO' => $this->DESCRIPCION_PLATILLO,
                         'FOTO_PLATILLO'=> $this->img,
                         'ESTADO'=> $this->ESTADO,
                         'ID_CATEGORIA'=> $this->ID_CATEGORIA,
                         'FECHA_CREACION'=>date('Y-m-d H:i:s'),
                         'COSTO_PLATILLO'=> $this->COSTO_PLATILLO,
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
    public function elimiarPlatillo($id){
        DB::beginTransaction();
        if(DB::table('tb_platillos')
        ->where('ID_PLATILLO', $id)
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
        
        //$this->reset();
        $sql = "SELECT * FROM tb_platillos WHERE ID_PLATILLO=?";
        $categoria= DB::select($sql,array($id));
        foreach($categoria as $cat){
            $this->ID_PLATILLO=$cat->ID_PLATILLO;
            $this->ID_CATEGORIA=$cat->ID_CATEGORIA;
            $this->TITULO_PLATILLO=$cat->TITULO_PLATILLO;
            $this->DESCRIPCION_PLATILLO=$cat->DESCRIPCION_PLATILLO;
            $this->FOTO_PLATILLO1=$cat->FOTO_PLATILLO;
            $this->FOTO_PLATILLO=$cat->FOTO_PLATILLO;
            $this->ESTADO=$cat->ESTADO;
            $this->FECHA_CREACION=$cat->FECHA_CREACION;
            $this->COSTO_PLATILLO=$cat->COSTO_PLATILLO;
          //  $this->cobro_efectuado=$des->cobro_efectuado;
        }
       // session(['nomb' => $nom]);
        $sql = "SELECT * FROM tb_categoria_platillo WHERE ID_CATEGORIA=?";
        $cat= DB::select($sql,array($this->ID_CATEGORIA));
        foreach($cat as $ca){

            session(['titulocat' => $ca->TITULO]); 
        }
        //session(['nomb' => $nom]);
        $this->a='1';
       // session(['editard' => '1']);

    }
    function updatePlatillo(){
        if($this->FOTO_PLATILLO1==$this->FOTO_PLATILLO){
            $this->img=$this->FOTO_PLATILLO;
        }else{
            if($this->FOTO_PLATILLO!=null){
                //  $mensaje="no encontrado";
                 //session(['message' => 'no encontradso']);
                  //return  back()->withErrors(['mensaje'=>'Validar el input vacio']);
                  $nombreimagen = "img".time().".".$this->FOTO_PLATILLO->getClientOriginalExtension();
                  $this->img=$this->TITULO_PLATILLO.'_'.$nombreimagen;
                  $this->FOTO_PLATILLO->storeAS('public/imagen/platillos/', $this->img,'public_up');
              }
        }
        if($this->validate([
            'TITULO_PLATILLO' => 'required',
            'DESCRIPCION_PLATILLO' => 'required',
            'ESTADO' => 'required',
            'COSTO_PLATILLO'=>'required',
            'ID_CATEGORIA'=>'required',
            ])==false){
            $mensaje="no encontrado";
           session(['message' => 'no encontradso']);
            return  back()->withErrors(['mensaje'=>'Validar el input vacio']);
        }else{
         //$this->ima = $nombreimagen;
         DB::beginTransaction();
             if(DB::table('tb_platillos')
             ->where('ID_PLATILLO', $this->ID_PLATILLO)
             ->update( 
                 ['TITULO_PLATILLO' => $this->TITULO_PLATILLO,
                  'DESCRIPCION_PLATILLO' => $this->DESCRIPCION_PLATILLO,
                  'FOTO_PLATILLO'=> $this->img,
                  'ESTADO'=> $this->ESTADO,
                  'COSTO_PLATILLO'=> $this->COSTO_PLATILLO,
                  'ID_CATEGORIA'=> $this->ID_CATEGORIA,
                  'FECHA_CREACION'=>date('Y-m-d H:i:s'),
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
