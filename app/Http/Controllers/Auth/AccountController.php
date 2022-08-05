<?php
namespace App\Http\Controllers\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\{User};
use Validator;
use Illuminate\Validation\Rule;
use stdClass;

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
    public function userShowProfile(Request $request, $id)
    {
        $user = User::where('act',1)->where('banned',0)->find($id);
        if (!isset($user)) {
            abort(404);
        }
        $currentItem = new stdClass();
        $currentItem->name = 'Thông tin cao thủ '.$user->fullname;
        $currentItem->seo_title = 'Thông tin cao thủ '.$user->fullname;
        $currentItem->seo_key = $user->fullname;
        $currentItem->seo_des = 'Thông tin cao thủ '.$user->fullname;
        return view('auth.account.user_show_profile', compact('user','currentItem'));
    }
    public function updateProfile(Request $request, $route)
    {
        if(!Auth::check()){
            return $this->goLogin();
        }
        $user = Auth::user();
        if ($request->isMethod("POST")) {
            return $this->_updateProfile($request, $user);
        }
        $currentItem = $route;
        return view('auth.account.update_profile', compact('user','currentItem'));
    }
    private function _updateProfile($request, $user)
    {
        if ($user->count_update == 0) {
            if ($request->fullname == '') {
                return response()->json([
                    'code' => 100,
                    'message' => 'Vui lòng nhập họ và tên'
                ]);
            }
            $user->fullname = $request->fullname;
        }
        if (isset(request()->image_file)) {
            $user->img = \Support::uploadImg('image_file','users/'.$user->id.'/avatar',false);
        }
        $user->count_update = $user->count_update + 1;
        if ($user->is_social_account) {
            if (isset($request->info_source) && $request->info_source == 1) {
                $user->use_image_social = 1;
            }else{
                $user->use_image_social = 0;
            }
        }
        $user->save();
        return response()->json([
            'code' => 200,
            'message' => 'Cập nhật thông tin thành công'
        ]);
    }
}