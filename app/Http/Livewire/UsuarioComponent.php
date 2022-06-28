<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class UsuarioComponent extends Component
{
    public $ID_EMPLEADO,$NOMBRES,$APELLIDOS,$DPI,$EDAD_ACTUAL,$FECHA_NACIMIENTO,$pasup,$estado,$view;
    public $idus,$name,$email,$password,$foto,$cambiopass,$created_at,$rol,$usurioacc,$val;
    public $updateMode,$rsi,$rno,$iddel,$usuariobus,$usus;

    protected $listeners  = ['asd' => 'eliminarus'];

    public function render()
    {

        if($this->usus!=null and $this->usus!=""){
            $sql = "SELECT * FROM tipo_rols";
            $roles= DB::select($sql);
            $sql = "SELECT * FROM tb_empleados where NOMBRES like '%$this->usus%'";
            $empleados= DB::select($sql);
            $sql = "SELECT * FROM users where name like  '%$this->usus%'";
            $users= DB::select($sql);
            $sql = "SELECT * FROM rol_users1s";
            $rol_users= DB::select($sql);
        }else{
            $sql = "SELECT * FROM tipo_rols";
            $roles= DB::select($sql);
            $sql = "SELECT * FROM tb_empleados";
            $empleados= DB::select($sql);
            $sql = "SELECT * FROM users";
            $users= DB::select($sql);
            $sql = "SELECT * FROM rol_users1s";
            $rol_users= DB::select($sql);
        }
     
        return view('livewire.usuario-component',compact('roles','empleados','users','rol_users'));
    }
    public function createUsuario(){
        if($this->validate([
            'NOMBRES' => 'required',
            'APELLIDOS' => 'required',
            'DPI' => 'required',
            'EDAD_ACTUAL' => 'required',
            'FECHA_NACIMIENTO' => 'required',
            'usurioacc' => 'required',
            'password' => 'required',
            'rol' => 'required',
        ])==false){
            $mensaje="no encontrado";
           session(['message' => 'no encontrado']);
            return  back()->withErrors(['mensaje'=>'Validar el input vacio']);
        }else{
                 $this->email=$this->usurioacc."@elpuerto.com";
                 $sql = "SELECT * FROM tb_empleados WHERE DPI=?";
                 $val1= DB::select($sql,array($this->DPI));   
                 $sql = "SELECT * FROM users WHERE email=?";
                 $us= DB::select($sql,array($this->email));   
                 if(empty($val1)==null && empty($us)==null){
                     session(['var2' => 'existe']);
                    }
                    else{
                        DB::beginTransaction();
                       
                        if( DB::table('tb_empleados')->insert(
                            ['NOMBRES' => $this->NOMBRES,
                             'APELLIDOS' => $this->APELLIDOS,
                             'DPI'=> $this->DPI,
                            'EDAD_ACTUAL'=> $this->EDAD_ACTUAL,
                            'FECHA_NACIMIENTO'=> $this->FECHA_NACIMIENTO,
                            'email'=> $this->email,
                            'estado'=> $this->estado,
                          ])  &&  User::create(['name'=>$this->usurioacc,'email'=>$this->email, 'password'=>$this->password]))
                          {

                            DB::commit();
                            $this->asigrol($this->email);
                           // session()->forget('var'); 
                            //session(['var' => ' Asignadas Correctamente.']);
                         //   $this->reset();
                            
                          }
                        else{
                            DB::rollback();
                            session(['error' => 'validar']);
                        }
                    }
        }
    }
    public function edit($id){
        $sql = "SELECT * FROM tb_empleados WHERE ID_EMPLEADO=?";
        $val1= DB::select($sql,array($id));
        foreach($val1 as $val){
            $this->ID_EMPLEADO=$val->ID_EMPLEADO;
            $this->NOMBRES=$val->NOMBRES;
            $this->APELLIDOS=$val->APELLIDOS;
            $this->DPI=$val->DPI;
            $this->EDAD_ACTUAL=$val->EDAD_ACTUAL;
            $this->FECHA_NACIMIENTO=$val->FECHA_NACIMIENTO;
            $this->email=$val->email;
            $this->estado=$val->estado;

        }
        if($this->email!=null){
            $sql = "SELECT * FROM users WHERE email=?";
            $datauser= DB::select($sql,array($this->email));
            foreach($datauser as $datause){
                $this->idus=$datause->id;
                $this->name=$datause->name;
                $this->usurioacc=$datause->name;
            }
          $datarols=DB::table('users')
          ->join('rol_users1s', function($join){
              $join->on('users.id','=','rol_users1s.id_user')
              ->where('rol_users1s.id_user','=',$this->idus);
          })
          ->join('tipo_rols','rol_users1s.id_tipo_rol','=','tipo_rols.id')
          ->select('tipo_rols.id','tipo_rols.descripcion')
          ->get();
            foreach($datarols as $datarol){
                $this->rol=$datarol->descripcion;
            }

        }
            session()->forget('usuario1'); 
            session(['usuario1' =>$this->rol]);
        $this->view = 'edit';
    }
    public function actualizaremp(){
        
        if($this->validate([
            'NOMBRES' => 'required',
            'APELLIDOS' => 'required',
            'DPI' => 'required',
            'EDAD_ACTUAL' => 'required',
            'FECHA_NACIMIENTO' => 'required',
            ])==false){
            $mensaje="no encontrado";
           session(['message' => 'no encontrado']);
            return  back()->withErrors(['mensaje'=>'Validar el input vacio']);
        }else{
    
         if( DB::table('tb_empleados')
         ->where('ID_EMPLEADO', $this->ID_EMPLEADO)
         ->update(['NOMBRES' => $this->NOMBRES,
         'APELLIDOS' => $this->APELLIDOS,
         'DPI'=> $this->DPI,
         'EDAD_ACTUAL'=> $this->EDAD_ACTUAL,
         'FECHA_NACIMIENTO'=> $this->FECHA_NACIMIENTO,
      ])){
        session()->forget('edit'); 
        $this->reset();
        session()->forget('usuario1');
        session(['edit' => 'Descuento Editas Correctamente.']);
         }
      }
    
    }

    public function asigrol($usu){
        $sql = "SELECT id FROM users WHERE email=?";
        $us= DB::select($sql,array($usu));  
        $idu="";
        foreach($us as $u){
            $idu=$u->id;
        }

        DB::beginTransaction();
        if( DB::table('rol_users1s')->insert(
            ['id_user' => $idu,
             'id_tipo_rol' => $this->rol,
             'estado'=>'1',
            'created_at'=> date('Y-m-d H:i:s'),
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
    public function eliminarus($id){
        $sql = "SELECT email FROM users WHERE id=?";
        $us= DB::select($sql,array($id));
        $email="";  
        foreach($us as $u){
            $email=$u->email;
        }

        $sql = "SELECT ID_EMPLEADO FROM tb_empleados WHERE email=?";
        $empleado= DB::select($sql,array($email));
        $idemp="";  
        foreach($empleado as $emplead){
            $idemp=$emplead->ID_EMPLEADO;
        }

        $this->iddel=$id;
        $datarols=DB::table('users')
        ->join('rol_users1s', function($join){
            $join->on('users.id','=','rol_users1s.id_user')
            ->where('rol_users1s.id_user','=',$this->iddel);
        })
        ->join('tipo_rols','rol_users1s.id_tipo_rol','=','tipo_rols.id')
        ->select('rol_users1s.id_user','rol_users1s.id')
        ->get();
        $idrol="";
          foreach($datarols as $datarol){
              $idrol=$datarol->id;
          }
        DB::beginTransaction();
        if(DB::table('rol_users1s')->where('id', '=', $idrol)->delete()&&  DB::table('users')->where('id', '=', $id)->delete() &&  DB::table('tb_empleados')
        ->where('ID_EMPLEADO',$idemp)
        ->update(['estado' => '1','fecha_eliminado'=>date('Y-m-d H:i:s')])){
           
            DB::commit();
            session()->forget('delete1'); 
            session(['delete1' => 'si']);
            $this->reset();
        }else{

            DB::rollback();
            session(['error' => 'validar']);
        }
    }

    public function nuevo(){
        $this->reset();
        session()->forget('passup'); 
        session()->forget('usuario1'); 
    }

    public function upcontra($id){
        if($this->validate([
            'pasup' => 'required',
            ])==false){
            $mensaje="no encontrado";
           session(['message' => 'no encontrado']);
            return  back()->withErrors(['mensaje'=>'Validar el input vacio']);
        }else{
            $user = User::find($id);
            $user->password =$this->pasup;
            if(isset($this->rsi)){
                $user->cambiopass ='1';   
            }else{
                $user->cambiopass ='0';   
            }
            $user->save();
            if($user){
                $this->updateMode = false;
                $this->pasup = '';
                $this->reset();
                session()->forget('passup'); 
                session(['passup' => ' Editada Correctamente.']);
                return redirect()->to("/EMPLEADOS");
            }
            else {
                session()->forget('passno'); 
            session(['passno' => ' No fue posible editar.']);
            }

        }
    
    }

    public function buscar(){
        
        $this->usus=$this->usuariobus;

    }
    public function cancelar() {
        $this->pasup = '';
        $this->rsi = '';
        $this->updateMode = false;
    }

}
