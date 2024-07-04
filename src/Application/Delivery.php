<?php
/**
 * Each engineer has a duty to keep the code elegant
 * Created by wuyuchuan at 2024/6/29 3:17 PM
 */

namespace Cmslz\WechatVideoid\Application;

use Cmslz\WechatVideoid\Kernel\Traits\InteractWithApplication;

class Delivery
{
    use InteractWithApplication;

    public function send($data)
    {
        $response = $this->application->getClient()->post('channels/ec/order/delivery/send', ['json' => $data]);
        return $this->result($response);
    }
}