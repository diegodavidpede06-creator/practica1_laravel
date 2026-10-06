<?php

namespace App\Http\Controllers;

use App\Models\Alumno;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AlumnoController extends Controller
{
    public function index()
    {
        $alumnos = Alumno::query()
            ->orderBy('activo', 'desc')
            ->orderBy('nombre')
            ->paginate(15);

        $total = Alumno::count();

        $activos = Alumno::where('activo', true)->count();

        $inactivos = Alumno::where('activo', false)->count();

        return view('alumnos.index', compact(
            'alumnos',
            'total',
            'activos',
            'inactivos'
        ));
    }

    public function create()
    {
        return view('alumnos.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nombre' => [
                'required',
                'string',
                'max:255',
            ],

            'usuario' => [
                'required',
                'string',
                'max:100',
                'unique:alumnos,usuario',
            ],

            'password' => [
                'required',
                'string',
                'min:6',
                'confirmed',
            ],
        ], [
            'nombre.required' =>
                'El nombre del alumno es obligatorio.',

            'usuario.required' =>
                'El usuario es obligatorio.',

            'usuario.unique' =>
                'Ese usuario ya está registrado.',

            'password.required' =>
                'La contraseña es obligatoria.',

            'password.min' =>
                'La contraseña debe tener al menos 6 caracteres.',

            'password.confirmed' =>
                'Las contraseñas no coinciden.',
        ]);

        Alumno::create([
            'nombre' => $validated['nombre'],
            'usuario' => $validated['usuario'],
            'password' => Hash::make(
                $validated['password']
            ),
            'activo' => true,
        ]);

        return redirect()
            ->route('docente.alumnos.index')
            ->with(
                'success',
                'El alumno fue creado correctamente.'
            );
    }

    public function show(Alumno $alumno)
    {
        $alumno->load([
            'entregas' => function ($query) {
                $query->with([
                    'tarea',
                    'calificacion',
                ])->latest();
            },
            'calificaciones' => function ($query) {
                $query->where('estado', 'publicada')
                    ->with('tarea')
                    ->latest();
            },
        ]);

        $promedio = $alumno->calificaciones
            ->where('estado', 'publicada')
            ->avg('calificacion');

        $estadisticas = [
            'entregas' => $alumno->entregas->count(),

            'calificadas' => $alumno->calificaciones
                ->where('estado', 'publicada')
                ->count(),

            'promedio' => $promedio,
        ];

        return view(
            'alumnos.show',
            compact(
                'alumno',
                'estadisticas'
            )
        );
    }

    public function edit(Alumno $alumno)
    {
        return view(
            'alumnos.edit',
            compact('alumno')
        );
    }

    public function update(
        Request $request,
        Alumno $alumno
    ) {
        $validated = $request->validate([
            'nombre' => [
                'required',
                'string',
                'max:255',
            ],

            'usuario' => [
                'required',
                'string',
                'max:100',
                'unique:alumnos,usuario,' . $alumno->id,
            ],

            'password' => [
                'nullable',
                'string',
                'min:6',
                'confirmed',
            ],
        ], [
            'nombre.required' =>
                'El nombre del alumno es obligatorio.',

            'usuario.required' =>
                'El usuario es obligatorio.',

            'usuario.unique' =>
                'Ese usuario ya está registrado.',

            'password.min' =>
                'La contraseña debe tener al menos 6 caracteres.',

            'password.confirmed' =>
                'Las contraseñas no coinciden.',
        ]);

        $datos = [
            'nombre' => $validated['nombre'],
            'usuario' => $validated['usuario'],
        ];

        if (!empty($validated['password'])) {
            $datos['password'] = Hash::make(
                $validated['password']
            );
        }

        $alumno->update($datos);

        return redirect()
            ->route(
                'docente.alumnos.show',
                $alumno
            )
            ->with(
                'success',
                'Los datos del alumno fueron actualizados correctamente.'
            );
    }

    public function toggle(Alumno $alumno)
    {
        $alumno->update([
            'activo' => !$alumno->activo,
        ]);

        $mensaje = $alumno->activo
            ? 'El alumno fue activado correctamente.'
            : 'El alumno fue desactivado correctamente.';

        return back()->with(
            'success',
            $mensaje
        );
    }

    public function importar(Request $request)
    {
        $request->validate([
            'archivo' => [
                'required',
                'file',
                'mimes:csv,txt',
                'max:2048',
            ],
        ]);

        $archivo = $request->file('archivo');

        $handle = fopen(
            $archivo->getRealPath(),
            'r'
        );

        if (!$handle) {
            return back()->with(
                'error',
                'No fue posible abrir el archivo.'
            );
        }

        $creados = 0;
        $omitidos = 0;
        $primeraFila = true;

        while (($fila = fgetcsv($handle)) !== false) {

            if ($primeraFila) {
                $primeraFila = false;

                if (
                    isset($fila[0]) &&
                    strtolower(trim($fila[0])) === 'nombre'
                ) {
                    continue;
                }
            }

            if (count($fila) < 3) {
                $omitidos++;
                continue;
            }

            $nombre = trim($fila[0]);
            $usuario = trim($fila[1]);
            $password = trim($fila[2]);

            if (
                $nombre === '' ||
                $usuario === '' ||
                $password === ''
            ) {
                $omitidos++;
                continue;
            }

            if (
                Alumno::where(
                    'usuario',
                    $usuario
                )->exists()
            ) {
                $omitidos++;
                continue;
            }

            Alumno::create([
                'nombre' => $nombre,
                'usuario' => $usuario,
                'password' => Hash::make($password),
                'activo' => true,
            ]);

            $creados++;
        }

        fclose($handle);

        return redirect()
            ->route('docente.alumnos.index')
            ->with(
                'success',
                "Importación terminada. {$creados} alumnos creados y {$omitidos} registros omitidos."
            );
    }
}