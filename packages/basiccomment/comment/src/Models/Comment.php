<?php
namespace basiccomment\comment\Models;
use App\Models\User;
use basiccomment\comment\Helpers\CommentHelper;
use Illuminate\Database\Eloquent\Model;
class Comment extends Model
{
    public function childs(){
        return $this->hasMany(Comment::class,'parent','id');
    }
    public function user(){
        return $this->belongsTo(User::class);
    }
    public function commentTag(){
        return $this->hasMany(CommentTag::class);
    }
    public function commentLike(){
        return $this->hasMany(CommentLike::class);
    }
    public function showTypeLike()
    {
        if (!\Auth::check()) {
            return '';
        }
        $userLike = $this->commentLike()->where('user_id',\Auth::id())->first();
        return isset($userLike) ? $userLike->comment_like_type_id:'';
    }
    public function updateCountLike($type,$count)
    {
        $countLikeStatical = CommentHelper::extractJson($this->count_like_statical);
        $countLikeStatical = @$countLikeStatical?$countLikeStatical:["data"=>[]];
        if(array_key_exists($type, $countLikeStatical['data'])){
            $countLikeStatical['data'][$type] += $count;
        }
        else{
            $countLikeStatical['data'][$type] = $count;
        }
        $this->count_like = $this->count_like+$count;
        $this->count_like_statical = json_encode($countLikeStatical);
        $this->save();
    }
    public function getCountLikeStatical()
    {
        $countLikeStatical = CommentHelper::extractJson($this->count_like_statical);
        $countLikeStatical = @$countLikeStatical?$countLikeStatical:["data"=>[]];
        $data = $countLikeStatical['data'];
        arsort($data);
        return $data;
    }
    public function getRootCommentId()
    {
        $currentComment = $this;
        while (isset($currentComment) && $currentComment->parent > 0) {
            $currentComment = self::find($currentComment->parent);
        }
        return isset($currentComment) ? $currentComment->id:0;
    }
    public function showBaseChildAble($showAllChilds,$levelShow,$countChild)
    {
        if ($showAllChilds && $levelShow > $this->level) {
            return $countChild > 0;
        }
        if ($countChild > 0 && $countChild < 3) {
            return true;
        }
        return false;
    }
}