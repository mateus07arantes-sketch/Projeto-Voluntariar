<?php

namespace App\Http\Controllers;

use App\Http\Requests\AuthRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Enums\Role;
use App\Enums\OngStatus;
use App\Models\Ong;

class AuthController extends Controller
{
    // Exibe o formulário de login
    public function index()
    {
        return view('app.login');
    }

    // Processa o login
    public function login(AuthRequest $request)
    {
        $credentials = $request->only('email', 'password');

        if (!Auth::attempt($credentials)) {
            return back()->withErrors([
                'email' => 'Credenciais inválidas. Verifique e tente novamente.'
            ]);
        }

        $user = Auth::user();

        // Verifica se o usuário é uma ONG
        if ($user->role === Role::Ong) {
            $ong = Ong::where('user_id', $user->id)->first();

            // Se não tiver registro de ONG
            if (!$ong) {
                Auth::logout();
                return redirect()->route('login')
                    ->with('error', 'Nenhum cadastro de ONG encontrado.');
            }

            // Se estiver pendente
            if ($ong->status === OngStatus::Pending->value) {
                Auth::logout();
                return redirect()->route('ongs.waiting')
                    ->with('error', 'Seu cadastro de ONG ainda está em análise. Aguarde a aprovação.');
            }

            // Se estiver rejeitada
            if ($ong->status === OngStatus::Rejected->value) {
                Auth::logout();
                return redirect()->route('ongs.waiting')
                    ->with('rejected', 'Seu cadastro de ONG foi recusado. Verifique os dados e tente novamente.');
            }
        }

        // Se for admin
        if ($user->role === Role::Admin) {
            return redirect()->route('ongs.pending')
                ->with('success', 'Bem-vindo ao painel administrativo!');
        }

        // Se for ONG aprovada ou outro usuário
        return redirect()->route('dashboard')
            ->with('success', 'Login realizado com sucesso!');
    }

    // Logout
    public function logout()
    {
        Auth::logout();
        return redirect()->route('login')
            ->with('success', 'Logout realizado com sucesso!');
    }
}
