<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use Auth;
use Session;
use Hash;

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


    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        $this->middleware('guest')->except('logout');
    }
    public function switchLogin($request, $route, $link)
    {
        if (Auth::check()) {
            return \Support::response(['code'=>200,'message'=>'Bạn đang đăng nhập rồi','redirect'=>'/']);
        }

        if ($request->isMethod('post')) {
            return $this->login($request);
        } else {
            Session::put('_url_intended', url()->previous());
            return view('auth.login', compact('route', 'link'));
        }
    }

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'email' => ['required','email'],
            'password' => ['required'],
        ], [
            'required' => 'Vui lòng nhập :attribute',
            'email' => 'Vui lòng nhập :attribute đúng định dạng.',
        ], [
            'email' => 'Email',
            'password' => 'Mật khẩu'
        ]);
    }

    public function login($request)
    {
        $validator = $this->validator($request->all());

        if ($validator->fails()) {
            return \Support::response([
                'code' => 100,
                'message' => $validator->errors()->first(),
            ]);
        }

        $email = $request->email;
        $user = $this->checkUser('email',$email);
        if(is_array($user)){
            return response($user);
        }
        $credentials = ['email' => $email, 'password'=>$request->password];
        if (Auth::attempt($credentials, $request->remember)) {
            return $this->authenticated();
        }
        return $this->sendFailedLoginResponse('email',$request);
    }

    protected function sendFailedLoginResponse($field, $request)
    {
        $message = $this->checkError($field,$request);
        return response()->json([
            'code' => 100,
            'message' => $message
        ]);
    }

    protected function checkError($field,$request)
    {
        return 'Tài khoản hoặc Mật khẩu đăng nhập không chính xác';
    }

    protected function checkUser($field, $value){
        $user = User::where($field, $value)->first();
        if($user == null){
            return [
                'code' => 100,
                'message' => 'Tài khoản không tồn tại vui lòng đăng ký'
            ];
        }
        if(!Hash::check(request()->password,$user->password)){
            return [
                'code' => 100,
                'message' => 'Tài khoản hoặc mật khẩu không chính xác'
            ];
        }
        if($user->act == 0){
            return [
                'code' => 100,
                'message' => 'Tài khoản chưa được kích hoạt'
            ];
        }
        if($user->banned == 1){
            return [
                'code' => 100,
                'message' => 'Tài khoản đã bị cấm'
            ];
        }
    }
    protected function authenticated()
    {
        $user = Auth::user();
        $user->last_active_time = now();
        $user->save();
        return response()->json([
            'code' => 200,
            'message' => 'Đăng nhập thành công',
            'redirect_url' => url()->to('dien-dan-xo-so')
        ]);
    }

    public function logout(Request $request)
    {
        session()->flush();
        Auth::logout();
        return $request->wantsJson()
            ? new JsonResponse([], 204)
            : redirect(route('home'));
    }
}
