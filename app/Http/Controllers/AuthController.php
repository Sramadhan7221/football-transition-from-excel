<?php

namespace App\Http\Controllers;

use App\Exceptions\ValidateException;
use Illuminate\Support\Str;
use App\Models\User;
use App\Validators\AuthValidator;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Password;
use Illuminate\Validation\ValidationException;
use RealRashid\SweetAlert\Facades\Alert;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        if($request->isMethod('GET'))
            return view('pages.auth.sign-in',['title' => 'Login']);

        try {
            $validated = AuthValidator::LoginValidate($request);

            $user = User::where('email', $validated['email'])->first();

            if (!$user || !Hash::check($validated['password'], $user->password)) {
                Alert::error('Wrong email or password.');
            }

            Auth::login($user);

            return redirect()->intended(route('excel.form'));

        } catch (ValidationException $e) {
            return back()->withErrors($e->validator)->withInput();
        } catch (\Throwable $th) {
            Log::error('[AuthController] System Error: ' . $th->getMessage() . ' at line ' . $th->getLine());
            Alert::error('Ada Kesalahan');
            return back();
        }
    }

    public function logout(Request $request):RedirectResponse
    {
        Auth::logout();
 
        $request->session()->invalidate();
     
        $request->session()->regenerateToken();
        
        return redirect('/login');
    }

    public function requestForm()
    {
        return view('pages.auth.forgot-password',['title' => "Forgot Password ?"]);
    }

    public function sendResetLink(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        $status = Password::sendResetLink(
            $request->only('email')
        );

        if($status === Password::RESET_LINK_SENT) {
            Alert::success('Success', 'Email for reset has been send, please check your email');
            return back();
        }
        else {
            Log::error('[AuthController] System Error: ' . __($status));
            Alert::error('Failed', 'Fails to send email, please make sure yoour email has registered');
            return back();
        }
    }

    public function resetForm(Request $request, $token)
    {
        try {
            $email = $request->query('email');
            $isTokenValid = $this->validateExpiredToken($email);
            if(!$isTokenValid) {
                Alert::error('Warning', "Reset Password Link has expired, please perform new request");
                return redirect(route('password.request'));
            }
    
            return view('pages.auth.reset-password', ['title'=>'Reset Password','token' => $token, 'email' => $email]);
        } catch (Exception $th) {
            Alert::error('Warning', $th->getMessage());
            return redirect(route('password.request'));
        }
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'token'    => 'required',
            'email'    => 'required|email',
            'password' => 'required|confirmed|min:8',
        ]);

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user) use ($request) {
                $user->forceFill([
                    'password' => Hash::make($request->password),
                    'remember_token' => Str::random(60),
                ])->save();
            }
        );

        if ($status === Password::PASSWORD_RESET) {
            return response()->json([
                'success' => true,
                'message' => __($status),
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => __($status),
                'errors' => ['email' => [__($status)]],
            ], 422); // gunakan 422 untuk error validasi
        }

    }

    private function validateExpiredToken(string $email) : bool
    {
        $resetRecord = DB::table('password_reset_tokens')
            ->where('email', $email)
            ->first();

        if (!$resetRecord)
            throw new Exception("Token Reset Password Not Found");

        // waktu expired dalam menit
        $expireMinutes = config('auth.passwords.users.expire', 10);
        
        // Hitung expired
        $tokenCreatedAt = Carbon::parse($resetRecord->created_at);

        return Carbon::now()->diffInMinutes($tokenCreatedAt) > $expireMinutes;
    }

}
