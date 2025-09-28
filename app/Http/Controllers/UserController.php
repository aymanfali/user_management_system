<?php

namespace App\Http\Controllers;

use App\Application\UseCases\CreateUserUseCase;
use App\Application\UseCases\GetUserUseCase;
use App\Application\UseCases\UpdateUserUseCase;
use App\Application\UseCases\DeleteUserUseCase;
use Illuminate\Http\Request;

class UserController extends Controller
{
    private CreateUserUseCase $createUser;
    private GetUserUseCase $getUser;
    private UpdateUserUseCase $updateUser;
    private DeleteUserUseCase $deleteUser;

    public function __construct(
        CreateUserUseCase $createUser,
        GetUserUseCase $getUser,
        UpdateUserUseCase $updateUser,
        DeleteUserUseCase $deleteUser
    ) {
        $this->createUser = $createUser;
        $this->getUser = $getUser;
        $this->updateUser = $updateUser;
        $this->deleteUser = $deleteUser;
    }

    public function store(Request $request)
    {
        $user = $this->createUser->execute(
            $request->input('name'),
            $request->input('email')
        );

        return response()->json($user, 201);
    }

    public function show(string $id)
    {
        $user = $this->getUser->execute($id);
        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }
        return response()->json($user);
    }

    public function update(Request $request, string $id)
    {
        $user = $this->updateUser->execute(
            $id,
            $request->input('name'),
            $request->input('email')
        );

        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }
        return response()->json($user);
    }

    public function destroy(string $id)
    {
        $this->deleteUser->execute($id);
        return response()->json(['message' => 'User deleted']);
    }
}
