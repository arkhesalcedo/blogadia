<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Show the home page
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('welcome');
    }

    public function home()
    {
        if (auth()->user()->hasRole('administrator')) {
            return redirect('user');
        }
        
        return redirect('campaigns');
    }
}
