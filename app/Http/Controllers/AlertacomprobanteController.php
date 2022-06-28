<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AlertacomprobanteController extends Controller
{
    public function index()
    {
        session()->forget('bebidasc'); 
        session()->forget('alertacu'); 
        session(['alertacu' => '1']);
        session()->forget('platillosc'); 
        return redirect()->to('/');
    }
}
