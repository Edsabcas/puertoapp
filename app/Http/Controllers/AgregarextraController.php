<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AgregarextraController extends Controller
{
    public function index()
    {
        session()->forget('bebidasc'); 
        session()->forget('platillosc'); 
        session(['adextra' => '1']);
        session()->forget('platillosc'); 
        return redirect()->to('/');
    }
}

