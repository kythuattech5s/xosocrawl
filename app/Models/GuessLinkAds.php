<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class GuessLinkAds extends BaseModel
{
    use HasFactory;
    public function buildLink()
    {
        if ($this->token == '') {
            $this->token = md5($this->getTable().$this->id);
            $this->save();
        }
        return vsprintf('redirect/out?token=%s',[$this->token]);
    }
}
