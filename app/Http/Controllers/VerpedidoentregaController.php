<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class VerpedidoentregaController extends Controller
{
    public function index()
    {
        session()->forget('bebidasc'); 
        session()->forget('platillosc'); 
        session(['verpedidoentregado' => '1']);
        return redirect()->to('/');
    }
}
