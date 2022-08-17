<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class BannerGdnCategory extends BaseModel
{
    use HasFactory;
    const BANNER_HEADER = 1;
    const BANNER_CONTENT = 2;
    const BANNER_FOOTER = 3;
    const BANNER_TOP_LEFT_SIDEBAR = 4;
    const BANNER_BOTTOM_LEFT_SIDEBAR = 5;
    const BANNER_TOP_RIGHT_SIDEBAR = 6;
    const BANNER_BOTTOM_RIGHT_SIDEBAR = 7;
    const BANNER_BETWEEN_RESULT_TABLE = 8;
}
