<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OtpController extends Controller
{
        public function index()
    {
        return view('auth.otp');
    }

   public function verify(Request $request)
    {
        $request->validate([
            'otp' => 'required|digits:6'
        ]);

        $userId = session('otp_user_id');
    

        if (!$userId) {
            return redirect()->route('login')
                ->withErrors(['otp' => 'Session OTP habis. Silakan login ulang.']);
        }

        $user = User::find($userId);

        if (!$user || $user->otp !== $request->otp) {
            return back()->withErrors(['otp' => 'OTP salah']);
        }


        $user->update([
            'otp' => null,
            'otp_expires_at' => null,
        ]);

        Auth::login($user);
        $request->session()->regenerate();
        session()->forget('otp_user_id');

        return redirect()->route('dashboard');
    }

}

