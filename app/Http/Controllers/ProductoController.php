<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Routing\Controller as BaseController; // <-- Agregamos esto para solucionar el error

class ProductoController extends BaseController // <-- Cambiamos "Controller" por "BaseController"
{
    // Función para LISTAR todos los productos
    public function index()
    {
        // Consulta directa a la tabla productos
        $productos = DB::table('productos')->get();

        // Retornamos los datos en formato JSON
        return response()->json($productos);
    }

    // Función para GUARDAR un nuevo producto desde un formulario o Postman
    public function store(Request $request)
    {
        // Validamos que los datos mínimos requeridos existan
        $request->validate([
            'nombre_producto' => 'required|string|max:150',
            'precio' => 'required|numeric',
            'stock' => 'required|integer',
        ]);

        // Insertamos el registro en la base de datos
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
    // Función para ACTIVAR O DESACTIVAR un producto (Dar de baja)
    public function cambiarEstado($id)
    {
        // Buscamos el producto actual
        $producto = DB::table('productos')->where('id_producto', $id)->first();

        if (!$producto) {
            return response()->json(['mensaje' => 'Producto no encontrado'], 404);
        }

        // Si está activo lo desactiva, y viceversa
        $nuevoEstado = ($producto->estado == 'activo') ? 'inactivo' : 'activo';

        DB::table('productos')->where('id_producto', $id)->update([
            'estado' => $nuevoEstado,
            'updated_at' => now()
        ]);

        return response()->json([
            'mensaje' => '¡Estado del producto actualizado!',
            'id_producto' => $id,
            'nuevo_estado' => $nuevoEstado
        ]);
    }

    // Función para ELIMINAR un producto por completo
    public function destroy($id)
    {
        $existe = DB::table('productos')->where('id_producto', $id)->exists();

        if (!$existe) {
            return response()->json(['mensaje' => 'Producto no encontrado'], 404);
        }

        DB::table('productos')->where('id_producto', $id)->delete();

        return response()->json([
            'mensaje' => '¡Producto eliminado físicamente de la base de datos!',
            'id_producto' => $id
        ]);
    }
}