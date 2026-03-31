<?php 
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class ForgotPasswordController extends Controller
{
    // 1. عرض صفحة الإيميل
    public function showEmailForm() {
        return view('auth.email');
    }

  // 2. إرسال OTP
public function sendOtp(Request $request) {
        $request->validate(['email' => 'required|email|exists:users,email']);
        
        $otp = rand(100000, 999999);
        
        DB::table('password_reset_tokens')->updateOrInsert(
            ['email' => $request->email],
            ['token' => $otp, 'created_at' => Carbon::now()]
        );

        $userEmail = $request->email;

        // إرسال الإيميل
        Mail::send([], [], function ($message) use ($userEmail, $otp) {
            $message->to($userEmail)
                ->subject('رمز التحقق OTP -  ERP System')
                ->html("<h3>مرحباً،</h3><p>رمز التحقق الخاص بك هو: <b style='color:red; font-size:20px;'>{$otp}</b></p>");
        });

        return redirect()->route('otp.verify.form', ['email' => $request->email])
                         ->with('success', 'تم إرسال الرمز بنجاح');
    }

    // 3. عرض صفحة الـ OTP
    public function showOtpForm(Request $request) {
        return view('auth.verify', ['email' => $request->email]);
    }

    // 4. التحقق من الرمز
    public function verifyOtp(Request $request) {
        $record = DB::table('password_reset_tokens')
                    ->where('email', $request->email)
                    ->where('token', $request->otp)
                    ->first();

        if (!$record || Carbon::parse($record->created_at)->addMinute()->isPast()) {
            return back()->withErrors(['otp' => 'الرمز غير صحيح أو انتهت صلاحيته.']);
        }

        return redirect()->route('otp.reset.form', ['email' => $request->email]);
    }

    // 5. عرض صفحة كلمة المرور الجديدة
    public function showResetForm(Request $request) {
        return view('auth.reset', ['email' => $request->email]);
    }

    // 6. تحديث كلمة المرور
    public function updatePassword(Request $request) {
        $request->validate([
            'password' => 'required|confirmed|min:8',
            'email' => 'required|email'
        ]);

        $user = User::where('email', $request->email)->first();
        $user->update(['password' => Hash::make($request->password)]);

        DB::table('password_reset_tokens')->where('email', $request->email)->delete();

        return redirect()->route('login')->with('success', 'تم تغيير كلمة المرور بنجاح');
    }
}