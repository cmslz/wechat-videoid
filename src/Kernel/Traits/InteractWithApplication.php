<?php
/**
 * Each engineer has a duty to keep the code elegant
 * Created by xiaobai at 2024/6/5 下午3:29
 */

namespace Cmslz\WechatVideoid\Kernel\Traits;

use Cmslz\WechatVideoid\Application;
use Cmslz\WechatVideoid\Kernel\HttpClient\Response;

trait InteractWithApplication
{
    public function __construct(protected Application $application)
    {
    }

    protected function result(Response $response, bool $throw = null): array
    {
        return $response->toArray($throw);
    }
}