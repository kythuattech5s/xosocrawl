<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;

class ResetPasswordController extends Controller
{

    use ResetsPasswords;

    protected $redirectTo = RouteServiceProvider::HOME;

    public function switchReset($request, $route, $link)
    {
        if ($request->isMethod('post')) {
            return $this->reset($request);
        }
        else{
            $password_reset = \DB::table('password_resets')->where('email', $request->email)->first();
            if ($password_reset == null) {
                return \Support::response([
                    'code' => 100,
                    'message' => 'Yêu cầu không tồn tại hoặc đã hết thời gian',
                ]);
            }
            if(\Hash::check($request->token,$password_reset->token)){
                return view('auth.reset_password')->with(
                    ['token' => $request->token, 'email' => $request->email, 'currentItem' => $route]
                );
            }else{
                return redirect(url('/'));
            }
        }
    }

    public function reset(Request $request)
    {
        $validator = $this->validator($request);
        if ($validator->fails()) {
            return response()->json([
                'code' => 100,
                'message' => $validator->errors()->first(),
            ]);
        }

        $response = $this->broker()->reset(
            $this->credentials($request), function ($user, $password) {
                $this->resetPassword($user, $password);
            }
        );

        if ($response == Password::PASSWORD_RESET) {
            return response()->json([
                'code' => 200,
                'message' => 'Thay đổi mật khẩu thành công.',
                'redirect_url' => url('cap-nhat-tai-khoan')
            ]);
        }
        else{
            if ($response == 'passwords.token') {
                return response()->json([
                    'code' => 101,
                    'message' => 'Yêu cầu không hợp lệ'
                ]);
            }
            return response()->json([
                'code' => 102,
                'message' => 'Thất bại'
            ]);
        }
    }

    protected function validator($request)
    {
        return \Validator::make($request->all(), [
            'token' => 'required',
            'password' => 'required|confirmed|min:8',
        ], [
            'required' => 'Vui lòng nhập :attribute',
            'confirmed' => 'Mật khẩu và mật khẩu xác nhận phải giống nhau',
            'min' => ':attribute tối thiểu :min kí tự',
        ], [
            'password' => 'Mật khẩu',
        ]);
    }
}
