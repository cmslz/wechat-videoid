<?php

declare(strict_types=1);

namespace Cmslz\WechatVideoid\Kernel\Contracts;

interface Jsonable
{
    public function toJson(): string|false;
}
