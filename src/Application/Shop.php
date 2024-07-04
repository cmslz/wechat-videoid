<?php
/**
 * Each engineer has a duty to keep the code elegant
 * Created by xiaobai at 2024/6/12 下午2:01
 */

namespace Cmslz\WechatVideoid\Application;

use Cmslz\WechatVideoid\Kernel\Exceptions\InvalidArgumentException;
use Cmslz\WechatVideoid\Kernel\Traits\InteractWithApplication;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;

/**
 * 店铺管理API
 * Class Shop
 * @package Cmslz\WechatVideoid\Application
 * Created by xiaobai at 2024/6/12 下午2:08
 */
class Shop
{
    use InteractWithApplication;

    /**
     * 获取店铺基本信息
     * @link https://developers.weixin.qq.com/doc/channels/API/basics/getbasicinfo.html
     * @return array
     * @throws InvalidArgumentException
     */
    public function info_get(): array
    {
        $response = $this->application->getClient()->get('channels/ec/basics/info/get');
        return $this->result($response);
    }
}