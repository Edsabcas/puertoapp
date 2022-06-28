<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PlatilloController extends Controller
{
    public function index()
    {
        session(['platillo' => '1']);
        return redirect()->to('/');
    }
}
