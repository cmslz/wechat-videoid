<?php
/**
 * Each engineer has a duty to keep the code elegant
 * Created by wuyuchuan at 2024/6/29 2:36 PM
 */

namespace Cmslz\WechatVideoid\Application;

use Cmslz\WechatVideoid\Kernel\Traits\InteractWithApplication;

class Order
{
    use InteractWithApplication;

    public function list(array $data)
    {
        $response = $this->application->getClient()->post('channels/ec/order/list/get', ['json' => $data]);
        return $this->result($response);
    }

    public function info($orderId, bool $encodeSensitiveInfo = true)
    {
        $response = $this->application->getClient()->post('channels/ec/order/get', [
            'json' => [
                'order_id' => $orderId,
                'encode_sensitive_info' => $encodeSensitiveInfo
            ]
        ]);
        return $this->result($response);
    }
}