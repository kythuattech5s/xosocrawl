<?php
namespace basiccomment\comment\Controllers;
use App\Models\{User};
use Illuminate\Support\Facades\Validator;
use basiccomment\comment\Helpers\CommentHelper;
use basiccomment\comment\ItemComment;
use basiccomment\comment\Models\{Comment,CommentLike,CommentReport};
class ManageCommentController extends Controller
{
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'commentBoxIdx' => ['required'],
            'commentBoxIdentifier' => ['required'],
            'parent' => ['required'],
        ], [
            'required' => 'Bình luận không hợp lệ',
        ], []);
    }
    protected function validatorSendCommentNoLogin(array $data)
    {
        return Validator::make($data, [
            'fullname' => ['required'],
            'email' => ['required','email'],
        ], [
            'required' => 'Vui lòng nhập :attribute',
            'email' => 'Vui lòng nhập :attribute đúng định dạng',
        ], [
            'fullname' => 'Tên hiển thị',
            'email' => 'Email'
        ]);
    }
	public function loadUserTagList()
    {
        $val = request()->val ?? '';
        $listOldUser = request()->base_user ?? '';
        $arrOldUser = explode(',',trim($listOldUser,','));
        if (\Auth::check()) {
            array_push($arrOldUser,\Auth::id());
        }
        $listUser = User::where('act',1)->whereNotIn('id',$arrOldUser)->where('fullname','like','%'.$val.'%')->limit(5)->get();
        return view('basiccmt::frontend.list_user_tag_result',compact('listUser'));
    }
    public function sendComment()
    {
        $request = request();
        if (\Auth::check()) {
            $user = \Auth::user();
        }else{
            $validatorSendCommentNoLogin = $this->validatorSendCommentNoLogin($request->all());
            if ($validatorSendCommentNoLogin->fails()) {
                return response()->json([
                    'code' => 100,
                    'message' => $validatorSendCommentNoLogin->errors()->first()
                ]);
            }
            $user = new User;
            $user->id = 0;
            $user->fullname = $request->fullname;
            $user->email = $request->email;
        }
        $validator = $this->validator($request->all());
        if ($validator->fails()) {
            return response()->json([
                'code' => 100,
                'message' => $validator->errors()->first()
            ]);
        }
        $data['content'] = $request->content ?? '';
        $data['tagUser'] = $request->tagUser ?? '';
        if ($data['content'] == '' && $data['tagUser'] == '') {
            return response()->json([
                'code' => 100,
                'message' => 'Vui lòng nhập nội dung tin nhắn!'
            ]);
        }
        $data['referrer'] = $request->referrer ?? '';
        $data['commentBoxIdx'] = CommentHelper::unHash($request->commentBoxIdx ?? null);
        $data['commentBoxIdentifier'] = CommentHelper::unHash($request->commentBoxIdentifier ?? null);
        $data['parent'] = $request->parent ?? null;
        $itemComment = new ItemComment($data,$user);
        if ($itemComment->toDatabase()) {
            return response()->json([
                'code' => 200,
                'html' => view('basiccmt::frontend.item_comment.item',['itemComment'=>$itemComment->commentModel,'showAllChilds'=>false,'levelShow'=>3])->render()
            ]);
        }else {
            return response()->json([
                'code' => 100,
                'message' => 'Bình luận không thành công. Xin lỗi bạn vì sự bất tiện này!'
            ]);
        }
    }
    public function loadCommentActive()
    {
        $request = request();
        $activeCommentId = $request->commentActive ?? 0;
        $commentBoxIdx = CommentHelper::unHash($request->commentBoxIdx ?? null);
        $commentBoxIdentifier = CommentHelper::unHash($request->commentBoxIdentifier ?? null);
        if ($activeCommentId > 0) {
            $activeComment = Comment::find($activeCommentId);
            $rootCommentId = isset($activeComment) ? $activeComment->getRootCommentId():0;
        }
        if ($rootCommentId == 0) {
            return '';
        }
        $baseComment = Comment::where('act',1)
                                ->with('childs')
                                ->where('map_id',$commentBoxIdx)
                                ->where('map_table',$commentBoxIdentifier)
                                ->with('user')
                                ->with(['commentTag'=>function($q){
                                    $q->whereHas('user')->with('user');
                                }])
                                ->where('id',$rootCommentId);
        $listComment = $baseComment->orderBy('created_at','asc')->get();
        $isPaginate = false;
        $levelShow = $activeComment->level;
        $showAllChilds = true;
        return view('basiccmt::frontend.item_comment.list_item',compact('listComment','isPaginate','showAllChilds','levelShow'))->render();
    }
    public function loadComment()
    {
        $request = request();
        $activeCommentId = $request->commentActive ?? 0;
        $target = $request->target ?? 0;
        $commentBoxIdx = CommentHelper::unHash($request->commentBoxIdx ?? null);
        $commentBoxIdentifier = CommentHelper::unHash($request->commentBoxIdentifier ?? null);
        $baseComment = Comment::where('act',1)
                                ->with('childs')
                                ->where('parent',$target)
                                ->where('map_id',$commentBoxIdx)
                                ->where('map_table',$commentBoxIdentifier)
                                ->with('user')
                                ->with(['commentTag'=>function($q){
                                    $q->whereHas('user')->with('user');
                                }]);
        $rootCommentId = 0;
        if ($activeCommentId > 0) {
            $activeComment = Comment::find($activeCommentId);
            $rootCommentId = isset($activeComment) ? $activeComment->getRootCommentId():0;
        }
        $isPaginate = false;
        if ($target == 0) {
            $sort = $request->sort ?? 0;
            switch ($sort) {
                case 2:
                    $sortString = 'created_at';
                    $sortMethod = 'asc';
                    break;
                case 3:
                    $sortString = 'count_like';
                    $sortMethod = 'desc';
                    break;
                default:
                    $sortString = 'created_at';
                    $sortMethod = 'desc';
                    break;
            }
            $listComment = $baseComment->where('id','!=',$rootCommentId)->orderBy($sortString,$sortMethod)->orderBy('id','desc')->paginate(10);
            $isPaginate = true;
        }else{
            $listComment = $baseComment->orderBy('created_at','asc')->get();
        }
        $showAllChilds = false;                 
        return view('basiccmt::frontend.item_comment.list_item',compact('listComment','isPaginate','showAllChilds'))->render();
    }
    public function loadFormComment()
    {
        $request = request();
        $target = $request->target ?? 0;
        $comment = Comment::with('user')->find($target);
        if (!isset($comment)) {
            return '';
        }
        $target = $comment->level >= 3 ? $comment->parent:$comment->id;
        $placeholder = 'Trả lời '.(isset($comment->user) ? $comment->user->fullname:$comment->name);
        return response()->json([
            'target' => $target,
            'html' => view('basiccmt::frontend.simple_form_comment',['target'=>$target,'placeholder'=>$placeholder,'commentReply'=>$comment])->render()
        ]);
    }
    public function sendLikeComment()
    {
        if (!\Auth::check()) {
            return response()->json([
                'code' => 100,
                'message' => 'Vui lòng đăng nhập để thực hiện hành động này!'
            ]);
        }
        $user = \Auth::user();
        $request = request();
        $target = $request->target ?? 0;
        $type = $request->type ?? null;
        $comment = Comment::with('user')->find($target);
        if (!isset($comment)) {
            return response()->json([
                'code' => 100,
                'message' => 'Không tìm thấy thông tin bình luận!'
            ]);
        }
        $commentLikeUser = CommentLike::where('comment_id',$target)->where('user_id',$user->id)->first();
        if (isset($commentLikeUser)) {
            if (!isset($type)) {
                $commentLikeUser->delete();
                $comment->updateCountLike($commentLikeUser->comment_like_type_id,-1);
            }else{
                if ($commentLikeUser->comment_like_type_id == $type) {
                    $commentLikeUser->delete();
                    $comment->updateCountLike($type,-1);
                }else{
                    $comment->updateCountLike($commentLikeUser->comment_like_type_id,-1);
                    $commentLikeUser->comment_like_type_id = $type;
                    $comment->updateCountLike($type,1);
                    $commentLikeUser->save();
                }
            }
        }
        else{
            if (isset($type)) {
                $newCommentLikeUser = new CommentLike;
                $newCommentLikeUser->user_id = $user->id;
                $newCommentLikeUser->comment_id = $target;
                $newCommentLikeUser->comment_like_type_id = $type;
                $newCommentLikeUser->created_at = now();
                $newCommentLikeUser->updated_at = now();
                $newCommentLikeUser->save();
                $comment->updateCountLike($type,1);
            }
        }
        $comment->fresh();
        return response()->json([
            'code' => 200,
            'type' => $type,
            'htmlCountLike' => view('basiccmt::frontend.item_comment.count_like',['itemComment'=>$comment])->render()
        ]);
    }
    public function sendCommentReport()
    {
        if (!\Auth::check()) {
            return response()->json([
                'code' => 100,
                'message' => 'Vui lòng đăng nhập để báo cáo bình luận!'
            ]);
        }
        $request = request();
        $user = \Auth::user();
        $commentId = $request->comment ?? 0;
        $comment = Comment::where('act',1)->find($commentId);
        if (!isset($comment)) {
            return response()->json([
                'code' => 100,
                'message' => 'Không tìm thấy thông tin bình luận!'
            ]);
        }
        if(!isset($request->type)){
            return response()->json([
                'code' => 100,
                'message' => 'Vui lòng chọn một loại vi phạm của bình luận này!'
            ]);
        }
        $itemCommentReport = new CommentReport;
        $itemCommentReport->user_id = $user->id;
        $itemCommentReport->comment_id = $commentId;
        $itemCommentReport->comment_report_type_id = $request->type;
        $itemCommentReport->content = $request->content ?? '';
        $itemCommentReport->is_read = 0;
        $itemCommentReport->created_at = now();
        $itemCommentReport->updated_at = now();
        $itemCommentReport->save();
        return response()->json([
            'code' => 200,
            'message' => 'Chúng tôi đã nhận được góp ý của bạn. Cảm ơn bạn đã góp phần vì một diễn đàn lành mạnh.'
        ]);
    }
}