<?php

namespace App\Http\Middleware;

use App\Models\StaticalCrawl;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array
     */
    protected $except = [
        'statistic/tansuat-loto-full',
        'ajax/see-more-result'
    ];
    protected function inExceptArray($request)
    {
        $parentCheck = parent::inExceptArray($request);
        if (!$parentCheck) {
            $itemStaticalCrawl = StaticalCrawl::slug($request->segment(1))->first();
            return isset($itemStaticalCrawl);
        }
        return $parentCheck;
    }
}
