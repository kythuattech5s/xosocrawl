<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Password;

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
            return view('auth.forgot_password', compact('route'));
        }
    }

    public function sendResetLinkEmail(Request $request)
    {
        $validator = $this->validateEmail($request);
        if ($validator->fails()) {
            return \Support::response([
                'code' => 100,
                'message' => $validator->errors()->first()
            ]);
        }

        $response = $this->broker()->sendResetLink(
            $this->credentials($request)
        );
        
        if ($response == Password::RESET_LINK_SENT) {
            return response()->json([
                'code' => 200,
                'message' => 'Gửi yêu cầu lấy lại mật khẩu thành công. Hãy kiểm tra email của bạn và làm theo hướng dẫn.',
                'redirect_url' => url('/')
            ]);
        } else {
            return response()->json([
                'code' => 100,
                'message' => trans('fdb::email_not_exists')
            ]);
        }
    }
  
    protected function validateEmail(Request $request)
    {
        return Validator::make($request->all(), [
            'email' => ['required', 'email', 'exists:users'],
        ], [
            'required' => trans('fdb::required').' :attribute',
            'email' => 'email '.trans('fdb::malformed'),
            'exists' => ':attribute '.trans('fdb::not_exist')
        ]);
    }
}
