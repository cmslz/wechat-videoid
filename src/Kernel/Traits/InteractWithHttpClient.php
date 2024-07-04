<?php
/**
 * Each engineer has a duty to keep the code elegant
 * Created by xiaobai at 2024/5/29 下午6:17
 */

namespace Cmslz\WechatVideoid\Kernel\Traits;

use Cmslz\WechatVideoid\Kernel\HttpClient\RequestUtil;
use Cmslz\WechatVideoid\Kernel\Support\Arr;
use Psr\Log\LoggerAwareInterface;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Component\HttpClient\ScopingHttpClient;
use Symfony\Contracts\HttpClient\HttpClientInterface;

trait InteractWithHttpClient
{
    protected ?HttpClientInterface $httpClient = null;

    public function getHttpClient(): HttpClientInterface
    {
        if (!$this->httpClient) {
            $this->httpClient = $this->createHttpClient();
        }

        return $this->httpClient;
    }

    public function setHttpClient(HttpClientInterface $httpClient): static
    {
        $this->httpClient = $httpClient;

        if ($this instanceof LoggerAwareInterface && $httpClient instanceof LoggerAwareInterface
            && property_exists($this, 'logger')
            && $this->logger) {
            $httpClient->setLogger($this->logger);
        }

        return $this;
    }

    protected function createHttpClient(): HttpClientInterface
    {
        $options = $this->getHttpClientDefaultOptions();

        $optionsByRegexp = Arr::get($options, 'options_by_regexp', []);
        unset($options['options_by_regexp']);
        $client = HttpClient::create(RequestUtil::formatDefaultOptions($options));
        if (! empty($optionsByRegexp)) {
            $client = new ScopingHttpClient($client, $optionsByRegexp);
        }

        return $client;
    }

    /**
     * @return array<string,mixed>
     */
    protected function getHttpClientDefaultOptions(): array
    {
        return [];
    }
}