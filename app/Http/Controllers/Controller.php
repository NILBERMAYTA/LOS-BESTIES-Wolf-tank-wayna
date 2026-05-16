<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Routing\Controller as BaseController; // <-- Añadimos esto para no depender del otro archivo

class ProductoController extends BaseController // <-- Cambiado aquí
{
    // Función para LISTAR todos los productos
    public function index()
    {
        // Consulta directa a la tabla productos de tu base de datos actual
        $productos = DB::table('productos')->get();

        // Retornamos los datos en formato JSON
        return response()->json($productos);
    }

    // Función para GUARDAR un nuevo producto
    public function store(Request $request)
    {
        $request->validate([
            'nombre_producto' => 'required|string|max:150',
            'precio' => 'required|numeric',
            'stock' => 'required|integer',
        ]);

        DB::table('productos')->insert([
            'id_emprendedor' => $request->id_emprendedor ?? 1,
            'id_categoria' => $request->id_categoria ?? 1,
            'nombre_producto' => $request->nombre_producto,
            'slug' => \Illuminate\Support\Str::slug($request->nombre_producto),
            'precio' => $request->precio,
            'stock' => $request->stock,
            'estado' => 'activo',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return response()->json([
            'mensaje' => '¡Producto guardado con éxito en el Backend!',
            'producto' => $request->nombre_producto
        ], 201);
    }
}