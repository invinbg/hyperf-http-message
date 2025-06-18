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

use InvinbgHyperf\HttpMessage\Contracts\RequestInterface;
use InvinbgHyperf\HttpMessage\Contracts\ResponseInterface;

class ConfigProvider
{
    public function __invoke(): array
    {
        return [
            'dependencies' => [
                RequestInterface::class => Request::class,
                ResponseInterface::class => Response::class,
            ],
        ];
    }
}
