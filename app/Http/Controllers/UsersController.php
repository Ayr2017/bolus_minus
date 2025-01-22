<?php

namespace App\Http\Controllers;

use App\Http\Requests\User\UpdateRolesRequest;
use App\Http\Requests\User\UpdateUserRequest;
use App\Models\User;
use App\Services\User\TagColorService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::orderBy('name')->get();
        return view('users.index',
            [
                'users' => $users,
                'title' => 'Users',
            ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user):View
    {
        $user->load(['roles']);

        return view('users.show', [
            'user' =>  $user,
            'title' => User::class,
            ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user) :View
    {
        $roles = Role::orderBy('name')->get()->chunk(3);
        $user->load(['roles']);
        return view('users.edit', [
            'user' => $user,
            'title' => User::class,
            'roles' => $roles,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUserRequest $request, User $user)
    {
        $data = $request->validated();
        $roles_name = $data['roles_names'];
        unset($data['roles_names']);

        if(empty($data['password'])) {
            unset($data['password']);
        }

        $d = $user->assignRole($roles_name);

        $user->update($data);

        return redirect()->route('users.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function updateRoles(UpdateRolesRequest $request, User $user, TagColorService $userService): RedirectResponse
    {
        $result = $userService->updateRoles($request->validated(), $user);
        if($result){
            return redirect()->route('users.edit', ['user' => $user])->with('message', 'Roles updated successfully!');
        }

        return redirect()->route('users.edit', ['user' => $user])->withErrors(['message'=> 'Roles updating failed!']);
    }
}
