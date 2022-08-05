<?php
namespace basiccomment\comment;
use App\Models\{User,Notification,Story,Chapter, Review};
use basiccomment\comment\Models\{Comment,CommentTag};
class ItemComment
{
    public $data;
    public $user;
    public $commentModel;
    public function __construct($data = null,$user = null)
    {
        $this->data = $data;
        $this->user = $user;
    }
    public function setCommentModel($commentModel){
        $this->commentModel = $commentModel;
    }
    public function toDatabase()
    {
        if (is_null($this->data) || is_null($this->user)) {
            return false;
        }
        if (count($this->data) == 0) {
            return false;
        }
        $comment = new Comment;
        $comment->user_id = $this->user->id;
        $comment->name = $this->user->fullname;
        $comment->email = $this->user->email;
        $comment->map_table = $this->data['commentBoxIdentifier'];
        $comment->map_id = $this->data['commentBoxIdx'];
        $comment->parent = (int)$this->data['parent'];
        $comment->count_child = 0;
        if ($comment->parent == 0) {
            $comment->level = 1;
        }else{
            $commentParent = Comment::find($comment->parent);
            if (isset($commentParent)) {
                $commentParent->count_child = $commentParent->count_child + 1;
                $commentParent->save();
                $comment->level = $commentParent->level+1;
                $comment->level = $comment->level > 3 ? 3:$comment->level;
            }else {
                return false;
            }
        }
        $comment->content = $this->data['content'];
        $comment->referrer = $this->data['referrer'];
        $comment->act = 1;
        $comment->created_at = now();
        $comment->updated_at = now();
        $comment->save();
        $this->setCommentModel($comment);
        return true;
    }
    public function toHtml($showAllChilds,$levelShow,$render = false)
    {
        if (is_null($this->commentModel)) {
            return '';
        }
        $data = [
            'itemComment'=>$this->commentModel,
            'showAllChilds'=>$showAllChilds,
            'levelShow'=>$levelShow
        ];
        if ($render) {
            return view('basiccmt::frontend.item_comment.item',$data);
        }else{
            return view('basiccmt::frontend.item_comment.item',$data)->render();
        }
    }
}
