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
    public function changeAvatar(Request $request, $route)
    {
        if(!Auth::check()){
            return $this->goLogin();
        }
        $user = Auth::user();
        if (!$user->isVip()) {
            return response()->json([
                'code' => 100,
                'message' => 'Chỉ có thành viên Vip mới được thay Avatar!'
            ]);
        }
        $avatarId = $request->avatar ?? 0;
        $avatar = \App\Models\UserAvatar::act()->find($avatarId);
        if (!isset($avatar)) {
            return response()->json([
                'code' => 100,
                'message' => 'Đã có lỗi xảy ra'
            ]);
        }
        $user->img = $avatar->img;
        $user->save();
        return response()->json([
            'code' => 200,
            'message' => 'Thay đổi avatar thành công'
        ]);
    }
    public function vipHistory(Request $request, $route)
    {
        if(!Auth::check()){
            return $this->goLogin();
        }
        $user = Auth::user();
        return view('auth.account.vip_history', compact('user'));
    }
    protected function validatorUpdateProfile(array $data)
    {
        return Validator::make($data, [
            'name' => ['required'],
            'phone' => ['required','unique:users,phone,'.Auth::id()],
            'email' => ['required','email','unique:users,email,'.Auth::id()]
        ], [
            'required' => 'Vui lòng chọn hoặc nhập :attribute',
            'unique' => ':attribute đã tồn tại trong hệ thống'
        ], [
            'phone' => 'Số điện thoại',
            'name' => 'Họ và tên bé',
            'email' => 'Email'
        ]);
    }
    public function updateProfile($request, $user)
    {
        if(!Auth::check()){
            return $this->goLogin();
        }
        $validator = $this->validatorUpdateProfile($request->all());
        if ($validator->fails()) {
            return response()->json([
                'code' => 100,
                'message' => $validator->errors()->first(),
            ]);
        }
        
        $user->name = $request->name;
        $user->gender_id = (int)$request->gender;
        $user->phone = $request->phone;
        $user->email = $request->email;
        $user->province_id = (int)$request->province_id;
        $user->district_id = (int)$request->district_id;
        if (\App\Helpers\AcademicStatistic::isTimeChangeClass()) {
            $classStudyId = $request->class_study_id ?? 0;
            $classStudy = ClassStudy::find($classStudyId);
            if (isset($classStudy)) {
                $user->class_study_id = $classStudyId;
            }
        }
        $user->save();
        return response()->json([
            'code' => 200,
            'message' => 'Cập nhật thông tin thành công'
        ]);
    }
    public function switchChangePassword(Request $request, $route)
    {
        if(!Auth::check()){
            return $this->goLogin();
        }
        if($request->isMethod("POST")){
            return $this->changePass($request);
        }
        $user = Auth::user();
        return view('auth.account.change_password',compact('user'));
    }
    private function changePass($request){
        $user = Auth::user();
        $validator = $this->validatorChangePassword($request, $user);

        if (empty($user->password)) {
            $validator = $this->validatorPasswordNew($request);
        } else {
            $validator = $this->validatorChangePassword($request, $user);
        }

        if ($validator->fails()) {
            return response()->json([
            'code' => 100,
            'message' => $validator->errors()->first(),
            ]);
        }
        
        $user->password = \Hash::make($request->password);
        $user->save();
        Auth::logout();

        return response()->json([
            'code' => 200,
            'message' => 'Thay đổi mật khẩu thành công. Vui lòng đăng nhập lại.',
            'redirect_url' => 'dang-nhap'
        ]);
    }
    private function validatorChangePassword($request, $user)
    {
        return \Validator::make($request->all(), [
            'current_password' => ['required', function ($attr, $v, $fail) use ($user) {
                if (!\Hash::check($v, $user->password)) {
                    return $fail(trans("fdb::pass_cur_incorrect"));
                }
            }],
            'password' => ['required', 'confirmed','min:8','different:current_password'],
        ], [
            'required' => trans("fdb::pls_enter").' :attribute',
            'min' => ':attribute '.trans("fdb::at_le").' :min '.trans("fdb::crt"),
            'confirmed' => ':attribute '.trans('fdb::dnm'),
            'different' => trans("fdb::different_pass"),
        ], [
            'current_password' => trans("fdb::current_password"),
            'password' => trans("fdb::pass_new"),
            'password_confirmation' => trans("fdb::pass_confirm"),
        ]);
    }
    private function validatorPasswordNew($request)
    {
        return \Validator::make($request->all(), [
            'password' => ['required', 'confirmed', 'min:8'],
        ], [
            'required' => trans("fdb::pls_enter").' :attribute',
            'min' => ':attribute '.trans("fdb::at_le").' :min '.trans("fdb::crt"),
            'confirmed' => ':attribute '.trans('fdb::dnm'),
        ], [
            'password' => trans("fdb::pass_new"),
            'password_confirmation' => trans("fdb::pass_confirm"),
        ]);
    }
    public function schoolProfile(Request $request, $route)
    {
        if(!Auth::check()){
            return $this->goLogin();
        }
        $user = Auth::user();
        $classStudyId = (int)$request->item ?? 0;
        $classStudy = ClassStudy::find($classStudyId);
        if (!isset($classStudy)) {
            $classStudy = \App\Models\ClassStudy::with('subject')->act()->ord()->find($user->class_study_id);
        }
        $listClassStudy = \App\Models\ClassStudy::act()->ord()->get();
        return view('auth.account.school_profile', compact('user','classStudy','listClassStudy'));
    }
    public function deleteSchoolSubjectProfile(Request $request, $route)
    {
        if(!Auth::check()){
            return $this->goLogin();
        }
        $user = Auth::user();
        $subjectId = (int)$request->subject ?? 0;
        ExamResult::where('subject_id',$subjectId)->where('user_id',$user->id)->delete();
        return response()->json([
            'code' => 200,
            'message' => 'Xóa thành công'
        ]);
    }
    public function loadClassSchoolProfile(Request $request, $route)
    {
        if(!Auth::check()){
            return $this->goLogin();
        }
        $user = Auth::user();
        $classStudyId = (int)$request->item ?? 0;
        $classStudy = ClassStudy::with(['subject'=>function($q){
                                    $q->act();
                                }])->find($classStudyId);
        return view('auth.account.school_profile_result',compact('classStudy'))->render();
    }
    public function learningProgress(Request $request, $route){
        if(!Auth::check()){
            return $this->goLogin();
        }
        $user = Auth::user();
        $classStudyId = (int)$request->item ?? 0;
        $classStudy = ClassStudy::with(['subject'=>function($q){
            $q->with(['subjectPracticeExercise'=>function($q){
                $q->with(['exerciseTopic'=>function($q){
                    $q->with(['trainingExercise'=>function($q){
                        $q->with(['exercise'=>function($q){
                            $q->act()->ord();
                        }])->act()->ord();
                    }]);
                },'trainingExercise'=>function($q){
                    $q->with(['exercise'=>function($q){
                        $q->act()->ord();
                    }])->act()->ord();
                }]);
            }])->act()->ord();
        }])->find($classStudyId);
        if (!isset($classStudy)) {
            $classStudy = \App\Models\ClassStudy::with('subject')->act()->ord()->find($user->class_study_id);
        }
        $type = $request->type ?? '';
        $type = $type == '' ? 'exercise':$type;
        $listClassStudy = \App\Models\ClassStudy::act()->ord()->get();
        $listExerciseLevel = \App\Models\ExerciseLevel::get();
        switch ($type) {
            case 'exercise':
                return $this->learningProgressExercise($classStudy,$listClassStudy,$type,$listExerciseLevel);
                break;
            case 'exam':
                return $this->learningProgressExam($classStudy,$listClassStudy,$type,$listExerciseLevel);
                break;
            default:
                return $this->learningProgressExercise($classStudy,$listClassStudy,$type,$listExerciseLevel);
                break;
        }
    }
    public function learningProgressExercise($classStudy,$listClassStudy,$type,$listExerciseLevel)
    {
        $percenDone = 0;
        $listExerciseTopic = [];
        foreach ($classStudy->subject as $itemSubject) {
            $percenDone += $itemSubject->getPercentComplete();
            foreach ($itemSubject->subjectPracticeExercise as $itemSubjectPracticeExercise) {
                foreach ($itemSubjectPracticeExercise->exerciseTopic as $itemExerciseTopic) {
                    $listExerciseTopic[$itemExerciseTopic->id] = $itemExerciseTopic;
                }
            }
        }
        $listExerciseTopicId = array_keys($listExerciseTopic);
        $listExerciseTopic = array_values($listExerciseTopic);
        $listExerciseTopicDone = \App\Models\ExerciseTopic::whereIn('id',$listExerciseTopicId)->whereHas('trainingExercise',function($q){
                                                                $q->whereHas('exercise',function($q){
                                                                    $q->whereHas('exerciseResult',function($q){
                                                                        $q->where('user_id',\Auth::id());
                                                                    });
                                                                });
                                                            })->get();
        $totalExerciseTopicDone = count($listExerciseTopicDone);
        $strChart = '';
        if ($percenDone > 0) {
            $strChart = $this->buildChartProgessExercise($listExerciseTopicDone);
        }
        return view('auth.account.learning_progress_exercise',compact('classStudy','listClassStudy','type','listExerciseLevel','percenDone','listExerciseTopic','listExerciseTopicId','totalExerciseTopicDone','strChart'));
    }
    public function learningProgressExam($classStudy,$listClassStudy,$type,$listExerciseLevel)
    {
        $arrSubjectId = $classStudy->subject->pluck('id');
        $arrExamCategoryId = ExamCategory::whereIn('subject_id',$arrSubjectId)->act()->pluck('id');
        $listExamId = Exam::join('exam_exam_category','exams.id','=','exam_exam_category.exam_id')
                            ->whereIn('exam_exam_category.exam_category_id',$arrExamCategoryId)
                            ->act()->ord()->pluck('id')->toArray();
        $listExamId = array_unique($listExamId);
        $listExam = Exam::whereIn('id',$listExamId)->with(['examResult'=>function($q){
                                                        $q->where('user_id',\Auth::id())->where('root',1);
                                                    }])->get();
        $baseExamDone = Exam::whereIn('id',$listExamId)->whereHas('examResult',function($q){
                                    $q->where('user_id',\Auth::id())->where('root',1);
                                });
        $listExamDone = $baseExamDone->get();
        $totalExamDo = $baseExamDone->count();
        $strChart = '';
        if ($totalExamDo > 0) {
            $strChart = $this->buildChartProgessExam($listExamDone);
        }
        return view('auth.account.learning_progress_exam',compact('classStudy','listClassStudy','type','listExerciseLevel','totalExamDo','listExam','strChart'));
    }
    private function buildChartProgessExercise($listExerciseTopicDone)
    {
        $arrChartStatis = \App\Helpers\AcademicStatistic::getMediumScoreConfig();
        foreach ($arrChartStatis as $key => $item) {
            $arrChartStatis[$key]['total_exercise'] = 0;
            $arrChartStatis[$key]['start_point'] = 0;
            $arrChartStatis[$key]['end_point'] = 0;
            $pointRange = explode('-',$item['point_range']);
            if (count($pointRange) == 2) {
                $arrChartStatis[$key]['start_point'] = (int)$pointRange[0];
                $arrChartStatis[$key]['end_point'] = (int)$pointRange[1];
            }
        }
        $totalExerciseTopicDoneExercise = 0;
        foreach ($listExerciseTopicDone as $itemExerciseTopic) {
            foreach ($itemExerciseTopic->trainingExercise as $itemTrainingExercise) {
                foreach ($itemTrainingExercise->exercise as $itemExercise) {
                    foreach ($itemExercise->exerciseResult as $itemExerciseResult) {
                        $totalExerciseTopicDoneExercise++;
                        foreach ($arrChartStatis as $key => $item) {
                            if ($itemExerciseResult->point_achieved >= $item['start_point'] && $itemExerciseResult->point_achieved < $item['end_point']) {
                                $arrChartStatis[$key]['total_exercise'] = $arrChartStatis[$key]['total_exercise']+1;
                                break;
                            }
                        }
                    }
                }
            }
        }
        $arrData = [];
        $arrLabel = [];
        $arrColor = [];
        foreach ($arrChartStatis as $item) {
            array_push($arrLabel,$item['name']);
            $percen = $totalExerciseTopicDoneExercise > 0 ? 100*$item['total_exercise']/$totalExerciseTopicDoneExercise:0;
            array_push($arrData,round($percen,2));
            array_push($arrColor,$item['color']);
        }
        $strBuild = '';
        $strBuild.= vsprintf('"labels":["%s"]',implode('","', $arrLabel));
        $strBuild.= ','.vsprintf('"dataColor":["%s"]',implode('","', $arrColor));
        $strBuild.= ','.vsprintf('"dataArray":["%s"]',implode('","', $arrData));
        $strBuild = vsprintf("{%s}", $strBuild);
        return $strBuild;
    }
    private function buildChartProgessExam($listExamDone)
    {
        $arrChartStatis = \App\Helpers\AcademicStatistic::getMediumScoreConfig();
        foreach ($arrChartStatis as $key => $item) {
            $arrChartStatis[$key]['total_exercise'] = 0;
            $arrChartStatis[$key]['start_point'] = 0;
            $arrChartStatis[$key]['end_point'] = 0;
            $pointRange = explode('-',$item['point_range']);
            if (count($pointRange) == 2) {
                $arrChartStatis[$key]['start_point'] = (int)$pointRange[0];
                $arrChartStatis[$key]['end_point'] = (int)$pointRange[1];
            }
        }
        
        foreach ($listExamDone as $itemExam) {
            $examResult = $itemExam->examResult()->where('root',1)->where('user_id',\Auth::id())->first();
            if (isset($examResult)) {
                foreach ($arrChartStatis as $key => $item) {
                    if ($examResult->point_achieved >= $item['start_point'] && $examResult->point_achieved < $item['end_point']) {
                        $arrChartStatis[$key]['total_exercise'] = $arrChartStatis[$key]['total_exercise']+1;
                        break;
                    }
                }
            }
        }
        $arrData = [];
        $arrLabel = [];
        $arrColor = [];
        foreach ($arrChartStatis as $item) {
            array_push($arrLabel,$item['name']);
            $percen = count($listExamDone) > 0 ? 100*$item['total_exercise']/count($listExamDone):0;
            array_push($arrData,round($percen,2));
            array_push($arrColor,$item['color']);
        }
        $strBuild = '';
        $strBuild.= vsprintf('"labels":["%s"]',implode('","', $arrLabel));
        $strBuild.= ','.vsprintf('"dataColor":["%s"]',implode('","', $arrColor));
        $strBuild.= ','.vsprintf('"dataArray":["%s"]',implode('","', $arrData));
        $strBuild = vsprintf("{%s}", $strBuild);
        return $strBuild;
    }
}