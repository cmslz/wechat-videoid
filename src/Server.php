<?php

declare(strict_types=1);

namespace Cmslz\WechatVideoid;

use Closure;
use Cmslz\WechatVideoid\Kernel\Contracts\Server as ServerInterface;
use Cmslz\WechatVideoid\Kernel\Encryptor;
use Cmslz\WechatVideoid\Kernel\Exceptions\BadRequestException;
use Cmslz\WechatVideoid\Kernel\Exceptions\InvalidArgumentException;
use Cmslz\WechatVideoid\Kernel\Exceptions\RuntimeException;
use Cmslz\WechatVideoid\Kernel\HttpClient\RequestUtil;
use Cmslz\WechatVideoid\Kernel\Message;
use Cmslz\WechatVideoid\Kernel\ServerResponse;
use Cmslz\WechatVideoid\Kernel\Traits\DecryptXmlMessage;
use Cmslz\WechatVideoid\Kernel\Traits\InteractWithHandlers;
use Cmslz\WechatVideoid\Kernel\Traits\RespondXmlMessage;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;
use Throwable;
use Nyholm\Psr7\Response;

class Server implements ServerInterface
{
    use RespondXmlMessage;
    use DecryptXmlMessage;
    use InteractWithHandlers;

    protected ServerRequestInterface $request;

    /**
     * @throws Throwable
     */
    public function __construct(
        ServerRequestInterface $request = null,
        protected ?Encryptor $encryptor = null,
    ) {
        $this->request = $request ?? RequestUtil::createDefaultServerRequest();
    }

    /**
     * @throws InvalidArgumentException
     * @throws BadRequestException
     * @throws RuntimeException
     */
    public function serve(): ResponseInterface
    {
        if ((bool) ($str = $this->request->getQueryParams()['echostr'] ?? '')) {
            return new Response(200, [], $str);
        }

        $message = $this->getRequestMessage($this->request);
        $query = $this->request->getQueryParams();

        if ($this->encryptor && ! empty($query['msg_signature'])) {
            $this->prepend($this->decryptRequestMessage($query));
        }

        $response = $this->handle(new Response(200, [], 'success'), $message);

        if (! ($response instanceof ResponseInterface)) {
            $response = $this->transformToReply($response, $message, $this->encryptor);
        }

        return ServerResponse::make($response);
    }

    /**
     * @throws Throwable
     */
    public function addMessageListener(string $type, callable|string $handler): static
    {
        $handler = $this->makeClosure($handler);
        $this->withHandler(
            function (Message $message, Closure $next) use ($type, $handler): mixed {
                return $message->MsgType === $type ? $handler($message, $next) : $next($message);
            }
        );

        return $this;
    }

    /**
     * @throws Throwable
     */
    public function addEventListener(string $event, callable|string $handler): static
    {
        $handler = $this->makeClosure($handler);
        $this->withHandler(
            function (Message $message, Closure $next) use ($event, $handler): mixed {
                return $message->Event === $event ? $handler($message, $next) : $next($message);
            }
        );

        return $this;
    }

    /**
     * @param  array<string,string>  $query
     *
     * @psalm-suppress PossiblyNullArgument
     */
    protected function decryptRequestMessage(array $query): Closure
    {
        return function (Message $message, Closure $next) use ($query): mixed {
            if (! $this->encryptor) {
                return null;
            }

            $this->decryptMessage(
                message: $message,
                encryptor: $this->encryptor,
                signature: $query['msg_signature'] ?? '',
                timestamp: $query['timestamp'] ?? '',
                nonce: $query['nonce'] ?? ''
            );

            return $next($message);
        };
    }

    /**
     * @throws BadRequestException
     */
    public function getRequestMessage(ServerRequestInterface $request = null): \Cmslz\WechatVideoid\Kernel\Message
    {
        return Message::createFromRequest($request ?? $this->request);
    }

    /**
     * @throws BadRequestException
     * @throws RuntimeException
     */
    public function getDecryptedMessage(ServerRequestInterface $request = null): \Cmslz\WechatVideoid\Kernel\Message
    {
        $request = $request ?? $this->request;
        $message = $this->getRequestMessage($request);
        $query = $request->getQueryParams();

        if (! $this->encryptor || empty($query['msg_signature'])) {
            return $message;
        }

        return $this->decryptMessage(
            message: $message,
            encryptor: $this->encryptor,
            signature: $query['msg_signature'],
            timestamp: $query['timestamp'] ?? '',
            nonce: $query['nonce'] ?? ''
        );
    }
}