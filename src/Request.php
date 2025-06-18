<?php

declare(strict_types=1);
/**
 * This file is part of InvinbgHyperf/HttpMessage.
 *
 * @link     https://www.hyperf.io
 * @document https://hyperf.wiki
 * @contact  group@hyperf.io
 * @license  https://github.com/hyperf/hyperf/blob/master/LICENSE
 */

namespace InvinbgHyperf\HttpMessage;

use Closure;
use Hyperf\HttpServer\Request as BaseRequest;
use Hyperf\Stringable\Str;
use InvinbgHyperf\HttpMessage\Contracts\RequestInterface;

/**
 * @property Closure $userResolver
 */
class Request extends BaseRequest implements RequestInterface
{
    public function user(?string $guard = null): mixed
    {
        return call_user_func($this->getUserResolver(), $guard);
    }

    /**
     * Get the user resolver callback.
     */
    public function getUserResolver(): Closure
    {
        return $this->userResolver ?? function ($guard) {
            return null;
        };
    }

    /**
     * Set the user resolver callback.
     *
     * @return $this
     */
    public function setUserResolver(Closure $callback): static
    {
        $this->userResolver = $callback;

        return $this;
    }

    /**
     * 获取token.
     */
    public function bearerToken(): ?string
    {
        $header = $this->getHeaderLine('Authorization') ?? '';

        if (Str::startsWith($header, 'Bearer ')) {
            return Str::substr($header, 7);
        }

        return null;
    }

    public function ip(): ?string
    {
        if (! empty($this->getHeaderLine('x-forwarded-for'))) {
            return $this->getHeaderLine('x-forwarded-for');
        }
        if (! empty($this->getHeaderLine('x-real-ip'))) {
            return $this->getHeaderLine('x-real-ip');
        }
        $serverParams = $this->getServerParams();
        return $serverParams['remote_addr'] ?? null;
    }
}
