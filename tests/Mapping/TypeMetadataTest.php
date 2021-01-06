<?php

/*
 * This file is part of the Ivory Serializer package.
 *
 * (c) Eric GELOEN <geloen.eric@gmail.com>
 *
 * For the full copyright and license information, please read the LICENSE
 * file that was distributed with this source code.
 */

namespace Ivory\Tests\Serializer\Mapping;

use Ivory\Serializer\Mapping\TypeMetadata;
use Ivory\Serializer\Mapping\TypeMetadataInterface;
use Ivory\Serializer\Type\Type;

/**
 * @author GeLo <geloen.eric@gmail.com>
 */
class TypeMetadataTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @var TypeMetadata
     */
    private $typeMetadata;

    /**
     * @var string
     */
    private $name;

    /**
     * {@inheritdoc}
     */
    protected function setUp(): void
    {
        $this->name = Type::STRING;
        $this->typeMetadata = new TypeMetadata($this->name);
    }

    public function testInheritance(): void
    {
        self::assertInstanceOf(TypeMetadataInterface::class, $this->typeMetadata);
    }

    public function testDefaultState(): void
    {
        self::assertSame($this->name, $this->typeMetadata->getName());
        self::assertFalse($this->typeMetadata->hasOptions());
        self::assertEmpty($this->typeMetadata->getOptions());
    }

    public function testName(): void
    {
        $this->typeMetadata->setName($name = Type::BOOL);

        self::assertSame($name, $this->typeMetadata->getName());
    }

    public function testSetOptions(): void
    {
        $this->typeMetadata->setOptions($options = [$option = 'foo' => $value = 'bar']);

        self::assertTrue($this->typeMetadata->hasOptions());
        self::assertTrue($this->typeMetadata->hasOption($option));
        self::assertSame($options, $this->typeMetadata->getOptions());
        self::assertSame($value, $this->typeMetadata->getOption($option));
    }

    public function testSetOption(): void
    {
        $this->typeMetadata->setOption($option = 'foo', $value = 'bar');

        self::assertTrue($this->typeMetadata->hasOptions());
        self::assertTrue($this->typeMetadata->hasOption($option));
        self::assertSame([$option => $value], $this->typeMetadata->getOptions());
        self::assertSame($value, $this->typeMetadata->getOption($option));
    }

    public function testRemoveOption(): void
    {
        $this->typeMetadata->setOption($option = 'foo', 'bar');
        $this->typeMetadata->removeOption($option);

        self::assertFalse($this->typeMetadata->hasOptions());
        self::assertFalse($this->typeMetadata->hasOption($option));
        self::assertEmpty($this->typeMetadata->getOptions());
        self::assertNull($this->typeMetadata->getOption($option));
        self::assertSame('bat', $this->typeMetadata->getOption($option, 'bat'));
    }

    public function testSerialize(): void
    {
        self::assertEquals($this->typeMetadata, unserialize(serialize($this->typeMetadata)));
    }
}
