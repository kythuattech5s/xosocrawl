<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use Support;
use Auth;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    /**
     * Where to redirect users after registration.
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
        $this->middleware('guest');
        $this->redirectTo = 'account';
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */

    public function switchRegister($request, $route, $link)
    {
        if (Auth::check()) {
            return \Support::response(['code'=>200,'message'=>'Bạn đang đăng nhập rồi','redirect'=>'/']);
        }
        if ($request->isMethod('post')) {
            return $this->register($request);
        } else {
            $currentItem = $route;
            return view('auth.register', compact('currentItem', 'link'));
        }
    }
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'email' => ['required','email','unique:users'],
            'password' => ['required', 'min:8', 'confirmed'],
        ], [
            'required' => 'Vui lòng chọn hoặc nhập :attribute',
            'min' => ':attribute tối thiểu :min kí tự',
            'unique' => ':attribute đã được sử dụng',
            'confirmed' => 'Mật khẩu và mật xác nhận lại phải giống nhau'
        ], [
            'password' => 'Mật khẩu',
            'name' => 'Họ và tên bé',
            'email' => 'Email',
            'password_confirmation' => 'Mật khẩu xác nhận',
        ]);
    }
    public function register($request)
    {
        $validator = $this->validator($request->all());
        if ($validator->fails()) {
            return response()->json([
                'code' => 100,
                'message' => $validator->errors()->first(),
            ]);
        }

        $email = $request->email;
        $user = $this->checkUser('email', $email);

        if(is_array($user)){
            return response($user);
        }

        $user = $this->createUser($request->all());
        $code = \Str::random(6);
        $user->token = Hash::make($code);
        $user->save();
        event('sendmail.register_success', [[
            'title' => 'Tạo tài khoàn thành công và mã xác nhận kích hoạt tài khoản',
            'data' => [
                'link' => url('kich-hoat-tai-khoan') . "?token=$code&email=$user->email",
                'user' => $user,
            ],
            'email' => $user->email,
            'type' => 'user_create',
        ]]);
        return response()->json([
            'code' => 200,
            'message' => 'Đăng ký thành công.',
            'redirect_url' => 'dang-ky-thanh-cong'
        ]);
    }
    protected function createUser($data){
        $user = new User;
        $user->email = $data['email'];
        $user->password = Hash::make($data['password']);
        $user->lastname = $data['lastname'];
        $user->firstname = $data['firstname'];
        $user->act = 0;
        $user->banned = 0;
        $user->created_at = now();
        $user->updated_at = now();
        $user->save();
        $user->img = isset(request()->image_file) ? Support::uploadImg('image_file','users/'.$user->id.'/avatar',false):'';
        $user->save();
        return $user;
    }

    protected function checkUser($feild, $username){
        $user = User::where($feild, $username)->first();
        if($user !== null){
            return [
                'code' => 100,
                'message' => 'Email đã được sử dụng.'
            ];
        }
    }
    public function registerSuccess ($request,$route)
    {
        $currentItem = $route;
        return view('auth.register_success',compact('currentItem'));
    }
    public function activeUser($request)
    {
        if (!$request->input('token', false) || !$request->input('email', false)) {
            return redirect()->to('/')->with('messageNotify', 'Dữ liệu không hợp lệ')->with('typeNotify', 100);
        }
        $user = User::where('email', $request->input('email'))->first();
        if ($user->act == 1) {
            return redirect()->to('/')->with('messageNotify', 'Tài khoản đã được kích hoạt rồi')->with('typeNotify', 200);
        }
        if ($user == null) {
            return redirect()->to('/')->with('messageNotify', 'Email không tồn tại')->with('typeNotify', 100);
        }
        if (!Hash::check($request->input('token'), $user->token)) {
            return redirect()->to('/')->with('messageNotify', 'Mã xác nhận không hợp lệ')->with('typeNotify', 100);
        }
        $user->act = 1;
        $user->save();
        return redirect()->to('dang-nhap')->with('messageNotify', 'Kích hoạt tài khoản thành công vui lòng đăng nhập')->with('typeNotify', 200);
    }
}
