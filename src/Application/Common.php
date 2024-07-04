<?php
/**
 * Each engineer has a duty to keep the code elegant
 * Created by wuyuchuan at 2024/7/3 9:07 PM
 */

namespace Cmslz\WechatVideoid\Application;

use Cmslz\WechatVideoid\Kernel\Traits\InteractWithApplication;

class Common
{
    use InteractWithApplication;

    public function uploadUrlImg($imgUrl, $respType = 1): array
    {
        $response = $this->application->getClient()->post('channels/ec/basics/img/upload');
        return $this->result($response);
    }
}