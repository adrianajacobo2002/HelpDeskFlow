<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;



class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        
        $credentials = $request->validate([
             'email' => ['required', 'string'],
             'password' => ['required', 'string'],
         ]);
         
        var_dump($credentials);
       
        
        if (Auth::attempt(['email' => $credentials['email'], 'password' => $credentials['password']])) {
            
            if (Auth::user()->rol == 'admin') {
                return redirect()->route('admin.dashboard');
            } elseif(Auth::user()->rol  ==  'agente'){
                return redirect()->route('agente.dashboard');
            } else {
                return redirect()->route('cliente.dashboard');
            }
        }
    
        return back()->withErrors(['message' => 'Credenciales incorrectas']);
    }

    public function showRegisterForm(){
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'apellido' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);

        $user = User::create([
            'nombre' => $request->nombre,
            'apellido' => $request->apellido,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'rol' => 'cliente',
        ]);

        Auth::login($user);
        return redirect()->route('cliente.dashboard');

    }

    public function logout(Request $request)
    {
        Auth::logout();
        return redirect('/login');
    }
    
}
