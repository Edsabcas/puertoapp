<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BebidaController extends Controller
{
    public function index()
    {
        session(['bebida' => '1']);
        return redirect()->to('/');
    }
}
