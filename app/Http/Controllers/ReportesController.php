<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ReportesController extends Controller
{
    public function index(){
        session()->forget('bebidasc'); 
        session()->forget('platillosc'); 
        session(['reportes' => '1']);
        session()->forget('platillosc'); 
        return redirect()->to('/');
    }
}
