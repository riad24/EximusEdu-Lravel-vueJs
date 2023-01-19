<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class ResetPasswordController extends Controller
{
    public $token;

    public function resetPassword( Request $request ) : JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'email'    => ['required', 'string', 'email', 'max:255'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
            'password_confirmation' => ['required', 'string', 'min:6'],
        ]);

        if($validator->fails()) {
            return new JsonResponse(['errors' => $validator->errors()], 422);
        }

        $user = User::where('email', $request->post('email'));
        $user->update([
            'password' => Hash::make($request->post('password'))
        ]);

        $this->token = $user->first()->createToken('auth_token')->plainTextToken;

        return new JsonResponse([
            'message' => "Your password has been reset",
            'token'   => $this->token
        ], 200);
    }
}
