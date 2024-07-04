<?php

declare(strict_types=1);

namespace Cmslz\WechatVideoid\Kernel\Contracts;

interface Arrayable
{
    /**
     * @return array<int|string, mixed>
     */
    public function toArray(): array;
}
