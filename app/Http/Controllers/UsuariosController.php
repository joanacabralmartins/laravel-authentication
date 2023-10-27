<?php

namespace App\Http\Controllers;

use App\Providers\RouteServiceProvider;
use Hash;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use App\Models\User;

class UsuariosController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function editPassword()
    {
        return view('viewsControleAcesso.update-password');
    }

    public function updatePassword(Request $request)
    {
        $user = User::find(auth()->user()->id);

        if (isset($request->password)) {
            $user->password = Hash::make($request->password);
            $user->save();
        }

        return redirect(RouteServiceProvider::HOME);
    }
    public function index()
    {
        $users = User::all();
        return view('viewsControleAcesso.usuarios', compact('users'));
    }

    public function userRoles(User $user)
    {
        $rolesOfUser = $user->getRoleNames();
        $roles = Role::all();
        return view('viewsControleAcesso.usuarios-papeis', compact('roles', 'rolesOfUser', 'user'));
    }

    public function store(Request $request, User $user)
    {
        /**
         * verificar se precisa fazer alguma validacao
         */
        $papeisDoUsuario = $request->input('papeisDoUsuario');

        $user->syncRoles($papeisDoUsuario);

        return redirect()->route('usuarios.index');
    }
}
