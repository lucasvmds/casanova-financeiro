<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Actions\User\ChangeUserStatus;
use App\Actions\User\CreateNewUser;
use App\Actions\User\PaginateUserRecords;
use App\Actions\User\UpdateUser;
use App\Http\Controllers\Controller;
use App\Http\Requests\User\IndexUserResquest;
use App\Http\Requests\User\StoreUserRequest;
use App\Http\Requests\User\UpdateUserRequest;
use App\Models\User;
use App\Support\FlashMessages;
use Inertia\Inertia;

class UserController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(User::class, 'user');
    }

    /**
     * Display a listing of the resource.
     *
     * @param \App\Http\Requests\User\IndexUserResquest $request
     * @return \Illuminate\Http\Response
     */
    public function index(IndexUserResquest $request)
    {
        if ($users = PaginateUserRecords::run($request)) {
            return Inertia::render('User/Index', [
                'users' => $users
            ]);
        } else {
            return redirect()->route('users.index',['items' => $request->validated('items')]);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return Inertia::render('User/Create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\User\StoreUserRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreUserRequest $request)
    {
        CreateNewUser::run($request->validated());
        FlashMessages::success('Usuário criado com sucesso');
        return redirect()->route('users.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        return Inertia::render('User/Edit',[
            'user' => $user,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\User\UpdateUserRequest  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateUserRequest $request, User $user)
    {
        UpdateUser::run($request->validated(), $user);
        FlashMessages::success('Usuário editado com sucesso');
        return redirect()->route('users.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        ChangeUserStatus::run($user);
        return back();
    }
}
