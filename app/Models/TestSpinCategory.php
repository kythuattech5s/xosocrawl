<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class TestSpinCategory extends BaseModel
{
    use HasFactory;
    public function testSpin()
    {
        return $this->hasMany(TestSpin::class,'test_spin_category_id');
    }
}
