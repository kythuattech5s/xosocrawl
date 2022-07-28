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
}
