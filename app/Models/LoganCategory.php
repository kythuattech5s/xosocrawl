<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class LoganCategory extends BaseModel
{
    use HasFactory;
    public function logan()
    {
        return $this->hasMany(Logan::class);
    }
}