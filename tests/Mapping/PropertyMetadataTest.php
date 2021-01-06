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

use Ivory\Serializer\Mapping\PropertyMetadata;
use Ivory\Serializer\Mapping\PropertyMetadataInterface;
use Ivory\Serializer\Mapping\TypeMetadataInterface;

/**
 * @author GeLo <geloen.eric@gmail.com>
 */
class PropertyMetadataTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @var PropertyMetadata
     */
    private $propertyMetadata;

    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $class;

    /**
     * {@inheritdoc}
     */
    protected function setUp(): void
    {
        $this->name = 'foo';
        $this->class = 'bar';

        $this->propertyMetadata = new PropertyMetadata($this->name, $this->class);
    }

    public function testInheritance(): void
    {
        self::assertInstanceOf(PropertyMetadataInterface::class, $this->propertyMetadata);
    }

    public function testDefaultState(): void
    {
        self::assertSame($this->name, $this->propertyMetadata->getName());
        self::assertSame($this->class, $this->propertyMetadata->getClass());
        self::assertFalse($this->propertyMetadata->hasAlias());
        self::assertNull($this->propertyMetadata->getAlias());
        self::assertFalse($this->propertyMetadata->hasType());
        self::assertNull($this->propertyMetadata->getType());
        self::assertTrue($this->propertyMetadata->isReadable());
        self::assertTrue($this->propertyMetadata->isWritable());
        self::assertFalse($this->propertyMetadata->hasAccessor());
        self::assertNull($this->propertyMetadata->getAccessor());
        self::assertFalse($this->propertyMetadata->hasMutator());
        self::assertNull($this->propertyMetadata->getMutator());
        self::assertFalse($this->propertyMetadata->hasSinceVersion());
        self::assertNull($this->propertyMetadata->getSinceVersion());
        self::assertFalse($this->propertyMetadata->hasUntilVersion());
        self::assertNull($this->propertyMetadata->getUntilVersion());
        self::assertFalse($this->propertyMetadata->hasMaxDepth());
        self::assertNull($this->propertyMetadata->getMaxDepth());
        self::assertFalse($this->propertyMetadata->hasGroups());
        self::assertEmpty($this->propertyMetadata->getGroups());
        self::assertFalse($this->propertyMetadata->hasXmlAttribute());
        self::assertFalse($this->propertyMetadata->isXmlAttribute());
        self::assertFalse($this->propertyMetadata->hasXmlValue());
        self::assertFalse($this->propertyMetadata->isXmlValue());
        self::assertFalse($this->propertyMetadata->hasXmlInline());
        self::assertFalse($this->propertyMetadata->isXmlInline());
        self::assertFalse($this->propertyMetadata->hasXmlEntry());
        self::assertNull($this->propertyMetadata->getXmlEntry());
        self::assertFalse($this->propertyMetadata->hasXmlEntryAttribute());
        self::assertNull($this->propertyMetadata->getXmlEntryAttribute());
        self::assertFalse($this->propertyMetadata->hasXmlKeyAsAttribute());
        self::assertNull($this->propertyMetadata->useXmlKeyAsAttribute());
        self::assertFalse($this->propertyMetadata->hasXmlKeyAsNode());
        self::assertNull($this->propertyMetadata->useXmlKeyAsNode());
    }

    public function testName(): void
    {
        $this->propertyMetadata->setName($name = 'bar');

        self::assertSame($name, $this->propertyMetadata->getName());
    }

    public function tesClass()
    {
        $this->propertyMetadata->setClass($name = 'baz');

        self::assertSame($name, $this->propertyMetadata->getClass());
    }

    public function testAlias(): void
    {
        $this->propertyMetadata->setAlias($alias = 'bar');

        self::assertTrue($this->propertyMetadata->hasAlias());
        self::assertSame($alias, $this->propertyMetadata->getAlias());
    }

    public function testType(): void
    {
        $this->propertyMetadata->setType($type = $this->createTypeMetadataMock());

        self::assertTrue($this->propertyMetadata->hasType());
        self::assertSame($type, $this->propertyMetadata->getType());
    }

    public function testReadable(): void
    {
        $this->propertyMetadata->setReadable(false);

        self::assertFalse($this->propertyMetadata->isReadable());
    }

    public function testWritable(): void
    {
        $this->propertyMetadata->setWritable(false);

        self::assertFalse($this->propertyMetadata->isWritable());
    }

    public function testAccessor(): void
    {
        $this->propertyMetadata->setAccessor($accessor = 'foo');

        self::assertTrue($this->propertyMetadata->hasAccessor());
        self::assertSame($accessor, $this->propertyMetadata->getAccessor());
    }

    public function testMutator(): void
    {
        $this->propertyMetadata->setMutator($mutator = 'foo');

        self::assertTrue($this->propertyMetadata->hasMutator());
        self::assertSame($mutator, $this->propertyMetadata->getMutator());
    }

    public function testSinceVersion(): void
    {
        $this->propertyMetadata->setSinceVersion($since = '1.0');

        self::assertTrue($this->propertyMetadata->hasSinceVersion());
        self::assertSame($since, $this->propertyMetadata->getSinceVersion());
    }

    public function testUntilVersion(): void
    {
        $this->propertyMetadata->setUntilVersion($until = '1.0');

        self::assertTrue($this->propertyMetadata->hasUntilVersion());
        self::assertSame($until, $this->propertyMetadata->getUntilVersion());
    }

    public function testMaxDepth(): void
    {
        $this->propertyMetadata->setMaxDepth($maxDepth = 512);

        self::assertTrue($this->propertyMetadata->hasMaxDepth());
        self::assertSame($maxDepth, $this->propertyMetadata->getMaxDepth());
    }

    public function testSetGroups(): void
    {
        $this->propertyMetadata->setGroups($groups = [$group = 'group']);
        $this->propertyMetadata->setGroups($groups);

        self::assertTrue($this->propertyMetadata->hasGroups());
        self::assertTrue($this->propertyMetadata->hasGroup($group));
        self::assertSame($groups, $this->propertyMetadata->getGroups());
    }

    public function testAddGroups(): void
    {
        $this->propertyMetadata->setGroups($firstGroups = ['group1']);
        $this->propertyMetadata->addGroups($secondGroups = ['group2']);

        self::assertTrue($this->propertyMetadata->hasGroups());
        self::assertSame(array_merge($firstGroups, $secondGroups), $this->propertyMetadata->getGroups());
    }

    public function testAddGroup(): void
    {
        $this->propertyMetadata->addGroup($group = 'group');

        self::assertTrue($this->propertyMetadata->hasGroups());
        self::assertTrue($this->propertyMetadata->hasGroup($group));
        self::assertSame([$group], $this->propertyMetadata->getGroups());
    }

    public function testRemoveGroup(): void
    {
        $this->propertyMetadata->addGroup($group = 'group');
        $this->propertyMetadata->removeGroup($group);

        self::assertFalse($this->propertyMetadata->hasGroups());
        self::assertFalse($this->propertyMetadata->hasGroup($group));
        self::assertEmpty($this->propertyMetadata->getGroups());
    }

    public function testXmlAttribute(): void
    {
        $this->propertyMetadata->setXmlAttribute(true);

        self::assertTrue($this->propertyMetadata->hasXmlAttribute());
        self::assertTrue($this->propertyMetadata->isXmlAttribute());
    }

    public function testXmlValue(): void
    {
        $this->propertyMetadata->setXmlValue(true);

        self::assertTrue($this->propertyMetadata->hasXmlValue());
        self::assertTrue($this->propertyMetadata->isXmlValue());
    }

    public function testXmlInline(): void
    {
        $this->propertyMetadata->setXmlInline(true);

        self::assertTrue($this->propertyMetadata->hasXmlInline());
        self::assertTrue($this->propertyMetadata->isXmlInline());
    }

    public function testXmlEntry(): void
    {
        $this->propertyMetadata->setXmlEntry($entry = 'entry');

        self::assertTrue($this->propertyMetadata->hasXmlEntry());
        self::assertSame($entry, $this->propertyMetadata->getXmlEntry());
    }

    public function testXmlEntryAttribute(): void
    {
        $this->propertyMetadata->setXmlEntryAttribute($entryAttribute = 'key');

        self::assertTrue($this->propertyMetadata->hasXmlEntryAttribute());
        self::assertSame($entryAttribute, $this->propertyMetadata->getXmlEntryAttribute());
    }

    public function testXmlKeyAsAttribute(): void
    {
        $this->propertyMetadata->setXmlKeyAsAttribute(true);

        self::assertTrue($this->propertyMetadata->hasXmlKeyAsAttribute());
        self::assertTrue($this->propertyMetadata->useXmlKeyAsAttribute());
    }

    public function testXmlKeyAsNode(): void
    {
        $this->propertyMetadata->setXmlKeyAsNode(true);

        self::assertTrue($this->propertyMetadata->hasXmlKeyAsNode());
        self::assertTrue($this->propertyMetadata->useXmlKeyAsNode());
    }

    public function testMerge(): void
    {
        $propertyMetadata = new PropertyMetadata($name = 'foo', $class = 'bar');
        $propertyMetadata->setAlias($alias = 'baz');
        $propertyMetadata->setType($type = $this->createTypeMetadataMock());
        $propertyMetadata->setReadable(true);
        $propertyMetadata->setWritable(false);
        $propertyMetadata->setAccessor($accessor = 'getFoo');
        $propertyMetadata->setMutator($mutator = 'setFoo');
        $propertyMetadata->setSinceVersion($sinceVersion = '1.0');
        $propertyMetadata->setUntilVersion($untilVersion = '2.0');
        $propertyMetadata->setMaxDepth($maxDepth = 1);
        $propertyMetadata->setGroups($groups = ['group1', 'group2']);
        $propertyMetadata->setXmlAttribute(true);
        $propertyMetadata->setXmlValue(true);
        $propertyMetadata->setXmlInline(true);
        $propertyMetadata->setXmlEntry($entry = 'entry');
        $propertyMetadata->setXmlEntryAttribute($entryAttribute = 'key');
        $propertyMetadata->setXmlKeyAsAttribute(true);
        $propertyMetadata->setXmlKeyAsNode(true);

        $this->propertyMetadata->merge($propertyMetadata);

        self::assertSame($name, $this->propertyMetadata->getName());
        self::assertSame($class, $this->propertyMetadata->getClass());
        self::assertSame($alias, $this->propertyMetadata->getAlias());
        self::assertSame($type, $this->propertyMetadata->getType());
        self::assertTrue($this->propertyMetadata->isReadable());
        self::assertFalse($this->propertyMetadata->isWritable());
        self::assertSame($accessor, $this->propertyMetadata->getAccessor());
        self::assertSame($mutator, $this->propertyMetadata->getMutator());
        self::assertSame($sinceVersion, $this->propertyMetadata->getSinceVersion());
        self::assertSame($untilVersion, $this->propertyMetadata->getUntilVersion());
        self::assertSame($maxDepth, $this->propertyMetadata->getMaxDepth());
        self::assertSame($groups, $this->propertyMetadata->getGroups());
        self::assertTrue($this->propertyMetadata->isXmlAttribute());
        self::assertTrue($this->propertyMetadata->isXmlValue());
        self::assertTrue($this->propertyMetadata->isXmlInline());
        self::assertSame($entry, $this->propertyMetadata->getXmlEntry());
        self::assertSame($entryAttribute, $this->propertyMetadata->getXmlEntryAttribute());
        self::assertTrue($this->propertyMetadata->useXmlKeyAsAttribute());
        self::assertTrue($this->propertyMetadata->useXmlKeyAsNode());
    }

    public function testSerialize(): void
    {
        self::assertEquals($this->propertyMetadata, unserialize(serialize($this->propertyMetadata)));
    }

    /**
     * @return \PHPUnit\Framework\MockObject\MockObject|TypeMetadataInterface
     */
    private function createTypeMetadataMock()
    {
        return $this->createMock(TypeMetadataInterface::class);
    }
}
