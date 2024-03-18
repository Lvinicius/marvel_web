<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return Inertia::render('Login');
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            // Retornar uma resposta Inertia indicando um login bem-sucedido
            return Inertia::location('/personagem');
        }

        // Retornar uma resposta Inertia com uma mensagem de erro
        return Inertia::render('Login', ['error' => 'Credenciais inválidas']);
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        // Return a response indicating successful logout
        return Inertia::location('/login');
    }

    public function register(Request $request)
    {
        // Validação dos dados
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);

        // Criação do usuário
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        // Autenticação do usuário
        Auth::login($user);

        // Retorno da resposta
        return Inertia::location('/personagem');
    }

    public function showRegisterForm()
    {
        return Inertia::render('Registro');
    }
}

