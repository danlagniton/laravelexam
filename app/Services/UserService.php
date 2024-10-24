<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Hash;

class UserService implements UserServiceInterface
{
    public function list(): LengthAwarePaginator
    {
        return User::paginate(10);
    }

    public function store(array $attributes): User
    {
        $attributes['password'] = $this->hash($attributes['password']);
        return User::create($attributes);
    }

    public function find(int $id): User
    {
        return User::findOrFail($id);
    }

    public function update(int $id, array $attributes): User
    {
        $user = $this->find($id);
        if (isset($attributes['password'])) {
            $attributes['password'] = $this->hash($attributes['password']);
        }
        $user->update($attributes);
        return $user;
    }

    public function destroy(int $id): void
    {
        $user = $this->find($id);
        $user->delete();
    }

    public function listTrashed(): LengthAwarePaginator
    {
        return User::onlyTrashed()->paginate(10);
    }

    public function restore(int $id): void
    {
        $user = User::withTrashed()->find($id);
        $user->restore();
    }

    public function delete(int $id): void
    {
        $user = User::withTrashed()->find($id);
        $user->forceDelete();
    }

    public function upload($file)
    {
        // Logic for uploading photo
    }

    public function hash(string $password): string
    {
        return Hash::make($password);
    }

    public function rules(): array
    {
        return [
            'prefixname' => 'in:Mr,Mrs,Ms|nullable',
            'firstname' => 'required|string|max:255',
            'lastname' => 'required|string|max:255',
            'username' => 'required|string|unique:users',
            'email' => 'required|string|email|unique:users',
            'password' => 'required|string',
            'photo' => 'nullable|image',
        ];
    }

    public function saveUserDetails($user)
    {
        Detail::create([
            'key' => 'full_name',
            'value' => $user->fullname,
            'icon' => $user->avatar,
            'status' => '1',
            'type' => 'detail',
            'user_id' => $user->id,
        ]);

        Detail::create([
            'key' => 'middle_initial',
            'value' => $user->middleinitial,
            'icon' => null,
            'status' => '1',
            'type' => 'detail',
            'user_id' => $user->id,
        ]);

        Detail::create([
            'key' => 'gender',
            'value' => $user->prefixname,
            'icon' => null,
            'status' => '1',
            'type' => 'detail',
            'user_id' => $user->id,
        ]);
    }
}