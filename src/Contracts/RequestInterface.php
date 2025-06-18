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

namespace InvinbgHyperf\HttpMessage\Contracts;

use Closure;
use Hyperf\HttpServer\Contract\RequestInterface as BaseRequestInterface;

interface RequestInterface extends BaseRequestInterface
{
    /**
     * 当前登录用户.
     */
    public function user(?string $guard = null): mixed;

    /**
     * header 中的 bearer token.
     */
    public function bearerToken(): ?string;

    public function getUserResolver(): Closure;

    public function setUserResolver(Closure $callback): static;

    public function ip(): ?string;
}
