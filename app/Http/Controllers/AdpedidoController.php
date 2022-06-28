<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdpedidoController extends Controller
{
    public function index()
    {
        session()->forget('bebidasc'); 
        session()->forget('platillosc'); 
        session(['adpedido' => '1']);
        session()->forget('platillosc'); 
        return redirect()->to('/');
    }
}
