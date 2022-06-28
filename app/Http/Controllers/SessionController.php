<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Session;

class SessionController extends Controller
{
    public $fun=false;

    public function index(){
        session(['menu_alumno' => '1']);
        return view('login.login');
    }
   
    public function store(){

        $us=request('user').'@elpuerto.com';
        $pas=request('password');

        if(auth()->attempt(['email'=>$us,'password'=>$pas])==false){
            
            session(['mensaje' => 'no encontrado']);
            return  back()->withErrors(['mensaje'=>'El usuario o contraseña es inconrrecta']);
        }else{

            if(auth()->user()->cambiopass=='1'){
                return view('admin.cambiopass');
            }
            
         ///   $sql= "SELECT * FROM anuncios ORDER BY id DESC";
           // $anuncios= DB::select($sql);
            //session()->forget('anuncio_mo');
            //session(['anuncio_mo'=>$anuncios]);

            $idRol="";
            $rol=DB::table('users')
            ->join('rol_users1s', function($join){
                $id=auth()->user()->id;
                $join->on('users.id','=','rol_users1s.id_user')
                ->where('rol_users1s.id_user','=',$id);
            })
            ->join('tipo_rols','rol_users1s.id_tipo_rol','=','tipo_rols.id')
            ->select('tipo_rols.id','tipo_rols.descripcion')
            ->get();

            session(['rol' => $rol]);
            $ro=array();
            foreach($rol as $rols){
                $ro[]=$rols->id;
            }
            if($rol==null){
                
                return redirect()->to('/');
            }
else{


    session(['idrol' => $idRol]);
    $menurols=DB::table('tipo_rols')
    ->join('tb_rols', function($join){
        $rol=session('rol');
    $ro=array();
        foreach($rol as $rols){
            $ro[]=$rols->id;
            $idRol=$rols->id;
        }
        session(['ro' => $ro]);
        session(['rolus' => $ro[0]]);
        $join->on('tipo_rols.id','=','tb_rols.id_tipo_rol')
        ->where('tb_rols.id_tipo_rol','=',intval($ro[0]));
    })
    ->join('menu_rols','tb_rols.id_menu_rol','=','menu_rols.id')
    ->select('menu_rols.id', 'menu_rols.descripcion')
    ->get();


    $submenurols=DB::table('tb_rol_menus')
    ->join('sub_menu_rols', function($join){
        $join->on('tb_rol_menus.id_sub_menu_rol','=','sub_menu_rols.id')
        ->where('tb_rol_menus.estado','=',1);
    })
     ->select('sub_menu_rols.id','sub_menu_rols.descripcion', 'sub_menu_rols.icono', 'tb_rol_menus.id_menu_rol')
    ->get();
    
    $users = User::where("id","=",auth()->user()->id)->select("id","foto")->paginate(10);
    session(['menurols' => $menurols]);
    session(['users' => $users]);
    session(['submenurols' => $submenurols]);    
    session(['menu_alumno' => '1']);

    return redirect()->to('/');

}
          
        }   
    }

    public function perfil(){
        session(['perfil' => '1']);
            return view('perfil.perfil');
        }
        public function homes(){
            session(['menu_alumno' => '1']);
            session(['menu_alumno' => '1']);
            return redirect()->to('/');
        }
        public function destroy(){
            //session()->forget('alumnos');
            Session::flush();
            session_unset();
            auth()->logout();
            return redirect()->to('/');
        }
    
        public function upperfil(Request $request){
            session(['menu_alumno' => '1']);
            $ima="";
                    // script para subir la imagen
                    if($request->hasFile("imagen")){
    
                        $imagen = $request->file("imagen");
                        $nombreimagen = "img".time().".".$imagen->guessExtension();
                        $ruta = public_path("/assets/img/team/");
    
                        //$imagen->move($ruta,$nombreimagen);
                        copy($imagen->getRealPath(),$ruta.$nombreimagen);
    
                        $ima = $nombreimagen;
    
                    }
                    $user = User::find(auth()->user()->id);
                    $user->foto =$ima;
                    $user->save();
                    if($user){
                        session(['var' => 'modificado']);
                       return  redirect()->to('/perfil');
    
                    }
        }
        public function updatecontra(Request $request){
            session(['menu_alumno' => '1']);
            $pass1= bcrypt($request->get('actualpassword'));
    
            $user = User::where("id","=", auth()->user()->id);
          
            $id=$request->get('id');
    
            
          
            $pass='';
            foreach ($user as $value) {
                $pass=$value->password;
            }
    if (strcmp($pass, $pass1) !== 0
    ) {
        $id=$request->get('id');
    
            $password=$request->get('password');
    
            
            $user=User::find($id);
    
            $user->password=$password;
    
            $user->save();
            return  redirect('/perfil')->with('noerror','Contraseña reestablecida correctamente'); 
    }
            else {
                return  redirect('/')->with('error','Contraseña ingresada actual no es correcta');
    
            }
        }
    
            public function updaterestab(Request $request){
                session(['menu_alumno' => '1']);
                $pass1= bcrypt($request->get('actualpassword'));
                $user = User::where("id","=", auth()->user()->id);
                $id=$request->get('id');              
                $pass='';
                foreach ($user as $value) {
                    $pass=$value->password;
                }
        if (strcmp($pass, $pass1) !== 0
        ) {
            $id=$request->get('id');
                $password=$request->get('password');                
                $user=User::find($id);
                $user->password=$password;
                $user->cambiopass='0';
                
                $user->save();
                Session::flush();
                auth()->logout();
                return redirect()->to('/');
     
        }
                else {
                    return  redirect('renovacion.index')->with('error','Contraseña ingresada actual no es correcta');
        
                }
    
        }
}
