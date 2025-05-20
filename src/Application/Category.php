<?php
/**
 * Each engineer has a duty to keep the code elegant
 * Created by xiaobai at 2025/5/19 下午5:42
 */

namespace Cmslz\WechatVideoid\Application;

use Cmslz\WechatVideoid\Kernel\Traits\InteractWithApplication;

class Category
{
    use InteractWithApplication;

    /**
     * @link https://developers.weixin.qq.com/doc/store/shop/API/category/getallcategory.html
     * @return array
     * @throws \Cmslz\WechatVideoid\Kernel\Exceptions\InvalidArgumentException
     * Created by xiaobai at 2025/5/19 下午6:33
     */
    public function all()
    {
        $result = $this->application->getClient()->get('channels/ec/category/all');
        return $this->result($result);
    }

    /**
     * @link https://developers.weixin.qq.com/doc/store/shop/API/category/getcategorydetail.html
     * @param $cat_id
     * @return array
     * @throws \Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface
     * Created by xiaobai at 2025/5/19 下午6:33
     */
    public function detail($cat_id)
    {
        $result = $this->application->getClient()->post('channels/ec/category/detail', [
            'json' => [
                'cat_id' => $cat_id
            ]
        ]);
        return $this->result($result);
    }

    /**
     * 获取可用的子类目详情
     * 接口说明
     * @link https://developers.weixin.qq.com/doc/store/shop/API/category/getavailablesoncategories.html
     * @param $catId
     * @return array
     * @throws \Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface
     * Created by xiaobai at 2025/5/20 上午9:54
     */
    public function getAvailableSonCategories($catId)
    {
        $result = $this->application->getClient()->post('channels/ec/category/availablesoncategories/get', [
            'json' => [
                'f_cat_id' => $catId
            ]
        ]);
        return $this->result($result);
    }
}