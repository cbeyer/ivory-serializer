<?php

/*
 * This file is part of the Ivory Serializer package.
 *
 * (c) Eric GELOEN <geloen.eric@gmail.com>
 *
 * For the full copyright and license information, please read the LICENSE
 * file that was distributed with this source code.
 */

namespace Ivory\Tests\Serializer\Naming;

use Ivory\Serializer\Naming\CacheNamingStrategy;
use Ivory\Serializer\Naming\NamingStrategyInterface;
use Psr\Cache\CacheItemInterface;
use Psr\Cache\CacheItemPoolInterface;

/**
 * @author GeLo <geloen.eric@gmail.com>
 */
class CacheNamingStrategyTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @var CacheNamingStrategy
     */
    private $cacheNamingStrategy;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|NamingStrategyInterface
     */
    private $namingStrategy;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|CacheItemPoolInterface
     */
    private $pool;

    /**
     * {@inheritdoc}
     */
    protected function setUp(): void
    {
        $this->pool = $this->createCacheItemPoolMock();
        $this->namingStrategy = $this->createNamingStrategyMock();

        $this->cacheNamingStrategy = new CacheNamingStrategy($this->namingStrategy, $this->pool);
    }

    public function testCacheHit(): void
    {
        $this->pool
            ->expects(self::once())
            ->method('getItem')
            ->with(self::identicalTo($name = 'fooBar'))
            ->will(self::returnValue($item = $this->createCacheItemMock()));

        $item
            ->expects(self::once())
            ->method('isHit')
            ->will(self::returnValue(true));

        $item
            ->expects(self::once())
            ->method('get')
            ->will(self::returnValue($result = 'foo_bar'));

        $this->namingStrategy
            ->expects($this->never())
            ->method('convert');

        self::assertSame($result, $this->cacheNamingStrategy->convert($name));
    }

    public function testCacheMiss(): void
    {
        $this->pool
            ->expects(self::once())
            ->method('getItem')
            ->with(self::identicalTo($name = 'fooBar'))
            ->will(self::returnValue($item = $this->createCacheItemMock()));

        $item
            ->expects(self::once())
            ->method('isHit')
            ->will(self::returnValue(false));

        $this->namingStrategy
            ->expects(self::once())
            ->method('convert')
            ->with(self::identicalTo($name))
            ->will(self::returnValue($result = 'foo_bar'));

        $item
            ->expects(self::once())
            ->method('set')
            ->with(self::identicalTo($result))
            ->will($this->returnSelf());

        $this->pool
            ->expects(self::once())
            ->method('save')
            ->with(self::identicalTo($item));

        self::assertSame($result, $this->cacheNamingStrategy->convert($name));
    }

    /**
     * @return \PHPUnit\Framework\MockObject\MockObject|NamingStrategyInterface
     */
    private function createNamingStrategyMock()
    {
        return $this->createMock(NamingStrategyInterface::class);
    }

    /**
     * @return \PHPUnit\Framework\MockObject\MockObject|CacheItemPoolInterface
     */
    private function createCacheItemPoolMock()
    {
        return $this->createMock(CacheItemPoolInterface::class);
    }

    /**
     * @return \PHPUnit\Framework\MockObject\MockObject|CacheItemInterface
     */
    private function createCacheItemMock()
    {
        return $this->createMock(CacheItemInterface::class);
    }
}
