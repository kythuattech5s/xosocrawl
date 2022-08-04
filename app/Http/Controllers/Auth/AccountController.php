<?php
namespace App\Http\Controllers\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Models\{User,ExamResult,ClassStudy,ExamCategory,Exam};
use Validator;
use Illuminate\Validation\Rule;

class AccountController extends Controller
{
    public function goLogin()
    {
        return \Support::response([
            'code' => 100,
            'message' => 'Vui lòng đăng nhập',
            'redirect' => \VRoute::get('login')
        ]);
    }
    public function profile(Request $request, $route)
    {
        if(!Auth::check()){
            return $this->goLogin();
        }
        $user = Auth::user();
        if ($request->isMethod("POST")) {
            return $this->updateProfile($request, $user);
        }
        return view('auth.account.profile', compact('user'));
    }
}