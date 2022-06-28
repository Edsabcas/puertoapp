<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Hash;

class CambioPassComponent extends Component
{
    public $passactual,$nueva1,$nueva2;

    public function render()
    {
        return view('livewire.cambio-pass-component');
    }
    public function cambiopass($id){
        if($this->validate([
            'passactual' => 'required',
            'nueva1' => 'required',
            'nueva2' => 'required',
        ])==false){
            $mensaje="no encontrado";
           session(['message' => 'no encontrado']);
            return  back()->withErrors(['mensaje'=>'Validar el input vacio']);
        }else{
            
            if($this->nueva1== $this->nueva2 && $this->passactual!=$this->nueva2){
                $pass2= bcrypt($this->nueva2);
                if(Hash::check($this->passactual,auth()->user()->password)) 
            {
                $password=$this->nueva2;
                $user=User::find(auth()->user()->id);
                $user->password=$password;
                $user->cambiopass='0';
                $user->save();
                Session::flush();
                auth()->logout();
                return redirect()->to('/');
     
            }
            else{
                session()->forget('passnocoinciden1'); 
             session(['passnocoinciden1' => 'no encontrado']);
            }

            }else{
                session()->forget('passnocoinciden'); 
             session(['passnocoinciden' => 'no encontrado']);
            }

        }

    }
}
