<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class EditarpedidoController extends Controller
{
    public function index()
    {
        session()->forget('bebidasc'); 
        session()->forget('platillosc'); 
        session(['edipedido' => '1']);
        session()->forget('platillosc'); 
        return redirect()->to('/');
    }
}
