<?php
/**
 * Each engineer has a duty to keep the code elegant
 * Created by xiaobai at 2024/5/29 下午6:51
 */

namespace Cmslz\WechatVideoid;

use Cmslz\WechatVideoid\Kernel\Exceptions\RuntimeException;
use Cmslz\WechatVideoid\Kernel\Contracts\Account as AccountInterface;

class Account implements AccountInterface
{
    public function __construct(
        protected string $appId,
        protected ?string $secret,
        protected ?string $token = null,
        protected ?string $aesKey = null
    ) {
    }

    public function getAppId(): string
    {
        return $this->appId;
    }

    /**
     * @throws RuntimeException
     */
    public function getSecret(): string
    {
        if (null === $this->secret) {
            throw new RuntimeException('No secret configured.');
        }

        return $this->secret;
    }

    public function getToken(): ?string
    {
        return $this->token;
    }

    public function getAesKey(): ?string
    {
        return $this->aesKey;
    }
}
