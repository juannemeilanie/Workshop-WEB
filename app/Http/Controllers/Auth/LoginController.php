<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Mail\OtpMail;
use App\Models\User;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Laravel\Socialite\Facades\Socialite;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        $this->middleware('auth')->only('logout');
    }

    public function showLoginForm(){
    return view('login');
    }

    public function login(Request $request){
    $validator = Validator::make($request->all(), [
        'email' => 'required|email',
        'password' => 'required|min:4',
    ]);

    if ($validator->fails()) {
        return redirect()->back()
            ->withErrors($validator)
            ->withInput();
    }

    $credentials = $request->only('email', 'password');

    if (Auth::attempt($credentials)) {
        $request->session()->regenerate();

        return redirect()->route('dashboard')
            ->with('success', 'Login berhasil');
    }

    return back()->withErrors([
        'email' => 'Email atau password salah',
    ])->withInput();
    }

    public function googleRedirect(){
        return Socialite::driver('google')->with(['prompt' => 'select_account'])->redirect();
    }

    public function googleCallback(){
        $googleUser = Socialite::driver('google')->user();
        $user = User::where('email',$googleUser->email)->first();
        if(!$user){
            $user = User::create([
                'name' => $googleUser->name,
                'email' => $googleUser->email,
                'id_google' => $googleUser->id,
                'password' => bcrypt(uniqid()),
            ]);
        }

            $otp = rand(100000, 999999);
            $user->update([
            'otp' => $otp,
            'otp_expires_at' => now()->addMinutes(5)
        ]);

        Mail::to($user->email)->send(new OtpMail($otp));

            session(['otp_user_id' => $user->id]);

            return redirect()->route('otp.form');

    }
    

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login')->with('success', 'Logout berhasil');
    }


}
