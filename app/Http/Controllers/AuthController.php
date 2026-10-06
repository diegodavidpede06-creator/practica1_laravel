<?php

namespace App\Http\Controllers;

use App\Models\Alumno;
use App\Models\Docente;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $validated = $request->validate([
            'usuario' => ['required', 'string'],
            'password' => ['required', 'string'],
        ], [
            'usuario.required' => 'El usuario es obligatorio.',
            'password.required' => 'La contraseña es obligatoria.',
        ]);

        /*
        |--------------------------------------------------------------------------
        | LOGIN DEL DOCENTE
        |--------------------------------------------------------------------------
        */

        $docente = Docente::where(
            'usuario',
            $validated['usuario']
        )->first();

        if (
            $docente &&
            Hash::check($validated['password'], $docente->password)
        ) {
            session([
                'tipo_usuario' => 'docente',
                'usuario_id' => $docente->id,
            ]);

            return redirect()->route('dashboard');
        }

        /*
        |--------------------------------------------------------------------------
        | LOGIN DEL ALUMNO
        |--------------------------------------------------------------------------
        */

        $alumno = Alumno::where(
            'usuario',
            $validated['usuario']
        )
        ->where('activo', true)
        ->first();

        if (
            $alumno &&
            Hash::check($validated['password'], $alumno->password)
        ) {
            session([
                'tipo_usuario' => 'alumno',
                'usuario_id' => $alumno->id,
            ]);

            return redirect()->route('alumno.dashboard');
        }

        return back()
            ->withInput($request->only('usuario'))
            ->withErrors([
                'usuario' => 'El usuario o la contraseña son incorrectos.',
            ]);
    }

    public function logout(Request $request)
    {
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('acceso');
    }
}