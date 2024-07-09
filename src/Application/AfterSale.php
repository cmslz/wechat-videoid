<?php
/**
 * Each engineer has a duty to keep the code elegant
 * Created by wuyuchuan at 2024/7/9 3:43 PM
 */

namespace Cmslz\WechatVideoid\Application;

use Cmslz\WechatVideoid\Kernel\Traits\InteractWithApplication;

class AfterSale
{
    use InteractWithApplication;

    public function getAfterSaleOrder($afterSaleOrderId)
    {
        $response = $this->application->getClient()->post('channels/ec/aftersale/getaftersaleorder', [
            'json' => [
                'after_sale_order_id' => $afterSaleOrderId
            ]
        ]);
        return $this->result($response);
    }
}