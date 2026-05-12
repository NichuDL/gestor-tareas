<?php

namespace App\Http\Controllers;

use App\Models\Tarea;
use Illuminate\Http\Request;

class TareaController extends Controller
{
    public function index(Request $request)
    {
        $tareas = $request->user()->tareas()->latest()->get();

        return response()->json($tareas);
    }

    public function store(Request $request)
    {
        $request->validate([
            'titulo'      => 'sometimes|string|max:255',
            'descripcion' => 'nullable|string',
            'completada'  => 'sometimes|boolean',
            'prioridad'   => 'sometimes|in:baja,media,alta',
    ]);

        $tarea = $request->user()->tareas()->create([
            'titulo'      => $request->titulo,
            'descripcion' => $request->descripcion,
            'completada'  => false,
            'prioridad'   => $request->prioridad ?? 'media',
            'fecha_limite' => $request->fecha_limite,
            'categoria'    => $request->categoria ?? 'general',
        ]);

        return response()->json($tarea, 201);
    }

    public function show(Request $request, Tarea $tarea)
    {
        if ($tarea->user_id !== $request->user()->id) {
            return response()->json(['mensaje' => 'No autorizado'], 403);
        }

        return response()->json($tarea);
    }

    public function update(Request $request, Tarea $tarea)
    {
        if ($tarea->user_id !== $request->user()->id) {
            return response()->json(['mensaje' => 'No autorizado'], 403);
        }

        $request->validate([
            'titulo'      => 'sometimes|string|max:255',
            'descripcion' => 'nullable|string',
            'completada'  => 'sometimes|boolean',
        ]);

        $tarea->update($request->only('titulo', 'descripcion', 'completada', 'prioridad', 'fecha_limite', 'categoria'));

        return response()->json($tarea);
    }

    public function destroy(Request $request, Tarea $tarea)
    {
        if ($tarea->user_id !== $request->user()->id) {
            return response()->json(['mensaje' => 'No autorizado'], 403);
        }

        $tarea->delete();

        return response()->json(['mensaje' => 'Tarea eliminada correctamente']);
    }
}