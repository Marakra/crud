<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Psy\Util\Json;

class UserController extends Controller
{
    public function createUser(Request $request): JsonResponse
    {
        $parameters = $request->all();

        if(empty($parameters['email'])) {
            return new JsonResponse(['error' => 'Email is missing'], Response::HTTP_CONFLICT);
        }

        if(empty($parameters['username'])) {
            return new JsonResponse(['error' => 'Username is missing'], Response::HTTP_CONFLICT);
        }

        if(empty($parameters['password'])) {
            return new JsonResponse(['error' => 'Password is missing'], Response::HTTP_CONFLICT);
        }

        if(empty($parameters['first_name'])) {
            return new JsonResponse(['error' => 'First name is missing'], Response::HTTP_CONFLICT);
        }

        if(empty($parameters['last_name'])) {
            return new JsonResponse(['error' => 'Last name is missing'], Response::HTTP_CONFLICT);
        }

        User::query()->create([
            'email' => $parameters['email'],
            'username' => $parameters['username'],
            'password' => Hash::make($parameters['password']),
            'first_name' => $parameters['first_name'],
            'last_name' => $parameters['last_name']
        ]);

        return new JsonResponse(['success' => true], Response::HTTP_CREATED);
    }

    public function getAllUsers(): JsonResponse
    {
        return new JsonResponse(
            User::all()->toArray()
        );
    }

    public function getOneUserById(int $userId): JsonResponse
    {
        $user = User::query()->find($userId);

        if($user === null) {
            return new JsonResponse(['error' => 'User not found'], Response::HTTP_NOT_FOUND);
        }
        return new JsonResponse($user);
    }

    public function updateUser(int $userId, Request $request): JsonResponse
    {
        $user = User::query()->find($userId);

        if($user === null) {
            return new JsonResponse(['error' => 'User not found'], Response::HTTP_NOT_FOUND);
        }

        $parameters = $request->all();

        if(empty($parameters['first_name']) || empty($parameters['last_name'])) {
            return new JsonResponse([
                'error' => 'First name or last name is empty'
            ]);
        }

        $user->update([
            'first_name' => $parameters['first_name'],
            'last_name' => $parameters['last_name']
        ]);

        return new JsonResponse(['success' => true]);
    }

    public function deleteUser(int $userId): JsonResponse
    {
        $user = User::query()->find($userId);

        if($user === null) {
            return new JsonResponse(['error' => 'User not found'], Response::HTTP_NOT_FOUND);
        }

        $user->delete();

        return new JsonResponse(['status' => true]);
    }
}
