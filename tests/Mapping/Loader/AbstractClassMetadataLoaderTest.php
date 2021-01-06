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
use Ivory\Serializer\Mapping\ClassMetadataInterface;
use Ivory\Serializer\Mapping\Loader\ClassMetadataLoaderInterface;
use Ivory\Serializer\Mapping\PropertyMetadataInterface;
use Ivory\Tests\Serializer\Fixture\AccessorFixture;
use Ivory\Tests\Serializer\Fixture\ArrayFixture;
use Ivory\Tests\Serializer\Fixture\AscFixture;
use Ivory\Tests\Serializer\Fixture\DateTimeFixture;
use Ivory\Tests\Serializer\Fixture\DescFixture;
use Ivory\Tests\Serializer\Fixture\ExcludeFixture;
use Ivory\Tests\Serializer\Fixture\ExposeFixture;
use Ivory\Tests\Serializer\Fixture\GroupFixture;
use Ivory\Tests\Serializer\Fixture\MaxDepthFixture;
use Ivory\Tests\Serializer\Fixture\MutatorFixture;
use Ivory\Tests\Serializer\Fixture\OrderFixture;
use Ivory\Tests\Serializer\Fixture\ReadableClassFixture;
use Ivory\Tests\Serializer\Fixture\ReadableFixture;
use Ivory\Tests\Serializer\Fixture\ScalarFixture;
use Ivory\Tests\Serializer\Fixture\VersionFixture;
use Ivory\Tests\Serializer\Fixture\WritableClassFixture;
use Ivory\Tests\Serializer\Fixture\WritableFixture;
use Ivory\Tests\Serializer\Fixture\XmlFixture;
use Ivory\Tests\Serializer\Fixture\XmlValueFixture;

/**
 * @author GeLo <geloen.eric@gmail.com>
 */
abstract class AbstractClassMetadataLoaderTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @var ClassMetadataLoaderInterface
     */
    protected $loader;

    /**
     * {@inheritdoc}
     */
    protected function setUp(): void
    {
        $this->loader = $this->createLoader('mapping');
    }

    public function testInheritance(): void
    {
        self::assertInstanceOf(ClassMetadataLoaderInterface::class, $this->loader);
    }

    public function testArrayFixture(): void
    {
        $classMetadata = new ClassMetadata(ArrayFixture::class);

        self::assertTrue($this->loadClassMetadata($classMetadata));
        $this->assertClassMetadata($classMetadata, [
            'scalars'    => ['type' => 'array<value=string>'],
            'objects'    => ['type' => 'array<value='.ArrayFixture::class.'>'],
            'types'      => ['type' => 'array<key=int, value=string>'],
            'inceptions' => ['type' => 'array<key=string, value=array<key=int, value=string>>'],
        ]);
    }

    public function testScalarFixture(): void
    {
        $classMetadata = new ClassMetadata(ScalarFixture::class);

        self::assertTrue($this->loadClassMetadata($classMetadata));
        $this->assertClassMetadata($classMetadata, [
            'bool'   => ['type' => 'bool', 'alias' => 'boolean'],
            'float'  => ['type' => 'float'],
            'int'    => ['type' => 'int'],
            'string' => ['type' => 'string'],
            'type'   => ['type' => ScalarFixture::class],
        ]);
    }

    public function testDateTimeFixture(): void
    {
        $classMetadata = new ClassMetadata(DateTimeFixture::class);

        self::assertTrue($this->loadClassMetadata($classMetadata));
        $this->assertClassMetadata($classMetadata, [
            'dateTime'                   => ['type' => 'DateTime'],
            'formattedDateTime'          => ['type' => 'DateTime<format=\'Y-m-d, H:i:s, P\'>'],
            'timeZonedDateTime'          => ['type' => 'DateTime<timezone=\'Europe/Paris\'>'],
            'immutableDateTime'          => ['type' => 'DateTimeImmutable'],
            'formattedImmutableDateTime' => ['type' => 'DateTimeImmutable<format=\'Y-m-d, H:i:s, P\'>'],
            'timeZonedImmutableDateTime' => ['type' => 'DateTimeImmutable<timezone=\'Europe/Paris\'>'],
        ]);
    }

    public function testExcludeFixture(): void
    {
        $classMetadata = new ClassMetadata(ExcludeFixture::class);

        self::assertTrue($this->loadClassMetadata($classMetadata));
        $this->assertClassMetadata($classMetadata, [
            'bar' => [],
        ]);
    }

    public function testExposeFixture(): void
    {
        $classMetadata = new ClassMetadata(ExposeFixture::class);

        self::assertTrue($this->loadClassMetadata($classMetadata));
        $this->assertClassMetadata($classMetadata, [
            'foo' => [],
        ]);
    }

    public function testReadableFixture(): void
    {
        $classMetadata = new ClassMetadata(ReadableFixture::class);

        self::assertTrue($this->loadClassMetadata($classMetadata));
        $this->assertClassMetadata($classMetadata, [
            'foo' => ['readable' => false],
            'bar' => [],
        ]);
    }

    public function testReadableClassFixture(): void
    {
        $classMetadata = new ClassMetadata(ReadableClassFixture::class);

        self::assertTrue($this->loadClassMetadata($classMetadata));
        $this->assertClassMetadata($classMetadata, [
            'foo' => ['readable' => true],
            'bar' => ['readable' => false],
        ]);
    }

    public function testWritableFixture(): void
    {
        $classMetadata = new ClassMetadata(WritableFixture::class);

        self::assertTrue($this->loadClassMetadata($classMetadata));
        $this->assertClassMetadata($classMetadata, [
            'foo' => ['writable' => false],
            'bar' => [],
        ]);
    }

    public function testWritableClassFixture(): void
    {
        $classMetadata = new ClassMetadata(WritableClassFixture::class);

        self::assertTrue($this->loadClassMetadata($classMetadata));
        $this->assertClassMetadata($classMetadata, [
            'foo' => ['writable' => true],
            'bar' => ['writable' => false],
        ]);
    }

    public function testAccessorFixture(): void
    {
        $classMetadata = new ClassMetadata(AccessorFixture::class);

        self::assertTrue($this->loadClassMetadata($classMetadata));
        $this->assertClassMetadata($classMetadata, [
            'name' => ['accessor' => 'getName'],
        ]);
    }

    public function testMutatorFixture(): void
    {
        $classMetadata = new ClassMetadata(MutatorFixture::class);

        self::assertTrue($this->loadClassMetadata($classMetadata));
        $this->assertClassMetadata($classMetadata, [
            'name' => ['mutator' => 'setName'],
        ]);
    }

    public function testMaxDepthFixture(): void
    {
        $classMetadata = new ClassMetadata(MaxDepthFixture::class);

        self::assertTrue($this->loadClassMetadata($classMetadata));
        $this->assertClassMetadata($classMetadata, [
            'parent'         => ['type' => MaxDepthFixture::class, 'max_depth' => 1],
            'children'       => ['type' => 'array<value='.MaxDepthFixture::class.'>', 'max_depth' => 2],
            'orphanChildren' => ['type' => 'array<value='.MaxDepthFixture::class.'>', 'max_depth' => 1],
        ]);
    }

    public function testGroupFixture(): void
    {
        $classMetadata = new ClassMetadata(GroupFixture::class);

        self::assertTrue($this->loadClassMetadata($classMetadata));
        $this->assertClassMetadata($classMetadata, [
            'foo' => ['groups' => ['group1', 'group2']],
            'bar' => ['groups' => ['group1']],
            'baz' => ['groups' => ['group2']],
            'bat' => [],
        ]);
    }

    public function testOrderFixture(): void
    {
        $classMetadata = new ClassMetadata(OrderFixture::class);

        self::assertTrue($this->loadClassMetadata($classMetadata));
        self::assertSame(['bar', 'foo'], array_keys($classMetadata->getProperties()));
    }

    public function testAscFixture(): void
    {
        $classMetadata = new ClassMetadata(AscFixture::class);

        self::assertTrue($this->loadClassMetadata($classMetadata));
        self::assertSame(['bar', 'foo'], array_keys($classMetadata->getProperties()));
    }

    public function testDescFixture(): void
    {
        $classMetadata = new ClassMetadata(DescFixture::class);

        self::assertTrue($this->loadClassMetadata($classMetadata));
        self::assertSame(['foo', 'bar'], array_keys($classMetadata->getProperties()));
    }

    public function testVersionFixture(): void
    {
        $classMetadata = new ClassMetadata(VersionFixture::class);

        self::assertTrue($this->loadClassMetadata($classMetadata));
        $this->assertClassMetadata($classMetadata, [
            'foo' => ['since' => '1.0', 'until' => '2.0'],
            'bar' => ['since' => '1.0'],
            'baz' => ['until' => '2.0'],
            'bat' => [],
        ]);
    }

    public function testXmlFixture(): void
    {
        $classMetadata = new ClassMetadata(XmlFixture::class);

        self::assertTrue($this->loadClassMetadata($classMetadata));
        $this->assertClassMetadata($classMetadata, [
            'foo'            => [],
            'bar'            => ['xml_attribute' => true],
            'list'           => [],
            'keyAsAttribute' => ['xml_key_as_attribute' => true],
            'keyAsNode'      => ['xml_key_as_node' => true],
            'entry'          => ['xml_entry' => 'item'],
            'entryAttribute' => ['xml_entry_attribute' => 'name'],
            'inline'         => [
                'xml_inline'           => true,
                'xml_entry'            => 'inline',
                'xml_entry_attribute'  => 'index',
                'xml_key_as_attribute' => true,
                'xml_key_as_node'      => false,
            ],
        ], ['xml_root' => 'xml']);
    }

    public function testXmlValueFixture(): void
    {
        $classMetadata = new ClassMetadata(XmlValueFixture::class);

        self::assertTrue($this->loadClassMetadata($classMetadata));
        $this->assertClassMetadata($classMetadata, [
            'foo' => ['xml_attribute' => true],
            'bar' => ['xml_value' => true],
        ], ['xml_root' => 'xml']);
    }

    public function testUnknownFixture(): void
    {
        self::assertFalse($this->loadClassMetadata(new ClassMetadata(\stdClass::class)));
    }

    /**
     * @param string $file
     *
     * @return ClassMetadataLoaderInterface
     */
    abstract protected function createLoader($file);

    /**
     * @param ClassMetadataInterface $classMetadata
     *
     * @return bool
     */
    protected function loadClassMetadata(ClassMetadataInterface $classMetadata)
    {
        return $this->loader->loadClassMetadata($classMetadata);
    }

    /**
     * @param ClassMetadataInterface $classMetadata
     * @param mixed[][]              $properties
     * @param mixed[]                $options
     */
    protected function assertClassMetadata(
        ClassMetadataInterface $classMetadata,
        array $properties,
        array $options = []
    ) {
        self::assertSame(isset($options['xml_root']), $classMetadata->hasXmlRoot());
        self::assertSame(isset($options['xml_root']) ? $options['xml_root'] : null, $classMetadata->getXmlRoot());

        foreach ($properties as $property => $data) {
            self::assertTrue($classMetadata->hasProperty($property));
            $this->assertPropertyMetadata($classMetadata->getProperty($property), $data);
        }
    }

    /**
     * @param PropertyMetadataInterface $propertyMetadata
     * @param mixed[]                   $data
     */
    private function assertPropertyMetadata(PropertyMetadataInterface $propertyMetadata, array $data)
    {
        self::assertSame(isset($data['alias']), $propertyMetadata->hasAlias());
        self::assertSame(isset($data['alias']) ? $data['alias'] : null, $propertyMetadata->getAlias());

        self::assertSame(isset($data['type']), $propertyMetadata->hasType(), $propertyMetadata->getName());
        self::assertSame(
            isset($data['type']) ? $data['type'] : null,
            $propertyMetadata->hasType() ? (string) $propertyMetadata->getType() : null
        );

        self::assertSame(isset($data['readable']) ? $data['readable'] : true, $propertyMetadata->isReadable());
        self::assertSame(isset($data['writable']) ? $data['writable'] : true, $propertyMetadata->isWritable());

        self::assertSame(isset($data['accessor']), $propertyMetadata->hasAccessor());
        self::assertSame(isset($data['accessor']) ? $data['accessor'] : null, $propertyMetadata->getAccessor());

        self::assertSame(isset($data['mutator']), $propertyMetadata->hasMutator());
        self::assertSame(isset($data['mutator']) ? $data['mutator'] : null, $propertyMetadata->getMutator());

        self::assertSame(isset($data['since']), $propertyMetadata->hasSinceVersion());
        self::assertSame(isset($data['since']) ? $data['since'] : null, $propertyMetadata->getSinceVersion());

        self::assertSame(isset($data['until']), $propertyMetadata->hasUntilVersion());
        self::assertSame(isset($data['until']) ? $data['until'] : null, $propertyMetadata->getUntilVersion());

        self::assertSame(isset($data['max_depth']), $propertyMetadata->hasMaxDepth());
        self::assertSame(isset($data['max_depth']) ? $data['max_depth'] : null, $propertyMetadata->getMaxDepth());

        self::assertSame(isset($data['groups']), $propertyMetadata->hasGroups());
        self::assertSame(isset($data['groups']) ? $data['groups'] : [], $propertyMetadata->getGroups());

        self::assertSame(isset($data['xml_attribute']) && $data['xml_attribute'], $propertyMetadata->isXmlAttribute());
        self::assertSame(isset($data['xml_inline']) && $data['xml_inline'], $propertyMetadata->isXmlInline());
        self::assertSame(isset($data['xml_value']) && $data['xml_value'], $propertyMetadata->isXmlValue());
        self::assertSame(isset($data['xml_entry']) ? $data['xml_entry'] : null, $propertyMetadata->getXmlEntry());

        self::assertSame(
            isset($data['xml_entry_attribute']) ? $data['xml_entry_attribute'] : null,
            $propertyMetadata->getXmlEntryAttribute()
        );

        self::assertSame(
            isset($data['xml_key_as_attribute']) ? $data['xml_key_as_attribute'] : null,
            $propertyMetadata->useXmlKeyAsAttribute()
        );

        self::assertSame(
            isset($data['xml_key_as_node']) ? $data['xml_key_as_node'] : null,
            $propertyMetadata->useXmlKeyAsNode()
        );
    }
}
