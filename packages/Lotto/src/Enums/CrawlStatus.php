<?php

namespace Lotto\Enums;

class CrawlStatus extends BaseEnum
{
    const WAIT = 0;
    const SUCCESS = 1;
    const FAIL = 2;
    const NO_SPIN = 3;
}
