<?php

namespace App\Http\Controllers;

use App\User;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

use Symfony\Component\HttpFoundation\Response;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    /**
     * API Register
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(Request $request)
    {
        $credentials = $request->only('login', 'email', 'password', 'password_confirmation');

        $validator = Validator::make($credentials, [
            'login' => ['required', 'string', 'max:255', 'unique:users'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed']
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Invalid data'
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $login = $request->login;
        $email = $request->email;
        $password = $request->password;
        $subject = "Please verify your email address.";

        $user = User::create([
            'login' => $login,
            'email' => $email,
            'password' => Hash::make($password)
        ]);

        $verification_code = Str::random(30);
        DB::table('user_verifications')->insert(['user_id' => $user->id, 'token' => $verification_code, 'created_at' => now()]);

        $user->updated_at = now();
        $user->save();

        Mail::send(
            'email.verify',
            ['name' => $login, 'verification_code' => $verification_code],
            function ($mail) use ($email, $login, $subject) {
                $mail->from(getenv('MAIL_FROM_ADDRESS'), getenv('MAIL_FROM_NAME'));
                $mail->to($email, $login);
                $mail->subject($subject);
            }
        );

        return response()->json([
            'message' => 'Thanks for signing up! Please check your email to complete your registration.'
        ], Response::HTTP_CREATED);
    }

    /**
     * API Verify User
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function verify($confirm_token)
    {
        $check = DB::table('user_verifications')->where('token', $confirm_token)->first();

        if (is_null($check)) {
            return response()->json([
                'message' => 'Verification code is invalid.'
            ], Response::HTTP_NOT_FOUND);
        }

        $user = User::find($check->user_id);

        if ($user->email_verified_at) {
            return response()->json([
                'message' => 'Account already verified..'
            ], Response::HTTP_CONFLICT);
        }

        $user->email_verified_at = now();
        $user->updated_at = now();
        $user->save();

        return response()->json([
            'message' => 'You have successfully verified your email address.'
        ], Response::HTTP_OK);
    }

    /**
     * API Login, on success return JWT Auth token
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
        $credentials = $request->only('login', 'email', 'password');

        $validator = Validator::make($credentials, [
            'login' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255'],
            'password' => ['required', 'string', 'max:255'],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Invalid data'
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        try {
            if (!$token = JWTAuth::attempt($credentials)) {
                return response()->json([
                    'message' => 'We cant find an account with this credentials.'
                ], Response::HTTP_NOT_FOUND);
            }
        } catch (JWTException $e) {
            return response()->json([
                'message' => 'Failed to login, please try again.'
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return response()->json([
            'token' => $token
        ], Response::HTTP_OK);
    }

    /**
     * Log out
     * Invalidate the token, so user cannot use it anymore
     * They have to relogin to get a new token
     *
     * @param Request $request
     */
    public function logout(Request $request)
    {
        $this->validate($request, ['token' => 'required']);

        try {
            JWTAuth::invalidate($request->input('token'));

            return response()->json([
                'message' => 'You have successfully logged out.'
            ], Response::HTTP_OK);
        } catch (JWTException $e) {
            return response()->json([
                'message' => 'Failed to logout, please try again.'
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * API Reset Password
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function reset(Request $request)
    {
        $credentials = $request->only('email');

        $validator = Validator::make($credentials, [
            'email' => ['required', 'string', 'email', 'max:255'],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Invalid data'
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return response()->json([
                'message' => 'Your email address was not found.'
            ], Response::HTTP_NOT_FOUND);
        }

        $name = $user->name;
        $email = $user->email;
        $subject = "Please reset your password.";

        $recover_code = Str::random(30);
        DB::table('password_resets')->insert(['user_id' => $user->id, 'token' => $recover_code, 'created_at' => now()]);

        Mail::send(
            'email.recover',
            ['name' => $user->name, 'recover_code' => $recover_code],
            function ($mail) use ($email, $name, $subject) {
                $mail->from(getenv('MAIL_FROM_ADDRESS'), getenv('MAIL_FROM_NAME'));
                $mail->to($email, $name);
                $mail->subject($subject);
            }
        );

        return response()->json([
            'message' => 'A recover password has been sent! Please check your email.'
        ], Response::HTTP_OK);
    }

    /**
     * API Recover User
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function recover(Request $request, $confirm_token)
    {
        $credentials = $request->only('new-password');

        $validator = Validator::make($credentials, [
            'new-password' => ['required', 'string', 'max:255'],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Invalid data'
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $check = DB::table('password_resets')->where('token', $confirm_token)->first();

        if (is_null($check)) {
            return response()->json([
                'message' => 'Recovery code is invalid.'
            ], Response::HTTP_NOT_FOUND);
        }

        $user = User::find($check->user_id);

        $user->password = Hash::make($request->password);
        $user->updated_at = now();
        $user->save();

        return response()->json([
            'message' => 'You have successfully recover your password.'
        ], Response::HTTP_OK);
    }
}
