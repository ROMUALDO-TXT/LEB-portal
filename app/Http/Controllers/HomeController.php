<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function redirect(Request $request)
    {
        if($request->user()->role === 'Cliente'){
            return redirect()->route('workspace');
        }

        if ($request->user()->role === 'Admin') {
            return redirect()->route('dashboard');
        }

        return redirect()->route('home');
    }
}
