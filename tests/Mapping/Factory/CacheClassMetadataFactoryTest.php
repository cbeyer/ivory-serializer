<?php

/*
 * This file is part of the Ivory Serializer package.
 *
 * (c) Eric GELOEN <geloen.eric@gmail.com>
 *
 * For the full copyright and license information, please read the LICENSE
 * file that was distributed with this source code.
 */

namespace Ivory\Tests\Serializer\Mapping\Factory;

use Ivory\Serializer\Mapping\ClassMetadataInterface;
use Ivory\Serializer\Mapping\Factory\CacheClassMetadataFactory;
use Ivory\Serializer\Mapping\Factory\ClassMetadataFactoryInterface;
use Psr\Cache\CacheItemInterface;
use Psr\Cache\CacheItemPoolInterface;

/**
 * @author GeLo <geloen.eric@gmail.com>
 */
class CacheClassMetadataFactoryTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @var CacheClassMetadataFactory
     */
    private $cacheFactory;

    /**
     * @var ClassMetadataFactoryInterface|\PHPUnit\Framework\MockObject\MockObject
     */
    private $factory;

    /**
     * @var CacheItemPoolInterface|\PHPUnit\Framework\MockObject\MockObject
     */
    private $pool;

    /**
     * {@inheritdoc}
     */
    protected function setUp(): void
    {
        $this->factory = $this->createClassMetadataFactoryMock();
        $this->pool = $this->createCacheItemPoolMock();

        $this->cacheFactory = new CacheClassMetadataFactory($this->factory, $this->pool);
    }

    public function testInheritance(): void
    {
        self::assertInstanceOf(ClassMetadataFactoryInterface::class, $this->cacheFactory);
    }

    public function testClassMetadata(): void
    {
        $this->pool
            ->expects(self::once())
            ->method('getItem')
            ->with(self::identicalTo('foo_bar'))
            ->will(self::returnValue($item = $this->createCacheItemMock()));

        $item
            ->expects(self::once())
            ->method('isHit')
            ->will(self::returnValue(false));

        $this->factory
            ->expects(self::once())
            ->method('getClassMetadata')
            ->with(self::identicalTo($class = 'foo\bar'))
            ->will(self::returnValue($classMetadata = $this->createClassMetadataMock()));

        $item
            ->expects(self::once())
            ->method('set')
            ->with(self::identicalTo($classMetadata))
            ->will($this->returnSelf());

        $this->pool
            ->expects(self::once())
            ->method('save')
            ->with(self::identicalTo($item));

        self::assertSame($classMetadata, $this->cacheFactory->getClassMetadata($class));
    }

    public function testClassMetadataCached(): void
    {
        $this->pool
            ->expects(self::once())
            ->method('getItem')
            ->with(self::identicalTo('foo_bar'))
            ->will(self::returnValue($item = $this->createCacheItemMock()));

        $item
            ->expects(self::once())
            ->method('isHit')
            ->will(self::returnValue(true));

        $item
            ->expects(self::once())
            ->method('get')
            ->will(self::returnValue($classMetadata = $this->createClassMetadataMock()));

        $this->factory
            ->expects($this->never())
            ->method('getClassMetadata');

        self::assertSame($classMetadata, $this->cacheFactory->getClassMetadata('foo\bar'));
    }

    /**
     * @return \PHPUnit\Framework\MockObject\MockObject|ClassMetadataFactoryInterface
     */
    private function createClassMetadataFactoryMock()
    {
        return $this->createMock(ClassMetadataFactoryInterface::class);
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

    /**
     * @return \PHPUnit\Framework\MockObject\MockObject|ClassMetadataInterface
     */
    private function createClassMetadataMock()
    {
        return $this->createMock(ClassMetadataInterface::class);
    }
}
