<?php

namespace App\Http\Controllers;



use Illuminate\Support\Facades\Request;

class WebController extends Controller
{
    public function index(Request $request)
    {
        return view('app');
    }
}
