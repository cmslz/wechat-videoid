<?php

declare(strict_types=1);

namespace Cmslz\WechatVideoid\Kernel\Contracts;

use Psr\Http\Message\ResponseInterface;

interface Server
{
    public function serve(): ResponseInterface;
}
