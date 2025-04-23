<?php

namespace App\Http\Controllers;

use App\Models\Entrada;
use App\Models\Producto;
use Illuminate\Http\Request;
/**
 * Class EntradaController
 * @package App\Http\Controllers
 */
class EntradaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $search = $request->input('search'); // Obtener el término de búsqueda
        $sortBy = $request->input('sortBy', 'id'); // Columna para ordenar (por defecto: id)
        $sortDirection = $request->input('sortDirection', 'asc'); // Dirección de orden (por defecto: ascendente)
    
        $entradas = Entrada::with('producto') // Cargar la relación con productos
            ->when($search, function ($query, $search) {
                $query->whereHas('producto', function ($q) use ($search) {
                    $q->where('nombre', 'like', "%{$search}%");
                })
                ->orWhere('tipo', 'like', "%{$search}%")
                ->orWhere('producto_id', 'like', "%{$search}%");
            })
            ->orderBy($sortBy, $sortDirection) // Ordenar por columna y dirección
            ->paginate(10);
    
        return view('entrada.index', compact('entradas', 'sortBy', 'sortDirection'))->with('i', (request()->input('page', 1) - 1) * 10);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $productos = Producto::all(); // Obtener todos los productos
        $tipos = ['compras', 'devoluciones']; // Opciones del select
        return view('entrada.create', compact('productos', 'tipos'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        request()->validate(Entrada::$rules);

        $entrada = Entrada::create($request->all());

        return redirect()->route('entradas.index')
            ->with('success', 'Entrada created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $entrada = Entrada::find($id);

        return view('entrada.show', compact('entrada'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $entrada = Entrada::findOrFail($id);
        $productos = Producto::all(); // Obtener todos los productos
        $tipos = ['compras', 'devoluciones']; // Opciones del select
        return view('entrada.edit', compact('entrada', 'productos', 'tipos'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  Entrada $entrada
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Entrada $entrada)
    {
        request()->validate(Entrada::$rules);

        $entrada->update($request->all());

        return redirect()->route('entradas.index')
            ->with('success', 'Entrada updated successfully');
    }

    /**
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy($id)
    {
        $entrada = Entrada::find($id)->delete();

        return redirect()->route('entradas.index')
            ->with('success', 'Entrada deleted successfully');
    }
}
