<?php
/**
 * Each engineer has a duty to keep the code elegant
 * Created by wuyuchuan at 2024/7/3 9:07 PM
 */

namespace Cmslz\WechatVideoid\Application;

use Cmslz\WechatVideoid\Kernel\Exceptions\InvalidConfigException;
use Cmslz\WechatVideoid\Kernel\Traits\InteractWithApplication;

class Common
{
    use InteractWithApplication;

    public function uploadUrlImg($imgUrl, $respType = 1): array
    {
        $query = [
            'upload_type' => 1,
            'resp_type' => $respType
        ];
        $response = $this->application->getClient()->post('channels/ec/basics/img/upload?' . http_build_query($query), [
            'json' => [
                'img_url' => $imgUrl
            ]
        ]);
        return $this->result($response);
    }

    /**
     * @throws InvalidConfigException
     */
    public function decrypt($encrypted)
    {
        $data = $this->application->getEncryptor()->decryptMessage($encrypted);
        if (!empty($data)) {
            return json_decode($data, true);
        }
        return [];
    }
}