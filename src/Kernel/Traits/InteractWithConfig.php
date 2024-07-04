<?php
/**
 * Each engineer has a duty to keep the code elegant
 * Created by xiaobai at 2024/5/29 下午5:50
 */

namespace Cmslz\WechatVideoid\Kernel\Traits;

use Cmslz\WechatVideoid\Config;
use Cmslz\WechatVideoid\Kernel\Contracts\Config as ConfigInterface;
use Cmslz\WechatVideoid\Kernel\Exceptions\InvalidArgumentException;

trait InteractWithConfig
{

    protected ConfigInterface $config;

    /**
     * @param array<string,mixed>|ConfigInterface $config
     *
     * @throws InvalidArgumentException
     */
    public function __construct(array|ConfigInterface $config)
    {
        $this->config = is_array($config) ? new Config($config) : $config;
    }

    public function getConfig(): ConfigInterface
    {
        return $this->config;
    }

    public function setConfig(ConfigInterface $config): static
    {
        $this->config = $config;

        return $this;
    }
}