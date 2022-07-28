<?php

namespace Lotto\Contracts;

interface IXoSo
{
    public function getLinkByDate(): string;
    public function parseTableResult(): array;
    public function loadDomFromUrl();
}
