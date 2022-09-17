<?php

namespace App\Actions\Session;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UpdateUserProfile
{
    /**
     * Atualiza os dados do usuário atualmente logado
     * 
     * @param \Illuminate\Http\Request $request
     */
    public static function run ($request)
    {
        $data = $request->validated();
        // Verifica se foi informada nova senha para alteração
        if (!$data['password']) {
            unset($data['password']);
        } else {
            $data['password'] = Hash::make($data['password']);
        }
        // Atualiza dados do usuário
        Auth::logoutOtherDevices($data['current_password']);
        $request->user()->update($data);
        $request->session()->regenerate();
    }
}