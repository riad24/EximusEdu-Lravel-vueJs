<?php

namespace App\Http\Controllers\Auth;

use App\Events\SendEmailVerification;
use App\Events\SendResetPassword;
use App\Http\Controllers\Controller;
use App\Listeners\SendEmailVerificationNotification;
use App\Mail\ResetPassword;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class ForgotPasswordController extends Controller
{

    public $pin;

    public function forgotPassword( Request $request ) : JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'email' => ['required', 'string', 'email', 'max:255'],
        ]);

        if($validator->fails()) {
            return new JsonResponse(['errors' => $validator->errors()], 422);
        }

        $verify = User::where('email', $request->post('email'))->exists();

        if($verify) {
            $verify = DB::table('password_resets')->where([
                ['email', $request->post('email')]
            ]);

            if($verify->exists()) {
                $verify->delete();
            }

            $this->pin      = random_int(100000, 999999);
            $password_reset = DB::table('password_resets')->insert([
                'email'      => $request->post('email'),
                'token'      => $this->pin,
                'created_at' => Carbon::now()
            ]);

            if($password_reset) {
                SendResetPassword::dispatch(['email' => $request->post('email'), 'pin' => $this->pin]);
                return new JsonResponse([
                    'message' => 'Please check your email for a 6 digit pin.'
                ], 200);
            } else {
                return new JsonResponse([
                    'errors' => ['email' => ['The token created fail.']]
                ], 400);
            }
        } else {
            return new JsonResponse([
                'errors' => ['email' => ['This email does not exist.']]
            ], 400);
        }
    }

    public function verifyPin( Request $request ) : JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'email' => ['required', 'string', 'email', 'max:255'],
            'pin' => ['required'],
        ]);

        if($validator->fails()) {
            return new JsonResponse(['errors' => $validator->errors()], 422);
        }

        $check = DB::table('password_resets')->where([
            ['email', $request->post('email')],
            ['token', $request->post('pin')],
        ]);

        if($check->exists()) {
            $difference = Carbon::now()->diffInSeconds($check->first()->created_at);
            if($difference > 3600) {
                return new JsonResponse([
                    'errors' => ['pin' => ['The pin is expired.']]
                ], 400);
            }

            $check->delete();

            return new JsonResponse([
                'message' => "Now you can reset your password."
            ], 200);
        } else {
            return new JsonResponse([
                'errors' => ['pin' => ['The pin is invalid.']]
            ], 400);
        }
    }
}
