<?php

namespace App\Http\Controllers;

use App\Models\salida;
use App\Models\Producto;
use Illuminate\Http\Request;
use App\Models\Inventario;
/**
 * Class EntradaController
 * @package App\Http\Controllers
 */
class SalidaController extends Controller
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
    
        $salidas = Salida::with('producto') // Cargar la relación con productos
            ->when($search, function ($query, $search) {
                $query->whereHas('producto', function ($q) use ($search) {
                    $q->where('nombre', 'like', "%{$search}%");
                })
                ->orWhere('tipo', 'like', "%{$search}%");
            })
            ->orderBy($sortBy, $sortDirection) // Ordenar por columna y dirección
            ->paginate(10);
    
        return view('salida.index', compact('salidas', 'sortBy', 'sortDirection'))->with('i', (request()->input('page', 1) - 1) * 10);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $productos = Producto::all(); // Obtener todos los productos
        $tipos = ['ventas', 'transferencias']; // Opciones del select
        return view('salida.create', compact('productos', 'tipos'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Validar datos de entrada
        $request->validate([
            'producto_id' => 'required|exists:productos,id',
            'cantidad' => 'required|integer|min:1',
        ]);

        // Buscar el inventario del producto
        $inventario = \App\Models\Inventario::where('producto_id', $request->producto_id)->first();

        // Verificar si hay suficiente stock
        if ($inventario->stock < $request->cantidad) {
            return redirect()->back()->with('error', 'Stock insuficiente');
        }

        // Registrar la salida (ajusta según tu modelo)
        $salida = new \App\Models\Salida();
        $salida->producto_id = $request->producto_id;
        $salida->cantidad = $request->cantidad;
        $salida->save();

        // Actualizar el stock en inventario
        $inventario->stock -= $request->cantidad;
        $inventario->save();

        return redirect()->back()->with('success', 'Salida registrada correctamente');
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $salida = Salida::find($id);

        return view('salida.show', compact('salida'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $salida = Salida::findOrFail($id);
        $productos = Producto::all(); // Obtener todos los productos
        $tipos = ['ventas', 'transferencias']; // Opciones del select
        return view('salida.edit', compact('salida', 'productos', 'tipos'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  Salida $entrada
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Salida $salida)
    {
        request()->validate(Salida::$rules);

        $salida->update($request->all());

        return redirect()->route('salidas.index')
            ->with('success', 'Salida updated successfully');
    }

    /**
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy($id)
    {
        $entrada = Salida::find($id)->delete();

        return redirect()->route('salidas.index')
            ->with('success', 'Salida deleted successfully');
    }
}
