<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TpropinaController extends Controller
{
    public function index()
    {
        session(['tpropina' => '1']);
        return redirect()->to('/');
    }
}
