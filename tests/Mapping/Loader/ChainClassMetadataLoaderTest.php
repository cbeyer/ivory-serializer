<?php

/*
 * This file is part of the Ivory Serializer package.
 *
 * (c) Eric GELOEN <geloen.eric@gmail.com>
 *
 * For the full copyright and license information, please read the LICENSE
 * file that was distributed with this source code.
 */

namespace Ivory\Tests\Serializer\Mapping\Loader;

use Ivory\Serializer\Mapping\ClassMetadata;
use Ivory\Serializer\Mapping\Loader\ChainClassMetadataLoader;
use Ivory\Serializer\Mapping\Loader\ClassMetadataLoaderInterface;
use Ivory\Serializer\Mapping\Loader\MappedClassMetadataLoaderInterface;

/**
 * @author GeLo <geloen.eric@gmail.com>
 */
class ChainClassMetadataLoaderTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @var ChainClassMetadataLoader
     */
    private $loader;

    /**
     * @var ClassMetadataLoaderInterface|\PHPUnit\Framework\MockObject\MockObject
     */
    private $firstLoader;

    /**
     * @var MappedClassMetadataLoaderInterface|\PHPUnit\Framework\MockObject\MockObject
     */
    private $secondLoader;

    /**
     * {@inheritdoc}
     */
    protected function setUp(): void
    {
        $this->firstLoader = $this->createClassMetadataLoaderMock();
        $this->secondLoader = $this->createMappedClassMetadataLoaderMock();

        $this->loader = new ChainClassMetadataLoader([$this->firstLoader, $this->secondLoader]);
    }

    public function testInheritance(): void
    {
        self::assertInstanceOf(ClassMetadataLoaderInterface::class, $this->loader);
    }

    public function testClassMetadata(): void
    {
        $classMetadata = new ClassMetadata(\stdClass::class);

        $this->firstLoader
            ->expects(self::once())
            ->method('loadClassMetadata')
            ->with(self::identicalTo($classMetadata))
            ->will(self::returnValue(false));

        $this->secondLoader
            ->expects(self::once())
            ->method('loadClassMetadata')
            ->with(self::identicalTo($classMetadata))
            ->will(self::returnValue(true));

        self::assertTrue($this->loader->loadClassMetadata($classMetadata));
    }

    public function testClassMetadataNotFound(): void
    {
        $classMetadata = new ClassMetadata(\stdClass::class);

        $this->firstLoader
            ->expects(self::once())
            ->method('loadClassMetadata')
            ->with(self::identicalTo($classMetadata))
            ->will(self::returnValue(false));

        $this->secondLoader
            ->expects(self::once())
            ->method('loadClassMetadata')
            ->with(self::identicalTo($classMetadata))
            ->will(self::returnValue(false));

        self::assertFalse($this->loader->loadClassMetadata($classMetadata));
    }

    public function testMappedClasses(): void
    {
        $this->secondLoader
            ->expects(self::once())
            ->method('getMappedClasses')
            ->will(self::returnValue($classes = [\stdClass::class]));

        self::assertSame($classes, $this->loader->getMappedClasses());
    }

    /**
     * @return \PHPUnit\Framework\MockObject\MockObject|ClassMetadataLoaderInterface
     */
    private function createClassMetadataLoaderMock()
    {
        return $this->createMock(ClassMetadataLoaderInterface::class);
    }

    /**
     * @return \PHPUnit\Framework\MockObject\MockObject|MappedClassMetadataLoaderInterface
     */
    private function createMappedClassMetadataLoaderMock()
    {
        return $this->createMock(MappedClassMetadataLoaderInterface::class);
    }
}
