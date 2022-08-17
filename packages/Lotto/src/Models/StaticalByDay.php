<?php

namespace Lotto\Models;

use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;
use Lotto\Helpers\LottoHelper;

class StaticalByDay extends BaseModel
{
    public function lottoCategory()
    {
        return $this->belongsTo(LottoCategory::class);
    }
}
