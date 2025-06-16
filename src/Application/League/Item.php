<?php
/**
 * Each engineer has a duty to keep the code elegant
 * Created by xiaobai at 2025/6/16 上午10:58
 */

namespace Cmslz\WechatVideoid\Application\League;

use Cmslz\WechatVideoid\Kernel\Exceptions\InvalidArgumentException;
use Cmslz\WechatVideoid\Kernel\Traits\InteractWithApplication;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;

class Item
{
    use InteractWithApplication;

    /**
     * 批量新增联盟商品
     * @link https://developers.weixin.qq.com/doc/store/shop/API/league/ecleague_batchadditem.html
     * @param int $type
     * @param array $list
     * @param array $params
     * @return array
     * @throws InvalidArgumentException
     */
    public function batchAdd(int $type, array $list, array $params = []): array
    {
        $params['type'] = $type;
        $params['list'] = $list;
        $response = $this->application->getClient()->postJson('channels/ec/league/item/batchadd', $params);
        return $this->result($response);
    }

    /**
     * 更新联盟商品信息
     * @link https://developers.weixin.qq.com/doc/store/shop/API/league/ecleague_upditem.html
     * @param int $type @link https://developers.weixin.qq.com/doc/store/shop/API/league/ecleague_upditem.html#a_type
     * @param int $operate_type
     * @param array $params
     * @return array
     * @throws \Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface
     * Created by xiaobai at 2025/6/16 上午11:14
     */
    public function update(int $type, int $operate_type, array $params = []): array
    {
        $params['type'] = $type;
        $params['operate_type'] = $operate_type;
        $response = $this->application->getClient()->post('channels/ec/league/item/upd', $params);
        return $this->result($response);
    }

    /**
     * 删除联盟商品
     * @link https://developers.weixin.qq.com/doc/store/shop/API/league/ecleague_deleteitem.html
     * @param int $type
     * @param $params
     * @return array
     * @throws \Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface
     * Created by xiaobai at 2025/6/16 上午11:16
     */
    public function delete(int $type, array $params = []): array
    {
        $params['type'] = $type;
        $response = $this->application->getClient()->post('channels/ec/league/item/delete', $params);
        return $this->result($response);
    }

    /**
     * 获取联盟商品详情
     * @link https://developers.weixin.qq.com/doc/store/shop/API/league/ecleague_getitem.html
     * @param int $type
     * @param array $params
     * Created by xiaobai at 2025/6/16 下午2:30
     * @return array
     * @throws TransportExceptionInterface
     */
    public function get(int $type, array $params = []): array
    {
        $params['type'] = $type;
        $response = $this->application->getClient()->post('channels/ec/league/item/get', $params);
        return $this->result($response);
    }

    /**
     * 获取联盟商品推广列表
     * @link https://developers.weixin.qq.com/doc/store/shop/API/league/ecleague_getitemlist.html
     * @param int $type
     * @param int $page_size
     * @param int $page_index
     * @param array $params
     * @return array
     * @throws TransportExceptionInterface
     * Created by xiaobai at 2025/6/16 下午2:32
     */
    public function getItemList(int $type, int $page_size, int $page_index, array $params): array
    {
        $params['type'] = $type;
        $params['page_size'] = $page_size;
        $params['page_index'] = $page_index;
        $response = $this->application->getClient()->post('channels/ec/league/item/list/get', $params);
        return $this->result($response);
    }

    /**
     * 批量新增联盟机构推广
     * @link https://developers.weixin.qq.com/doc/store/shop/API/league/ecleague_batchaddheadsupplieritem.html
     * @param string $headsupplier_appid
     * @param array $list
     * @param array $params
     * @return array
     * @throws InvalidArgumentException
     */
    public function headSupplierBatchAdd(string $headsupplier_appid, array $list, array $params = []): array
    {
        $params['headsupplier_appid'] = $headsupplier_appid;
        $params['list'] = $list;
        $response = $this->application->getClient()->postJson('channels/ec/league/item/headsupplier/batchadd', $params);
        return $this->result($response);
    }
}