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
            'phone' => 'required|string',
        ]);

        Session::forget('forget-password-verify');
        Session::forget('forget-password-change');

        // find user
        $user = User::where('phone', $data['phone'])->first();
        // if don't find user
        if (! $user) {
            Session::flash('error', 'ফোন নাম্বারটি খুজে পাওয়া যাচ্ছে না');
            return redirect()->route('forget.password');
        }

        // send otp
        $otp = $user->sendOtp();

        // return response
        if ($otp['status']) {
            Session::flash('success', $otp['message']);
            Session::put('forget-password-verify', true);

            return redirect()->route('forget.otp.verify', ['phone' => $user->phone]);
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
            'phone' => 'required|string',
            'otp' => 'required|array',
        ]);

        $data['otp'] = implode('', $data['otp']);

        if (strlen($data['otp']) != config('otp.length')) {
            return redirect()->back()->withErrors(['otp' => 'OTP length mush be '.config('otp.length')])->with(['phone' => $data['phone']]);
        }

        // find user
        $user = User::where('phone', $data['phone'])->first();
        // if don't find user
        if (! $user) {
            Session::flash('error', 'ফোন নাম্বারটি খুজে পাওয়া যায়নি।');

            return redirect()->route('forget.otp.verify');
        }

        // verify otp
        $otp = $user->verifyOtp($data['otp']);

        if (isset($otp['token'])) {
            Session::put('forget-password-change', true);
            Session::forget('forget-password-verify');

            return redirect()->route('forget.password.change', ['token' => $otp['token'], 'phone' => $user->phone]);
        }

        // return response
        Session::flash('error', $otp['message']);
        return redirect()->route('forget.otp.verify', ['phone' => $data['phone']])->withErrors(['otp' => $otp['message']]);
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
        ]);
        $userModel = new User;
        $token = $userModel->checkPasswordResetToken($data['token']);

        if ($token['status']) {
            $user = User::where('phone', $token['data']->phone)->first();
            Session::forget('forget-password-change');
            // if don't find user
            if (! $user) {
                Session::flash('error', 'ফোন নাম্বারটি খুজে পাওয়া যায়নি।');

                return redirect()->route('forget.password.change');
            }
            // change password
            $user->password = Hash::make($data['password']);
            $user->save();

            // return response
            Session::flash('success', 'Password change successful');

            return redirect()->route('login');
        }

        Session::flash('error', $token['message']);

        return redirect()->route('forget.password.change')->withErrors(['token' => $token['message']])->with(['phone' => $data['phone']]);
    }
}
