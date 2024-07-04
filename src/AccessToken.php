<?php

declare(strict_types=1);

namespace Cmslz\WechatVideoid;


use Cmslz\WechatVideoid\Kernel\Contracts\RefreshableAccessToken as RefreshableAccessTokenInterface;
use Cmslz\WechatVideoid\Kernel\Exceptions\BadResponseException;
use Cmslz\WechatVideoid\Kernel\Exceptions\HttpException;
use Cmslz\WechatVideoid\Kernel\HttpClient\RequestUtil;
use Cmslz\WechatVideoid\Kernel\HttpClient\RequestWithPresets;
use Cmslz\WechatVideoid\Kernel\HttpClient\Response;
use Psr\SimpleCache\CacheInterface;
use Psr\SimpleCache\InvalidArgumentException;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\DecodingExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class AccessToken implements RefreshableAccessTokenInterface
{
    use RequestWithPresets;

    const CACHE_KEY_PREFIX = 'video_id';

    public function __construct(
        protected string $appId,
        protected string $secret,
        protected CacheInterface $cache,
        protected HttpClientInterface $httpClient,
        protected ?string $key = null,
        protected bool $forceRefresh = false,
    ) {
    }

    /**
     * @param string $method
     * @param string $url
     * @param array $options
     * @return Response
     * @throws Kernel\Exceptions\InvalidArgumentException
     * @throws TransportExceptionInterface
     * Created by xiaobai at 2024/5/30 下午4:09
     */
    public function request(string $method, string $url, array $options = []): Response
    {
        $options = RequestUtil::formatBody($options);
        return new Response(
            response: $this->httpClient->request($method, ltrim($url, '/'), $options),
        );
    }

    public function getKey(): string
    {
        return $this->key ?? $this->key = sprintf('%s.access_token.%s.%s', static::CACHE_KEY_PREFIX,
            $this->appId,
            $this->secret);
    }

    public function setKey(string $key): static
    {
        $this->key = $key;

        return $this;
    }

    /**
     * @return string
     * @throws BadResponseException
     * @throws ClientExceptionInterface
     * @throws DecodingExceptionInterface
     * @throws HttpException
     * @throws InvalidArgumentException
     * @throws Kernel\Exceptions\InvalidArgumentException
     * @throws RedirectionExceptionInterface
     * @throws ServerExceptionInterface
     * @throws TransportExceptionInterface
     */
    public function refreshAccessToken(): string
    {
        return $this->getToken();
    }

    /**
     * @link https://developer.open-douyin.com/docs/resource/zh-CN/mini-app/develop/server/interface-request-credential/non-user-authorization/get-client_token
     * @return string
     * @throws BadResponseException
     * @throws ClientExceptionInterface
     * @throws DecodingExceptionInterface
     * @throws HttpException
     * @throws InvalidArgumentException
     * @throws Kernel\Exceptions\InvalidArgumentException
     * @throws RedirectionExceptionInterface
     * @throws ServerExceptionInterface
     * @throws TransportExceptionInterface
     */
    public function getToken(): string
    {
        $response = $this->request(
            "POST",
            'cgi-bin/stable_token',
            [
                'json' => [
                    'grant_type' => 'client_credential',
                    'appid' => $this->appId,
                    'secret' => $this->secret,
                    'force_refresh' => $this->forceRefresh
                ],
            ]
        )->toArray(false);
        if (empty($response['access_token'])) {
            throw new HttpException('Failed to get access_token: ' . json_encode($response, JSON_UNESCAPED_UNICODE));
        }
        $this->cache->set($this->getKey(),
            $response['access_token'],
            intval($response['expires_in']));

        return $response['access_token'];
    }

    public function getAccessToken(): string
    {
        $token = $this->cache->get($this->getKey());

        if ((bool)$token && is_string($token) && !$this->forceRefresh) {
            return $token;
        }

        return $this->refreshAccessToken();
    }

    public function toAccessTokenQuery(): array
    {
        return ['access_token' => $this->getAccessToken()];
    }
}
