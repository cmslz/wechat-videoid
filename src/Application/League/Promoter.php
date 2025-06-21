<?php
/**
 * Each engineer has a duty to keep the code elegant
 * Created by xiaobai at 2024/6/12 下午2:11
 */

namespace Cmslz\WechatVideoid\Application\League;

use Cmslz\WechatVideoid\Kernel\Exceptions\InvalidArgumentException;
use Cmslz\WechatVideoid\Kernel\Traits\InteractWithApplication;

/**
 * 达人
 * Class Promoter
 * @package Cmslz\WechatVideoid\Application\League
 * Created by xiaobai at 2024/6/12 下午2:11
 */
class Promoter
{
    use InteractWithApplication;

    /**
     * 新增达人
     * @param string $id
     * @param string $column promoter_id 或者 promoter_id
     * @return array
     * @throws InvalidArgumentException
     * @link https://developers.weixin.qq.com/doc/store/shop/API/league/ecleague_addpromoter.html
     */
    public function add(string $id, string $column = 'finder_id'): array
    {
        $response = $this->application->getClient()->postJson('channels/ec/league/promoter/add', [
            $column => $id,
        ]);
        return $this->result($response);
    }

    /**
     * 编辑达人
     * @param string $id
     * @param int $type
     * @param string $column promoter_id 或者 promoter_id
     * https://developers.weixin.qq.com/doc/channels/API/league/ecleague_updpromoter.html
     * @return array
     * @throws InvalidArgumentException
     */
    public function upd(string $id, int $type,string $column = 'finder_id'): array
    {
        $response = $this->application->getClient()->postJson('channels/ec/league/promoter/upd', [
            $column => $id,
            'type' => $type,
        ]);
        return $this->result($response);
    }

    /**
     * 删除达人
     * @param string $id
     * @param string $column promoter_id 或者 promoter_id
     * @return array
     * @throws InvalidArgumentException
     * @link https://developers.weixin.qq.com/doc/channels/API/league/ecleague_deletepromoter.html
     */
    public function delete(string $id, string $column = 'finder_id'): array
    {
        $response = $this->application->getClient()->postJson('channels/ec/league/promoter/delete', [
            $column => $id,
        ]);
        return $this->result($response);
    }

    /**
     * 获取达人详情信息
     * @link https://developers.weixin.qq.com/doc/channels/API/league/ecleague_getpromoter.html
     */
    public function get(string $id, string $column = 'finder_id'): array
    {
        $response = $this->application->getClient()->postJson('channels/ec/league/promoter/get', [
            $column => $id,
        ]);
        return $this->result($response);
    }

    /**
     * 获取商店达人列表
     * @link https://developers.weixin.qq.com/doc/channels/API/league/ecleague_getpromoterlist.html
     */
    public function getList(array $params = []): array
    {
        $response = $this->application->getClient()->postJson('channels/ec/league/promoter/list/get', $params);
        return $this->result($response);
    }
}