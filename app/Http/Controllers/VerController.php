<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class VerController extends Controller
{
    public function index(){
        session(['verpedido' => '1']);
        return redirect()->to('/');
    }
}
