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

use Hyperf\Collection\Arr;
use Hyperf\Collection\Collection;
use Hyperf\Context\Context;
use Hyperf\Contract\Arrayable;
use Hyperf\HttpServer\Response as BaseResponse;
use InvinbgHyperf\HttpMessage\Contracts\ResponseInterface;
use Psr\Http\Message\ResponseInterface as PsrResponseInterface;
use function Hyperf\Support\value;

/**
 * @property Collection $data
 * @property int $code
 */
class Response extends BaseResponse implements ResponseInterface
{
    public function __construct(?PsrResponseInterface $response = null)
    {
        parent::__construct($response);
        $this->data = new Collection();
    }

    public function __get(string $name)
    {
        return $this->getResponseProperty($name);
    }

    public function __set(string $name, mixed $value)
    {
        $this->storeResponseProperty($name, $value);
    }

    public function withCode(int $code = 200): static
    {
        $this->code = $code;

        return $this;
    }

    /**
     * 设置Response的数据.
     * @param mixed $override
     * @return $this
     */
    public function withData(mixed $data, bool $override = false): static
    {
        $data ??= [];
        if ($data instanceof Arrayable) {
            $data = $data->toArray();
        }
        $isList = Arr::isList($data);
        foreach ((array) $data as $key => $value) {
            if ($isList && $this->data->has($key) && ! $override) {
                $this->data = $this->data->push($value);
                continue;
            }
            $this->data = $this->data->put($key, $value);
        }

        return $this;
    }

    /**
     * 成功返回.
     */
    public function success(string $message = '请求成功'): PsrResponseInterface
    {
        $data = [
            'code' => $this->code ?? 200,
            'data' => $this->data,
            'message' => $message,
        ];
        return $this->json($data)->withStatus(200);
    }

    /**
     * 失败返回.
     */
    public function error(string $message = '请求失败', bool $withStatus = true): PsrResponseInterface
    {
        $code = $this->code ?? 500;
        // http status 4xx 5xx
        if ($code < 400 || $code > 510) {
            $code = 500;
        }
        return $this->json([
            'code' => $code,
            'data' => $this->data,
            'message' => $message,
        ])->withStatus($withStatus ? $code : 200);
    }

    protected function storeResponseProperty(string $key, mixed $value): static
    {
        Context::set(__CLASS__ . '.properties.' . $key, value($value));
        return $this;
    }

    protected function getResponseProperty(string $key): mixed
    {
        return Context::get(__CLASS__ . '.properties.' . $key);
    }
}
