<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MesaController extends Controller
{
    public function index()
    {
        session(['mesa' => '1']);
        return redirect()->to('/');
    }
}
