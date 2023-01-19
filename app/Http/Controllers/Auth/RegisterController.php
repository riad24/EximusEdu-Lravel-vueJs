<?php

namespace App\Http\Controllers\Auth;


use App\Events\SendEmailVerification;
use App\Http\Controllers\Controller;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{

    public $pin;

    public function register( Request $request ) : JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'name'     => ['required', 'string', 'max:255'],
            'email'    => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
        ]);

        if($validator->fails()) {
            return new JsonResponse(['success' => false, 'message' => $validator->errors()], 422);
        }

        $user = User::create([
            'name'     => $request->post('name'),
            'username' => rand(111111, 999999),
            'email'    => $request->post('email'),
            'password' => Hash::make($request->post('password'))
        ]);
        if($user) {
            $verify = DB::table('password_resets')->where([
                ['email', $request->post('email')]
            ]);

            if($verify->exists()) {
                $verify->delete();
            }
            $this->pin = rand(100000, 999999);
            DB::table('password_resets')->insert([
                'email' => $request->post('email'),
                'token' => $this->pin,
                'created_at' => Carbon::now()
            ]);
        }

        SendEmailVerification::dispatch(['email' => $request->post('email'), 'pin' => $this->pin]);

        $token = $user->createToken('auth_token')->plainTextToken;

        return new JsonResponse([
            'success' => true,
            'message' => 'Successful created user. Please check your email for a 6-digit pin to verify your email.',
            'token'   => $token
        ], 201);
    }

    public function verifyEmail( Request $request ) : JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'token' => ['required'],
        ]);

        if($validator->fails()) {
            return new JsonResponse(['success' => true, 'message' => $validator->errors()], 422);
        }

        $select = DB::table('password_resets')->where('email', Auth::user()->email)->where('token', $request->post('token'));
        if($select->get()->isEmpty()) {
            return new JsonResponse(['success' => false, 'message' => "Invalid PIN"], 400);
        }

        $select->delete();

        $user                    = User::find(Auth::user()->id);
        $user->email_verified_at = Carbon::now()->getTimestamp();
        $user->save();

        return new JsonResponse(['success' => true, 'message' => "Email is verified"], 200);
    }

    public function resendPin( Request $request )
    {
        $validator = Validator::make($request->all(), [
            'email' => ['required', 'string', 'email', 'max:255'],
        ]);

        if($validator->fails()) {
            return new JsonResponse(['success' => false, 'message' => $validator->errors()], 422);
        }

        $verify = DB::table('password_resets')->where([
            ['email', $request->post('email')]
        ]);

        if($verify->exists()) {
            $verify->delete();
        }

        $this->pin          = random_int(100000, 999999);
        $password_reset = DB::table('password_resets')->insert([
            'email'      => $request->post('email'),
            'token'      => $this->pin,
            'created_at' => Carbon::now()
        ]);

        if($password_reset) {
            SendEmailVerification::dispatch(['email' => $request->post('email'), 'pin' => $this->pin]);

            return new JsonResponse([
                'success' => true,
                'message' => "A verification mail has been resent"
            ], 200);
        }
    }

}
