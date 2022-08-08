<?php

namespace Lotto\Contracts;

use Lotto\Dtos\ResultObject;

interface IXoSo
{
    public function getLinkByDate(): string;
    public function parseTableResult(): ResultObject;
    public function loadDomFromUrl();
}
