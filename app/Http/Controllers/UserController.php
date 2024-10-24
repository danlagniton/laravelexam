<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Http\Requests\UserRequest; // Importing the UserRequest
use App\Services\UserService; // Importing the UserService
use Illuminate\Http\Request;

class UserController extends Controller
{
    protected $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function index()
    {
        $users = $this->userService->list();
        return view('users.index', compact('users'));
    }

    public function show(User $user)
    {
        return view('users.show', compact('user'));
    }

    public function create()
    {
        return view('users.create');
    }

    public function store(UserRequest $request) // Using UserRequest for validation
    {
        $this->userService->store($request->validated());
        return redirect()->route('users.index');
    }

    public function edit(User $user)
    {
        return view('users.edit', compact('user'));
    }

    public function update(UserRequest $request, int $id) // Using UserRequest for validation
    {
        $this->userService->update($id, $request->validated());
        return redirect()->route('users.index');
    }

    public function destroy(User $user)
    {
        $this->userService->destroy($user->id);
        return redirect()->route('users.index');
    }

    public function trashed()
    {
        $trashedUsers = $this->userService->listTrashed();
        return view('users.trashed', compact('trashedUsers'));
    }

    public function restore($id)
    {
        $this->userService->restore($id);
        return redirect()->route('users.trashed');
    }

    public function delete($id)
    {
        $this->userService->delete($id);
        return redirect()->route('users.trashed');
    }
}
