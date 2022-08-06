<?php
namespace basiccomment\comment\Models;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
class CommentReport extends Model
{
    public function user(){
        return $this->belongsTo(User::class);
    }
    public function commentReportType()
    {
        return $this->belongsTo(CommentReportType::class);
    }
}