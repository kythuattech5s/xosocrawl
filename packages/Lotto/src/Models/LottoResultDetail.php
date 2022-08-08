<?php

namespace Lotto\Models;

use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Lotto\Helpers\LottoHelper;

class LottoResultDetail extends BaseModel
{
    use HasFactory;
    public function lottoRecord()
    {
        return $this->belongsTo(LottoRecord::class);
    }
}
