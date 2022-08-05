<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\PasswordReset;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ForgotPasswordController extends Controller
{
    use SendsPasswordResetEmails;
    public function __construct()
    {
        parent::__construct();
    }
    public function switchForgot($request, $route, $link)
    {
        if ($request->isMethod('post')) {
            return $this->sendResetLinkEmail($request);
        } else {
            $currentItem = $route;
            return view('auth.forgot_password', compact('currentItem'));
        }
    }

    public function sendResetLinkEmail(Request $request)
    {
        $validator = $this->validateEmail($request);
        if ($validator->fails()) {
            return response()->json([
                'code' => 100,
                'message' => $validator->errors()->first(),
            ]);
        }
        $token = PasswordReset::createToken($request->input('email'));
        return response()->json([
            'code' => 200,
            'message' => 'Gửi yêu cầu lấy lại mật khẩu thành công. Hãy kiểm tra email của bạn và làm theo hướng dẫn.',
            'redirect_url' => 'gui-yeu-cau-lay-lai-mat-khau-thanh-cong'
        ]);
    }
  
    protected function validateEmail(Request $request)
    {
        return Validator::make($request->all(), [
            'email' => ['required', 'email', 'exists:users'],
        ], [
            'required' => 'Vui lòng nhập :attribute',
            'email' => 'Vui lòng nhập Email đúng định dạng',
            'email.exists' => ':attribute không tồn tại'
        ],[
            'email' => 'Email'
        ]);
    }
    public function sendMailSuccess(Request $request,$route)
    {
        $currentItem = $route;
        return view('auth.send_mail_forgot_success',compact('currentItem'));
    }
}
