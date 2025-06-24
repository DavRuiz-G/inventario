<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Inventario;

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
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Obtener inventarios con relación a producto, ordenados por stock ascendente
        $inventarios = Inventario::with('producto')->orderBy('stock', 'asc')->get();

        return view('home', compact('inventarios'));
    }
}
