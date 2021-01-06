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
use Ivory\Serializer\Mapping\Loader\XmlClassMetadataLoader;

/**
 * @author GeLo <geloen.eric@gmail.com>
 */
class XmlClassMetadataLoaderTest extends AbstractFileClassMetadataLoaderTest
{
    public function testMissingContent(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->loader = $this->createLoader('content_missing');
        $this->loadClassMetadata(new ClassMetadata(\stdClass::class));
    }

    public function testDoctype(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->loader = $this->createLoader('doctype');
        $this->loadClassMetadata(new ClassMetadata(\stdClass::class));
    }

    public function testXsd(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->loader = $this->createLoader('xsd');
        $this->loadClassMetadata(new ClassMetadata(\stdClass::class));
    }

    public function testExclude(): void
    {
        self::markTestSkipped('Not tested');
    }

    public function testExpose(): void
    {
        self::markTestSkipped('Not tested');
    }

    public function testReadable(): void
    {
        self::markTestSkipped('Not tested');
    }

    public function testReadableClass(): void
    {
        self::markTestSkipped('Not tested');
    }

    public function testWritable(): void
    {
        self::markTestSkipped('Not tested');
    }

    public function testWritableClass(): void
    {
        self::markTestSkipped('Not tested');
    }

    public function testXmlAttribute(): void
    {
        self::markTestSkipped('Not tested');
    }

    public function testXmlValue(): void
    {
        self::markTestSkipped('Not tested');
    }

    public function testXmlInline(): void
    {
        self::markTestSkipped('Not tested');
    }

    public function testXmlKeyAsAttribute(): void
    {
        self::markTestSkipped('Not tested');
    }

    public function testXmlKeyAsNode(): void
    {
        self::markTestSkipped('Not tested');
    }

    /**
     * {@inheritdoc}
     */
    protected function createLoader($file)
    {
        return new XmlClassMetadataLoader(__DIR__.'/../../Fixture/config/xml/'.$file.'/'.$file.'.xml');
    }
}
