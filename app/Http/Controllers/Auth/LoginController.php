<?php

namespace App\Http\Controllers\Auth;


use App\Http\Controllers\Controller;
use App\Http\Resources\PermissionResource;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\Services\MenuService;
use App\Services\PermissionService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class LoginController extends Controller
{
    public $token;
    public $menuService, $permissionService;

    public function __construct(
        MenuService $menuService,
        PermissionService $permissionService
    ) {
        $this->menuService          = $menuService;
        $this->permissionService    = $permissionService;
    }


    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email'    => ['required', 'string', 'email', 'max:255'],
            'password' => ['required', 'string', 'min:6'],
        ]);

        if ($validator->fails()) {
            return new JsonResponse([
                'errors' => $validator->errors()
            ], 422);
        }

        if (!Auth::guard('web')->attempt($request->only('email', 'password'))) {
            return new JsonResponse([
                'errors' => ['validation' => 'Invalid Credentials.']
            ], 400);
        }


        $user        = User::where('email', $request['email'])->first();
        $this->token = $user->createToken('auth_token')->plainTextToken;

        if(!isset($user->roles[0])) {
            return new JsonResponse([
                'errors' => ['validation' => 'Role does not exist.']
            ], 400);
        }

        return new JsonResponse([
            'message'    => 'Login Successfully',
            'token'      => $this->token,
            'user'       => new UserResource($user),
            'menu'       => $this->menuService->menu($user->roles[0]),
            'permission' => PermissionResource::collection($this->permissionService->permission($user->roles[0]))
        ], 201);
    }

    public function logout(Request $request) : JsonResponse
    {
        $request->user()->tokens()->delete();
        return new JsonResponse([
            'message' => 'Logged Out Successfully'
        ], 200);
    }
}
