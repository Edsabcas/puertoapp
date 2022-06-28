<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\DB;
use Livewire\WithFileUploads;
class CategoriaComponent extends Component
{
    use WithFileUploads;
    public $TITULO,$DESCRIPCION,$FOTO_CATEGORIA,$FOTO_CATEGORIA1,$ESTADO,$ID_AREA,$ID_CATEGORIA,$a,$img,$FECHA_CREACION;
    public $categoriabus,$ca;
    public function render()
    {
        if($this->ca!=null and $this->ca!=""){
            $sql = "SELECT * FROM tb_areas";
            $areas= DB::select($sql);
            $sql = "SELECT * FROM tb_categoria_platillo where TITULO like '%$this->categoriabus%'";
            $categorias= DB::select($sql);
        }else{
            $sql = "SELECT * FROM tb_areas";
            $areas= DB::select($sql);
            $sql = "SELECT * FROM tb_categoria_platillo";
            $categorias= DB::select($sql);
        }
        
     
        return view('livewire.categoria-component',compact('areas','categorias'));
    }
    public function guardarCategoria(){
        if($this->validate([
            'TITULO' => 'required',
            'DESCRIPCION' => 'required',
            'ESTADO' => 'required',
            'ID_AREA'=>'required',
            ])==false){
            $mensaje="no encontrado";
           session(['message' => 'no encontrado']);
            return  back()->withErrors(['mensaje'=>'Validar el input vacio']);
        }else{
            $nombreimagen="";
            if($this->FOTO_CATEGORIA!=null){
              //  $mensaje="no encontrado";
               //session(['message' => 'no encontradso']);
                //return  back()->withErrors(['mensaje'=>'Validar el input vacio']);
                $nombreimagen = "img".time().".".$this->FOTO_CATEGORIA->getClientOriginalExtension();
                $this->img=$this->TITULO.'_'.$nombreimagen;
                $this->FOTO_CATEGORIA->storeAS('public/imagen/categoria/', $this->img,'public_up');
            }
                    DB::beginTransaction();
                    if( DB::table('tb_categoria_platillo')->insert(
                        ['TITULO' => $this->TITULO,
                         'DESCRIPCION' => $this->DESCRIPCION,
                         'FOTO_CATEGORIA'=>  $this->img,
                         'ESTADO'=> $this->ESTADO,
                         'ID_AREA'=> $this->ID_AREA,
                         'FECHA_CREACION'=>date('Y-m-d H:i:s')
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
    public function elimiarCategoria($id){

    
    }
    public function eliminarcat($id){
        $sql = "SELECT ID_CATEGORIA FROM tb_platillos WHERE ID_CATEGORIA=?";
        $catpla= DB::select($sql,array($id));

        if($catpla!=null){
            session(['errorllave' => 'validar']);
        }
        else{
            DB::beginTransaction();
            if(DB::table('tb_categoria_platillo')->where('ID_CATEGORIA', '=', $id)->delete()) {
                DB::commit();
                session()->forget('delete1'); 
                session(['delete1' => 'si']);
                $this->reset();
            }else{
    
                DB::rollback();
                session(['error' => 'validar']);
            }
        }

    }


    public function edit($id){
        
        $this->reset();
        $sql = "SELECT * FROM tb_categoria_platillo WHERE ID_CATEGORIA=?";
        $categoria= DB::select($sql,array($id));
        foreach($categoria as $cat){
            $this->ID_CATEGORIA=$cat->ID_CATEGORIA;
            $this->ID_AREA=$cat->ID_AREA;
            $this->TITULO=$cat->TITULO;
            $this->DESCRIPCION=$cat->DESCRIPCION;
            $this->FOTO_CATEGORIA=$cat->FOTO_CATEGORIA;
            $this->FOTO_CATEGORIA1=$cat->FOTO_CATEGORIA;
            $this->ESTADO=$cat->ESTADO;
            $this->FECHA_CREACION=$cat->FECHA_CREACION;
          //  $this->cobro_efectuado=$des->cobro_efectuado;
        }
       // session(['nomb' => $nom]);
        $sql = "SELECT * FROM tb_areas WHERE ID_AREA=?";
        $area= DB::select($sql,array($this->ID_AREA));
        foreach($area as $m){

            session(['tituloarea' => $m->TITUTO_AREA]); 
        }
        //session(['nomb' => $nom]);
        $this->a='1';
       // session(['editard' => '1']);

    }
    function updateCategoria(){
        if($this->FOTO_CATEGORIA==$this->FOTO_CATEGORIA1){
            $this->img=$this->FOTO_CATEGORIA;
        }else{
            if($this->FOTO_CATEGORIA!=null){
                //  $mensaje="no encontrado";
                 //session(['message' => 'no encontradso']);
                  //return  back()->withErrors(['mensaje'=>'Validar el input vacio']);
                  $nombreimagen = "img".time().".".$this->FOTO_CATEGORIA->getClientOriginalExtension();
                  $this->img=$this->TITULO.'_'.$nombreimagen;
                  $this->FOTO_CATEGORIA->storeAS('public/imagen/categoria/', $this->img,'public_up');
              }

        }

        if($this->validate([
            'TITULO' => 'required',
            'DESCRIPCION' => 'required',
            'ESTADO' => 'required',
            'ID_AREA'=>'required',
            ])==false){
            $mensaje="no encontrado";
           session(['message' => 'no encontradso']);
            return  back()->withErrors(['mensaje'=>'Validar el input vacio']);
        }else{
         //$this->ima = $nombreimagen;
         DB::beginTransaction();
             if(DB::table('tb_categoria_platillo')
             ->where('ID_CATEGORIA', $this->ID_CATEGORIA)
             ->update( 
                 ['TITULO' => $this->TITULO,
                  'DESCRIPCION' => $this->DESCRIPCION,
                  'FOTO_CATEGORIA'=> $this->img,
                  'ESTADO'=> $this->ESTADO,
                  'ID_AREA'=> $this->ID_AREA,
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
    public function nuevo(){
        $this->reset();
        session()->forget('tituloarea'); 
    }

    public function buscar(){
        
        $this->ca=$this->categoriabus;

    }


}
