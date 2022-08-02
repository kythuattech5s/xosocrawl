<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class TestSpin extends BaseModel
{
    use HasFactory;
    public function category()
    {
        return $this->belongsTo(TestSpinCategory::class,'test_spin_category_id');
    }
}
