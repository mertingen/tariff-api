<?php

namespace App\Service;

use Redis;

/**
 * @method string|mixed|false get($key)
 * @method bool set($key, $value, $timeout = null)
 * @method bool setEx($key, $ttl, $value)
 * @method int del($key1, ...$otherKeys)
 * @method string[] keys(string $pattern)
 * @method int|bool|Redis exists($key)
 * @method bool sAdd($key, $member)
 * @method bool sRem($key, $member)
 * @method array sMembers($key)
 * @method bool sIsMember($key, $member)
 * @method int sCard($key)
 */
class RedisService
{
    /**
     * RedisService constructor.
     *
     * @param Redis $redis A Redis instance.
     */
    public function __construct(private readonly Redis $redis)
    {
    }

    /**
     * Proxy method calls to the Redis instance.
     *
     * @param string $name      Method name.
     * @param array  $arguments Method arguments.
     *
     * @return mixed Result of the method call on Redis.
     */
    public function __call(string $name, array $arguments)
    {
        return $this->redis->$name(...$arguments);
    }

}