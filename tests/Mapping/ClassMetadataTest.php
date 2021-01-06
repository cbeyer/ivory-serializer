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

use Ivory\Serializer\Mapping\ClassMetadata;
use Ivory\Serializer\Mapping\ClassMetadataInterface;
use Ivory\Serializer\Mapping\PropertyMetadataInterface;

/**
 * @author GeLo <geloen.eric@gmail.com>
 */
class ClassMetadataTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @var ClassMetadata
     */
    private $classMetadata;

    /**
     * @var string
     */
    private $name;

    /**
     * {@inheritdoc}
     */
    protected function setUp(): void
    {
        $this->name = \stdClass::class;
        $this->classMetadata = new ClassMetadata($this->name);
    }

    public function testInheritance(): void
    {
        self::assertInstanceOf(ClassMetadataInterface::class, $this->classMetadata);
    }

    public function testDefaultState(): void
    {
        self::assertSame($this->name, $this->classMetadata->getName());
        self::assertFalse($this->classMetadata->hasProperties());
        self::assertEmpty($this->classMetadata->getProperties());

        self::assertFalse($this->classMetadata->hasXmlRoot());
        self::assertNull($this->classMetadata->getXmlRoot());
    }

    public function testSetProperties(): void
    {
        $properties = [$name = 'foo' => $property = $this->createPropertyMetadataMock($name)];

        $this->classMetadata->setProperties($properties);
        $this->classMetadata->setProperties($properties);

        self::assertTrue($this->classMetadata->hasProperties());
        self::assertTrue($this->classMetadata->hasProperty($name));
        self::assertSame($property, $this->classMetadata->getProperty($name));
        self::assertSame($properties, $this->classMetadata->getProperties());
    }

    public function testAddProperty(): void
    {
        $this->classMetadata->addProperty($property = $this->createPropertyMetadataMock($name = 'foo'));

        self::assertTrue($this->classMetadata->hasProperties());
        self::assertTrue($this->classMetadata->hasProperty($name));
        self::assertSame($property, $this->classMetadata->getProperty($name));
        self::assertSame([$name => $property], $this->classMetadata->getProperties());
    }

    public function testAddPropertyMerge(): void
    {
        $firstProperty = $this->createPropertyMetadataMock($name = 'foo');
        $secondProperty = $this->createPropertyMetadataMock($name);

        $firstProperty
            ->expects(self::once())
            ->method('merge')
            ->with(self::identicalTo($secondProperty));

        $this->classMetadata->addProperty($firstProperty);
        $this->classMetadata->addProperty($secondProperty);

        self::assertTrue($this->classMetadata->hasProperties());
        self::assertTrue($this->classMetadata->hasProperty($name));
        self::assertSame($firstProperty, $this->classMetadata->getProperty($name));
        self::assertNotSame($secondProperty, $this->classMetadata->getProperty($name));
        self::assertSame([$name => $firstProperty], $this->classMetadata->getProperties());
    }

    public function testRemoveProperty(): void
    {
        $this->classMetadata->addProperty($property = $this->createPropertyMetadataMock($name = 'foo'));
        $this->classMetadata->removeProperty($name);

        self::assertFalse($this->classMetadata->hasProperties());
        self::assertFalse($this->classMetadata->hasProperty($name));
        self::assertNull($this->classMetadata->getProperty($name));
        self::assertEmpty($this->classMetadata->getProperties());
    }

    public function testXmlRoot(): void
    {
        $this->classMetadata->setXmlRoot($xmlRoot = 'root');

        self::assertTrue($this->classMetadata->hasXmlRoot());
        self::assertSame($xmlRoot, $this->classMetadata->getXmlRoot());
    }

    public function testMerge(): void
    {
        $firstProperty = $this->createPropertyMetadataMock($firstName = 'foo');
        $secondProperty = $this->createPropertyMetadataMock($firstName);
        $thirdProperty = $this->createPropertyMetadataMock($thirdName = 'bar');

        $classMetadata = new ClassMetadata(\stdClass::class);
        $classMetadata->addProperty($secondProperty);
        $classMetadata->addProperty($thirdProperty);
        $classMetadata->setXmlRoot($xmlRoot = 'root');

        $firstProperty
            ->expects(self::once())
            ->method('merge')
            ->with(self::identicalTo($secondProperty));

        $this->classMetadata->addProperty($firstProperty);
        $this->classMetadata->merge($classMetadata);

        self::assertSame(
            [$firstName => $firstProperty, $thirdName => $thirdProperty],
            $this->classMetadata->getProperties()
        );

        self::assertSame($xmlRoot, $this->classMetadata->getXmlRoot());
    }

    public function testSerialize(): void
    {
        self::assertEquals($this->classMetadata, unserialize(serialize($this->classMetadata)));
    }

    /**
     * @param string $name
     *
     * @return \PHPUnit\Framework\MockObject\MockObject|PropertyMetadataInterface
     */
    private function createPropertyMetadataMock($name)
    {
        $propertyMetadata = $this->createMock(PropertyMetadataInterface::class);
        $propertyMetadata
            ->expects($this->any())
            ->method('getName')
            ->will(self::returnValue($name));

        return $propertyMetadata;
    }
}
