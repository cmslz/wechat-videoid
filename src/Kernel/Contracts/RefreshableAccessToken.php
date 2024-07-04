<?php

namespace Cmslz\WechatVideoid\Kernel\Contracts;

interface RefreshableAccessToken extends AccessToken
{
    public function refreshAccessToken(): string;
}
