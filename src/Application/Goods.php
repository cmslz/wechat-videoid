<?php
/**
 * Each engineer has a duty to keep the code elegant
 * Created by wuyuchuan at 2024/7/3 8:49 PM
 */

namespace Cmslz\WechatVideoid\Application;

use Cmslz\WechatVideoid\Kernel\Traits\InteractWithApplication;

class Goods
{
    use InteractWithApplication;

    public function create($data): array
    {
        $response = $this->application->getClient()->post('channels/ec/product/add', [
            'json' => $data
        ]);
        return $this->result($response);
    }

    public function update($data): array
    {
        $response = $this->application->getClient()->post('channels/ec/product/update', [
            'json' => $data
        ]);
        return $this->result($response);
    }

    public function info($productId, $dataType = 1): array
    {
        $response = $this->application->getClient()->post('channels/ec/product/get', [
            'json' => [
                'product_id' => $productId,
                'data_type' => $dataType
            ]
        ]);
        return $this->result($response);
    }
}