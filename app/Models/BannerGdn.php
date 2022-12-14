<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class BannerGdn extends BaseModel
{
    use HasFactory;
    public function bannerGdnCategory()
    {
        return $this->belongsTo(BannerGdnCategory::class);
    }
    public function buildLink()
    {
        if ($this->token == '') {
            $this->token = md5($this->getTable().$this->id);
            $this->save();
        }
        return vsprintf('redirect/outbn?token=%s',[$this->token]);
    }
}
