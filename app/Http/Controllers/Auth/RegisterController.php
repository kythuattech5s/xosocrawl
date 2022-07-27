<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Events\ConfirmDataSuccess;
use App\Events\RegisterSuccess;
use App\Models\User;
use Session;
use Support;
use VRoute;
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
            'username' => ['required'],
            'name' => ['required'],
            'phone' => ['required','unique:users'],
            'email' => ['required','email','unique:users'],
            'password' => ['required', 'min:8', 'confirmed'],
            'class_study_id' => ['required']
        ], [
            'required' => 'Vui lòng chọn hoặc nhập :attribute',
            'min' => ':attribute tối thiểu :min kí tự',
            'unique' => ':attribute đã tồn tại trong hệ thống',
            'confirmed' => 'Mật khẩu và mật xác nhận lại phải giống nhau'
        ], [
            'username' => 'Tên đăng nhập',
            'password' => 'Mật khẩu',
            'phone' => 'Số điện thoại',
            'name' => 'Họ và tên bé',
            'email' => 'Email',
            'password_confirmation' => 'Mật khẩu xác nhận',
            'class_study_id' => "Khối/Lớp"
        ]);
    }
    public function register($request)
    {
        $validator = $this->validator($request->all());
        if ($validator->fails()) {
            return response()->json([
                'code' => 100,
                'message' => $validator->errors()->first(),
                'redirect' => url()->previous()
            ]);
        }

        $username = $request->username;
        $user = $this->checkUser('username', $username);

        if(is_array($user)){
            return response($user);
        }

        $user = $this->createUser($request->all());

        Auth::login($user);

        return response()->json([
            'code' => 200,
            'message' => trans("fdb::register_acc_success"),
            'redirect_url' => url(\VRoute::get('profile'))
        ]);
    }
    protected function createUser($data){
        $user = new User;
        $user->username = $data['username'];
        $user->password = Hash::make($data['password']);
        $user->class_study_id = isset($data['class_study_id']) ? (int)$data['class_study_id']:0;
        $user->province_id = isset($data['province_id']) ? (int)$data['province_id']:0;
        $user->district_id = isset($data['district_id']) ? (int)$data['district_id']:0;
        $user->name = isset($data['name']) ? $data['name']:'';
        $user->phone = isset($data['phone']) ? $data['phone']:'';
        $user->email = isset($data['email']) ? $data['email']:'';
        $user->gender_id = isset($data['gender']) ? (int)$data['gender']:0;
        if ($user->gender_id == 1) {
            $user->img = \SettingHelper::getSetting('nam_avatar_default');
        }
        if ($user->gender_id == 2) {
            $user->img = \SettingHelper::getSetting('nu_avatar_default');
        }
        $user->created_at = now();
        $user->updated_at = now();
        $user->save();
        return $user;
    }

    protected function checkUser($feild, $username){
        $user = User::where($feild, $username)->first();
        if($user !== null){
            return [
                'code' => 100,
                'message' => 'Tên đăng nhập đã tồn tại. Vui lòng chọn tên đăng nhập khác.'
            ];
        }
    }
}
