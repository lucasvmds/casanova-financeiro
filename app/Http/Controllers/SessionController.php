<?php

namespace App\Http\Controllers;

use App\Actions\Session\UpdateCurrentUser;
use App\Actions\Session\ValidateUserCredentials;
use App\Http\Controllers\Controller;
use App\Http\Requests\Session\StoreSessionRequest;
use App\Http\Requests\Session\UpdateSessionRequest;
use App\Support\FlashMessages;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;

class SessionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (Auth::check()) {
            return redirect()->route('dashboard.index');
        }

        return Inertia::render('Session/Index');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\Session\StoreSessionRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreSessionRequest $request)
    {
        if (ValidateUserCredentials::run($request)) {
            return redirect()->route('dashboard.index');
        } else {
            return back()->withErrors(['failed' => trans('auth.failed')]);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request)
    {
        return Inertia::render('Session/Edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\Session\UpdateSessionRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateSessionRequest $request)
    {
        UpdateCurrentUser::run($request->user(), $request->validated());
        FlashMessages::success('Usuário alterado com sucesso');
        return redirect()->route('dashboard.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy()
    {
        Auth::logout();
        session()->invalidate();
        session()->regenerateToken();
        return redirect()->route('login');
    }
}
