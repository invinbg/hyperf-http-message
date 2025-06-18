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

use Hyperf\HttpServer\Contract\ResponseInterface as BaseResponseInterface;
use Psr\Http\Message\ResponseInterface as PsrResponseInterface;

/**
 * Class Response.
 */
interface ResponseInterface extends PsrResponseInterface, BaseResponseInterface
{
    /**
     * 设置返回内容code值
     */
    public function withCode(int $code = 200): static;

    /**
     * 设置返回内容data值
     */
    public function withData(mixed $data, bool $override = false): static;

    /**
     * 成功返回.
     */
    public function success(string $message = '请求成功'): PsrResponseInterface;

    /**
     * 失败返回.
     */
    public function error(string $message = '请求失败', bool $withStatus = true): PsrResponseInterface;
}
