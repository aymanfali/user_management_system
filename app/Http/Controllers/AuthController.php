<?php

namespace App\Http\Controllers;

use App\Application\UseCases\LoginUserUseCase;
use App\Application\UseCases\RegisterUserUseCase;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function register(Request $request, RegisterUserUseCase $useCase)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
        ]);

        // Extract values as separate variables
        $name = $request->input('name');
        $email = $request->input('email');
        $password = $request->input('password');

        // Pass them to the Use Case
        $user = $useCase->execute($name, $email, $password);

        return response()->json(['success' => true, 'user' => $user], 201);
    }

    public function login(Request $request, LoginUserUseCase $useCase)
    {
        $request->validate([
            'email'     => 'required|email',
            'password'  => 'required|string',
            '2fa_code'  => 'required|string',
        ]);

        try {
            $result = $useCase->execute(
                $request->input('email'),
                $request->input('password'),
                $request->input('2fa_code')
            );

            return response()->json([
                'success' => true,
                'user'    => $result['user'],
                'token'   => $result['token'],
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 401);
        }
    }
}
