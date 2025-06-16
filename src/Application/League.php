<?php
/**
 * Each engineer has a duty to keep the code elegant
 * Created by xiaobai at 2024/6/12 下午2:09
 */

namespace Cmslz\WechatVideoid\Application;

use Cmslz\WechatVideoid\Application\League\Item;
use Cmslz\WechatVideoid\Application\League\Promoter;
use Cmslz\WechatVideoid\Kernel\Traits\InteractWithApplication;

/**
 * 优选联盟
 * Class League
 * @package Cmslz\WechatVideoid\Application
 * Created by xiaobai at 2024/6/12 下午2:12
 */
class League
{
    use InteractWithApplication;

    /**
     * 达人
     * @return Promoter
     * Created by xiaobai at 2024/6/12 下午2:12
     */
    public function promoter(): Promoter
    {
        return new Promoter($this->application);
    }

    /**
     * 商品操作
     * @return Item
     * Created by xiaobai at 2025/6/16 上午10:59
     */
    public function item(): Item
    {
        return new Item($this->application);
    }

}