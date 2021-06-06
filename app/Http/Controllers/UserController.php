<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

use Symfony\Component\HttpFoundation\Response;

use App\User;

class UserController extends Controller
{
    public function index()
    {
        return User::all();
    }

    public function show(User $user_id)
    {
        return $user_id;
    }

    public function store(Request $request)
    {
        $credentials = $request->only('login', 'password', 'password_confirmation', 'email', 'role');

        $validator = Validator::make($credentials, [
            'login' => ['required', 'string', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'role' => ['required', 'string', 'max:255', 'in:admin,user'],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Invalid data'
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $login = $request->login;
        $password = $request->password;
        $email = $request->email;
        $role = $request->role;
        $subject = "Please verify your email address.";

        $user = User::create([
            'login' => $login,
            'password' => Hash::make($password),
            'email' => $email,
            'role' => $role,
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
            'message' => 'User created! Please check email to complete registration.'
        ], Response::HTTP_CREATED);
    }

    public function avatar(Request $request)
    {
        if (!$request->hasFile('avatar')) {
            return response()->json([
                'message' => 'File not found.'
            ], Response::HTTP_BAD_REQUEST);
        }

        $credentials = $request->only('avatar');

        $validator = Validator::make($credentials, [
            'avatar' => ['required', 'image'],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Invalid data'
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $avatar = $request->file('avatar');

        $path = public_path() . '/uploads/images/store/';
        $avatar->move($path, $avatar->getClientOriginalName());

        return response()->json([
            'message' => 'Avatar upload.'
        ], Response::HTTP_OK);
    }

    public function update(Request $request, User $user_id)
    {
        $credentials = $request->only('login', 'full_name', 'profile_picture');

        $validator = Validator::make($credentials, [
            'login' => ['string', 'max:255'],
            'full_name' => ['string', 'max:255'],
            'profile_picture' => ['string', 'max:255'],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Invalid data'
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $login = $request->login;
        $full_name = $request->full_name;
        $profile_picture = $request->profile_picture;

        if (!$login && !$full_name && !$profile_picture) {
            return response()->json([
                'message' => 'Http bad request.'
            ], Response::HTTP_BAD_REQUEST);
        }

        if ($login) {
            $user_id->login = $login;
        }
        if ($full_name) {
            $user_id->full_name = $full_name;
        }
        if ($profile_picture) {
            $user_id->profile_picture = $profile_picture;
        }

        $user_id->save();

        return response()->json([
            'message' => 'User updated.'
        ], Response::HTTP_OK);
    }

    public function delete(User $user_id)
    {
        $user_id->delete();

        return response()->json([
            'message' => 'User removed.'
        ], Response::HTTP_OK);
    }
}
