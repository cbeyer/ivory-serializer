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

use Ivory\Serializer\Mapping\ClassMetadata;
use Ivory\Serializer\Mapping\Factory\ClassMetadataFactory;
use Ivory\Serializer\Mapping\Factory\ClassMetadataFactoryInterface;
use Ivory\Serializer\Mapping\Loader\ClassMetadataLoaderInterface;
use Ivory\Tests\Serializer\Fixture\ExtendedScalarFixture;
use Ivory\Tests\Serializer\Fixture\ScalarFixture;

/**
 * @author GeLo <geloen.eric@gmail.com>
 */
class ClassMetadataFactoryTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @var ClassMetadataFactory
     */
    private $factory;

    /**
     * @var ClassMetadataLoaderInterface|\PHPUnit\Framework\MockObject\MockObject
     */
    private $loader;

    /**
     * {@inheritdoc}
     */
    protected function setUp(): void
    {
        $this->loader = $this->createClassMetadataLoaderMock();
        $this->factory = new ClassMetadataFactory($this->loader);
    }

    public function testInheritance(): void
    {
        self::assertInstanceOf(ClassMetadataFactoryInterface::class, $this->factory);
    }

    public function testClassMetadata(): void
    {
        $class = \stdClass::class;
        $expected = null;

        $this->loader
            ->expects(self::once())
            ->method('loadClassMetadata')
            ->with(self::callback(function ($classMetadata) use ($class, &$expected) {
                $expected = $classMetadata;

                return $classMetadata instanceof ClassMetadata && $classMetadata->getName() === $class;
            }))
            ->will(self::returnValue(true));

        $firstResult = $this->factory->getClassMetadata($class);
        $secondResult = $this->factory->getClassMetadata($class);

        self::assertSame($expected, $firstResult);
        self::assertSame($expected, $secondResult);
    }

    public function testClassMetadataInheritance(): void
    {
        $expected = [];

        $this->loader
            ->expects($this->exactly(2))
            ->method('loadClassMetadata')
            ->with(self::callback(function ($classMetadata) use (&$expected) {
                $expected[] = $classMetadata;

                return $classMetadata instanceof ClassMetadata;
            }))
            ->will(self::returnValue(true));

        $firstResult = $this->factory->getClassMetadata($class = ExtendedScalarFixture::class);
        $secondResult = $this->factory->getClassMetadata($class);

        self::assertArrayHasKey(0, $expected);
        self::assertSame(ScalarFixture::class, $expected[0]->getName());

        self::assertArrayHasKey(1, $expected);
        self::assertSame($class, $expected[1]->getName());

        self::assertSame($expected[1], $firstResult);
        self::assertSame($expected[1], $secondResult);
    }

    public function testClassMetadataDoesNotExist(): void
    {
        $class = \stdClass::class;

        $this->loader
            ->expects(self::once())
            ->method('loadClassMetadata')
            ->with(self::callback(function ($classMetadata) use ($class) {
                return $classMetadata instanceof ClassMetadata && $classMetadata->getName() === $class;
            }))
            ->will(self::returnValue(false));

        self::assertNull($this->factory->getClassMetadata($class));
        self::assertNull($this->factory->getClassMetadata($class));
    }

    public function testClassMetadataInvalid(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->factory->getClassMetadata('foo');
    }

    /**
     * @return \PHPUnit\Framework\MockObject\MockObject|ClassMetadataLoaderInterface
     */
    private function createClassMetadataLoaderMock()
    {
        return $this->createMock(ClassMetadataLoaderInterface::class);
    }
}
