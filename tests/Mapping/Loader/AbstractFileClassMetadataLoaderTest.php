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
use Ivory\Serializer\Mapping\Loader\MappedClassMetadataLoaderInterface;
use Ivory\Serializer\Mapping\Loader\YamlClassMetadataLoader;
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
abstract class AbstractFileClassMetadataLoaderTest extends AbstractClassMetadataLoaderTest
{
    public function testInheritance(): void
    {
        self::assertInstanceOf(MappedClassMetadataLoaderInterface::class, $this->loader);

        parent::testInheritance();
    }

    public function testArrayFixture(): void
    {
        $this->assertMappedClasses();

        parent::testArrayFixture();
    }

    public function testScalarFixture(): void
    {
        $this->assertMappedClasses();

        parent::testScalarFixture();
    }

    public function testDateTimeFixture(): void
    {
        $this->assertMappedClasses();

        parent::testDateTimeFixture();
    }

    public function testExcludeFixture(): void
    {
        $this->assertMappedClasses();

        parent::testExcludeFixture();
    }

    public function testExposeFixture(): void
    {
        $this->assertMappedClasses();

        parent::testExposeFixture();
    }

    public function testReadableFixture(): void
    {
        $this->assertMappedClasses();

        parent::testReadableFixture();
    }

    public function testReadableClassFixture(): void
    {
        $this->assertMappedClasses();

        parent::testReadableClassFixture();
    }

    public function testWritableFixture(): void
    {
        $this->assertMappedClasses();

        parent::testWritableFixture();
    }

    public function testWritableClassFixture(): void
    {
        $this->assertMappedClasses();

        parent::testWritableClassFixture();
    }

    public function testAccessorFixture(): void
    {
        $this->assertMappedClasses();

        parent::testAccessorFixture();
    }

    public function testMutatorFixture(): void
    {
        $this->assertMappedClasses();

        parent::testMutatorFixture();
    }

    public function testMaxDepthFixture(): void
    {
        $this->assertMappedClasses();

        parent::testMaxDepthFixture();
    }

    public function testGroupFixture(): void
    {
        $this->assertMappedClasses();

        parent::testGroupFixture();
    }

    public function testOrderFixture(): void
    {
        $this->assertMappedClasses();

        parent::testOrderFixture();
    }

    public function testAscFixture(): void
    {
        $this->assertMappedClasses();

        parent::testAscFixture();
    }

    public function testDescFixture(): void
    {
        $this->assertMappedClasses();

        parent::testDescFixture();
    }

    public function testVersionFixture(): void
    {
        $this->assertMappedClasses();

        parent::testVersionFixture();
    }

    public function testXmlFixture(): void
    {
        $this->assertMappedClasses();

        parent::testXmlFixture();
    }

    public function testXmlValueFixture(): void
    {
        $this->assertMappedClasses();

        parent::testXmlValueFixture();
    }

    public function testUnknownFixture(): void
    {
        $this->assertMappedClasses();

        parent::testUnknownFixture();
    }

    public function testFileNotFound(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->createLoader('foo');
    }

    public function testFileNotReadable(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->createLoader('lock');
    }

    public function testMalformed()
    {
        $this->loader = $this->createLoader('malformed');
        $this->expectException(\InvalidArgumentException::class);
        $this->loadClassMetadata(new ClassMetadata(\stdClass::class));
    }

    public function testExclusionPolicy(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->loader = $this->createLoader('exclusion_policy');
        $this->loadClassMetadata(new ClassMetadata(ExcludeFixture::class));
    }

    public function testExclude(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->loader = $this->createLoader('exclude');
        $this->loadClassMetadata(new ClassMetadata(ExcludeFixture::class));
    }

    public function testExpose(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->loader = $this->createLoader('expose');
        $this->loadClassMetadata(new ClassMetadata(ExposeFixture::class));
    }

    public function testReadable(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->loader = $this->createLoader('readable');
        $this->loadClassMetadata(new ClassMetadata(ReadableFixture::class));
    }

    public function testReadableClass(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->loader = $this->createLoader('readable_class');
        $this->loadClassMetadata(new ClassMetadata(ReadableClassFixture::class));
    }

    public function testWritable(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->loader = $this->createLoader('writable');
        $this->loadClassMetadata(new ClassMetadata(WritableFixture::class));
    }

