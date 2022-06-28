<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ComprobantemesaordenController extends Controller
{
    public function index()
    {
        session()->forget('bebidasc'); 
        session()->forget('alertacu'); 
        session(['impcomprobante' => '1']);
        session()->forget('platillosc'); 
        return redirect()->to('/');
    }
}
