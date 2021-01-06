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

use Ivory\Serializer\Mapping\Loader\FileClassMetadataLoader;

/**
 * @author GeLo <geloen.eric@gmail.com>
 */
class XmlFileClassMetadataLoaderTest extends AbstractFileClassMetadataLoaderTest
{
    public function testUnsupportedFile(): void
    {
        $this->expectExceptionMessageMatches("/^The file \".+\" is not supported\.$/");
        $this->expectException(\InvalidArgumentException::class);
        new FileClassMetadataLoader(__DIR__.'/../../Fixture/config/xml/mapping/ignore.txt');
    }

    public function testDocumentType(): void
    {
        self::markTestSkipped('Not tested');
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
        return new FileClassMetadataLoader(__DIR__.'/../../Fixture/config/xml/'.$file.'/'.$file.'.xml');
    }
}
