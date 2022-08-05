<?php
namespace basiccomment\comment\Models;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
class CommentTag extends Model
{
    public function user(){
        return $this->belongsTo(User::class);
    }
}