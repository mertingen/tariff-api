<?php

namespace App\Tests;

use App\Service\RedisService;
use PHPUnit\Framework\TestCase;
use Redis;

class RedisServiceTest extends TestCase
{
    private RedisService $redisService;
    private Redis|\PHPUnit\Framework\MockObject\MockObject $mockRedis;

    protected function setUp(): void
    {
        parent::setUp();

        // Create a mock instance of Redis
        $this->mockRedis = $this->createMock(Redis::class);

        // Inject the mock Redis instance into the RedisService
        $this->redisService = new RedisService($this->mockRedis);
    }

    public function testSetAndGet()
    {
        $key = 'test_key';
        $value = 'test_value';
        $timeout = 3600;

        // Expect the `set` method to be called once with specific arguments and return true
        $this->mockRedis->expects($this->once())
            ->method('set')
            ->with($key, $value, $timeout)
            ->willReturn(true);

        // Call `set` method on RedisService and assert
        $this->redisService->set($key, $value, $timeout);

        // Expect the `get` method to be called once with the key and return the value
        $this->mockRedis->expects($this->once())
            ->method('get')
            ->with($key)
            ->willReturn($value);

        // Call `get` method on RedisService and assert the returned value
        $this->assertEquals($value, $this->redisService->get($key));
    }
}
