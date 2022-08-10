<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class Logan extends BaseModel
{
    use HasFactory;
    public function category()
    {
        return $this->belongsTo(LoganCategory::class);
    }
}