    public function testWritableClass(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->loader = $this->createLoader('writable_class');
        $this->loadClassMetadata(new ClassMetadata(WritableClassFixture::class));
    }

    public function testAccessor(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->loader = $this->createLoader('accessor');
        $this->loadClassMetadata(new ClassMetadata(AccessorFixture::class));
    }

    public function testMutator(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->loader = $this->createLoader('mutator');
        $this->loadClassMetadata(new ClassMetadata(MutatorFixture::class));
    }

    public function testOrder(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->loader = $this->createLoader('order');
        $this->loadClassMetadata(new ClassMetadata(OrderFixture::class));
    }

    public function testOrderEmpty(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->loader = $this->createLoader('order_empty');
        $this->loadClassMetadata(new ClassMetadata(OrderFixture::class));
    }

    public function testOrderEmptyProperty(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->loader = $this->createLoader('order_empty_property');
        $this->loadClassMetadata(new ClassMetadata(OrderFixture::class));
    }

    public function testProperties(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->loader = $this->createLoader('properties');
        $this->loadClassMetadata(new ClassMetadata(\stdClass::class));
    }

    public function testPropertyAlias(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->loader = $this->createLoader('alias');
        $this->loadClassMetadata(new ClassMetadata(ScalarFixture::class));
    }

    public function testPropertyType(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->loader = $this->createLoader('type');
        $this->loadClassMetadata(new ClassMetadata(ScalarFixture::class));
    }

    public function testPropertySince(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->loader = $this->createLoader('since');
        $this->loadClassMetadata(new ClassMetadata(VersionFixture::class));
    }

    public function testPropertyUntil(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->loader = $this->createLoader('until');
        $this->loadClassMetadata(new ClassMetadata(VersionFixture::class));
    }

    public function testPropertyMaxDepth(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->loader = $this->createLoader('max_depth');
        $this->loadClassMetadata(new ClassMetadata(MaxDepthFixture::class));
    }

    public function testPropertyGroups(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->loader = $this->createLoader('groups');
        $this->loadClassMetadata(new ClassMetadata(GroupFixture::class));
    }

    public function testXmlRoot(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->loader = $this->createLoader('xml_root');
        $this->loadClassMetadata(new ClassMetadata(XmlFixture::class));
    }

    public function testXmlAttribute(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->loader = $this->createLoader('xml_attribute');
        $this->loadClassMetadata(new ClassMetadata(XmlFixture::class));
    }

    public function testXmlEntry(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->loader = $this->createLoader('xml_entry');
        $this->loadClassMetadata(new ClassMetadata(XmlFixture::class));
    }

    public function testXmlEntryAttribute(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->loader = $this->createLoader('xml_entry_attribute');
        $this->loadClassMetadata(new ClassMetadata(XmlFixture::class));
    }

    public function testXmlKeyAsAttribute(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->loader = $this->createLoader('xml_key_as_attribute');
        $this->loadClassMetadata(new ClassMetadata(XmlFixture::class));
    }

    public function testXmlKeyAsNode(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->loader = $this->createLoader('xml_key_as_node');
        $this->loadClassMetadata(new ClassMetadata(XmlFixture::class));
    }

    public function testXmlInline(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->loader = $this->createLoader('xml_inline');
        $this->loadClassMetadata(new ClassMetadata(XmlFixture::class));
    }

    public function testXmlValue(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->loader = $this->createLoader('xml_value');
        $this->loadClassMetadata(new ClassMetadata(XmlValueFixture::class));
    }

    protected function assertMappedClasses()
    {
        self::assertSame([
            ArrayFixture::class,
            ScalarFixture::class,
            DateTimeFixture::class,
            ExcludeFixture::class,
            ExposeFixture::class,
            AccessorFixture::class,
            MutatorFixture::class,
            MaxDepthFixture::class,
            GroupFixture::class,
            OrderFixture::class,
            AscFixture::class,
            DescFixture::class,
            ReadableFixture::class,
            ReadableClassFixture::class,
            WritableFixture::class,
            WritableClassFixture::class,
            VersionFixture::class,
            XmlFixture::class,
            XmlValueFixture::class,
        ], $this->loader->getMappedClasses());
    }
}
