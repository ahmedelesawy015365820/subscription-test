<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Tenant;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AuthController extends BaseController
{
    public function register(Request $request): JsonResponse
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|string|min:6|confirmed',
            'role'     => ['sometimes', 'required', \Illuminate\Validation\Rule::enum(\App\Enums\UserRole::class)],
        ]);

        return DB::transaction(function () use ($request) {
            // Create a dedicated Tenant for each registered user
            $tenant = Tenant::create([
                'name'  => $request->name . "'s Tenant",
                'email' => $request->email,
            ]);

            $user = User::create([
                'tenant_id' => $tenant->id,
                'name'      => $request->name,
                'email'     => $request->email,
                'password'  => $request->password,
            ]);

            $token = $user->createToken('api-token')->plainTextToken;

            return $this->responseJson([
                'user'  => $user,
                'token' => $token,
            ], 'Registered successfully.', 201);
        });
    }

    public function login(Request $request): JsonResponse
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required|string',
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return $this->responseJson(null, 'Invalid credentials.', 401);
        }

        $token = $user->createToken('api-token')->plainTextToken;

        return $this->responseJson([
            'user'  => $user,
            'token' => $token,
        ], 'Logged in successfully.');
    }

    public function logout(Request $request): JsonResponse
    {
        $request->user()->currentAccessToken()->delete();
        return $this->responseJson(null, 'Logged out successfully.');
    }
}
