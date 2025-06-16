<?php
/**
 * Each engineer has a duty to keep the code elegant
 * Created by xiaobai at 2024/6/12 下午2:11
 */

namespace Cmslz\WechatVideoid\Application\League;

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
     * @link https://developers.weixin.qq.com/doc/channels/API/league/ecleague_addpromoter.html
     */
    public function add(string $finder_id): array
    {
        $response = $this->application->getClient()->postJson('channels/ec/league/promoter/add', [
            'finder_id' => $finder_id,
        ]);
        return $this->result($response);
    }

    /**
     * 编辑达人
     * https://developers.weixin.qq.com/doc/channels/API/league/ecleague_updpromoter.html
     */
    public function upd(string $finder_id, int $type): array
    {
        $response = $this->application->getClient()->postJson('channels/ec/league/promoter/upd', [
            'finder_id' => $finder_id,
            'type' => $type,
        ]);
        return $this->result($response);
    }

    /**
     * 删除达人
     * @link https://developers.weixin.qq.com/doc/channels/API/league/ecleague_deletepromoter.html
     */
    public function delete(string $finder_id): array
    {
        $response = $this->application->getClient()->postJson('channels/ec/league/promoter/delete', [
            'finder_id' => $finder_id,
        ]);
        return $this->result($response);
    }

    /**
     * 获取达人详情信息
     * @link https://developers.weixin.qq.com/doc/channels/API/league/ecleague_getpromoter.html
     */
    public function get(string $finder_id, bool $findFinder = true): array
    {
        $response = $this->application->getClient()->postJson('channels/ec/league/promoter/get', [
            $findFinder ? 'finder_id' : 'promoter_id' => $finder_id,
        ]);
        return $this->result($response);
    }

    /**
     * 获取商店达人列表
     * @link https://developers.weixin.qq.com/doc/channels/API/league/ecleague_getpromoterlist.html
     */
    public function getList(array $params = []): array
    {
        $params['page_size'] = min($params['page_size'] ?? 10, 200);
        $response = $this->application->getClient()->postJson('channels/ec/league/promoter/list/get', $params);
        return $this->result($response);
    }
}