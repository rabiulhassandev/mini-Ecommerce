<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    // forgot password view page function
    public function forgetPassword()
    {
        return view('auth.forgot-password');
    }

    // forgot password phono no check and otp send
    public function forgetPasswordRequest(Request $request)
    {
        $data = $request->validate([
            'email' => 'required|string',
        ]);

        Session::forget('forget-password-verify');
        Session::forget('forget-password-change');

        // find user
        $user = User::where('email', $data['email'])->first();
        // if don't find user
        if (! $user) {
            Session::flash('error', 'Email not found!');
            return redirect()->route('forget.password');
        }

        // send otp
        $otp = $user->sendOtp();

        // return response
        if ($otp['status']) {
            Session::flash('success', $otp['message']);
            Session::put('forget-password-verify', true);

            return redirect()->route('forget.otp.verify', ['email' => $user->email]);
        }
        Session::flash('error', $otp['message']);

        return redirect()->route('forget.password');
    }

    public function verify()
    {
        // dd("hlw");
        if (! Session::has('forget-password-verify')) {
            return redirect()->route('forget.password');
        }

        return view('auth.verify-otp');
    }

    public function verifyRequest(Request $request)
    {
        $data = $request->validate([
            'email' => 'required|string',
            'otp' => 'required|array',
        ]);

        $data['otp'] = implode('', $data['otp']);

        if (strlen($data['otp']) != config('otp.length')) {
            return redirect()->back()->withErrors(['otp' => 'OTP length mush be '.config('otp.length')])->with(['email' => $data['email']]);
        }

        // find user
        $user = User::where('email', $data['email'])->first();
        // if don't find user
        if (! $user) {
            Session::flash('error', 'Email not found!');

            return redirect()->route('forget.otp.verify');
        }

        // verify otp
        $otp = $user->verifyOtp($data['otp']);

        if (isset($otp['token'])) {
            Session::put('forget-password-change', true);
            Session::forget('forget-password-verify');

            return redirect()->route('forget.password.change', ['token' => $otp['token'], 'email' => $user->email]);
        }

        // return response
        Session::flash('error', $otp['message']);
        return redirect()->route('forget.otp.verify', ['email' => $data['email']])->withErrors(['otp' => $otp['message']]);
    }

    public function passwordChange()
    {
        if (! Session::has('forget-password-change')) {
            return redirect()->route('forget.otp.verify');
        }

        return view('auth.reset-password');
    }

    public function passwordChangeRequest(Request $request)
    {
        $data = $request->validate([
            'token' => 'required|string|min:'.\config('otp.tokenLength').'|max:'.\config('otp.tokenLength'),
            'password' => 'required|string|confirmed',
            'email' => 'required|string|email',
        ]);

        $userModel = new User;
        $token = $userModel->checkPasswordResetToken($data['token']);

        if ($token['status']) {
            $user = User::where('email', $token['data']->email ?? null)->first();
            Session::forget('forget-password-change');
            // if don't find user
            if (! $user) {
                Session::flash('error', 'Email not found!');
                return redirect()->route('forget.password.change');
            }
            // change password
            $user->password = Hash::make($data['password']);
            $user->save();

            // return response
            Session::flash('success', 'Password change successful');

            return redirect()->route('login');
        }

        // forget session
        Session::forget('forget-password-change');

        Session::flash('error', $token['message']);

        return redirect()->route('forget.password.change')->withErrors(['token' => $token['message']])->with(['email' => $data['email']]);
    }
}
