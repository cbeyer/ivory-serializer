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
use Ivory\Tests\Serializer\Fixture\AccessorFixture;
use Ivory\Tests\Serializer\Fixture\ArrayFixture;
use Ivory\Tests\Serializer\Fixture\DateTimeFixture;
use Ivory\Tests\Serializer\Fixture\ExcludeFixture;
use Ivory\Tests\Serializer\Fixture\ExposeFixture;
use Ivory\Tests\Serializer\Fixture\GroupFixture;
use Ivory\Tests\Serializer\Fixture\MaxDepthFixture;
use Ivory\Tests\Serializer\Fixture\MutatorFixture;
use Ivory\Tests\Serializer\Fixture\ReadableClassFixture;
use Ivory\Tests\Serializer\Fixture\ReadableFixture;
use Ivory\Tests\Serializer\Fixture\ScalarFixture;
use Ivory\Tests\Serializer\Fixture\VersionFixture;
use Ivory\Tests\Serializer\Fixture\WritableClassFixture;
use Ivory\Tests\Serializer\Fixture\WritableFixture;

/**
 * @author GeLo <geloen.eric@gmail.com>
 */
abstract class AbstractReflectionClassMetadataLoaderTest extends AbstractClassMetadataLoaderTest
{
    public function testArrayFixture(): void
    {
        $classMetadata = new ClassMetadata(ArrayFixture::class);

        self::assertTrue($this->loadClassMetadata($classMetadata));
        $this->assertClassMetadata($classMetadata, [
            'scalars'    => ['type' => 'array'],
            'objects'    => ['type' => 'array'],
            'types'      => ['type' => 'array'],
            'inceptions' => ['type' => 'array'],
        ]);
    }

    public function testScalarFixture(): void
    {
        $classMetadata = new ClassMetadata(ScalarFixture::class);

        self::assertTrue($this->loadClassMetadata($classMetadata));
        $this->assertClassMetadata($classMetadata, [
            'bool'   => ['type' => 'bool'],
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
            'formattedDateTime'          => ['type' => 'DateTime'],
            'timeZonedDateTime'          => ['type' => 'DateTime'],
            'immutableDateTime'          => ['type' => 'DateTimeImmutable'],
            'formattedImmutableDateTime' => ['type' => 'DateTimeImmutable'],
            'timeZonedImmutableDateTime' => ['type' => 'DateTimeImmutable'],
        ]);
    }

    public function testExcludeFixture(): void
    {
        $classMetadata = new ClassMetadata(ExcludeFixture::class);

        self::assertTrue($this->loadClassMetadata($classMetadata));
        $this->assertClassMetadata($classMetadata, [
            'bar' => ['type' => 'string'],
        ]);
    }

    public function testExposeFixture(): void
    {
        $classMetadata = new ClassMetadata(ExposeFixture::class);

        self::assertTrue($this->loadClassMetadata($classMetadata));
        $this->assertClassMetadata($classMetadata, [
            'foo' => ['type' => 'string'],
        ]);
    }

    public function testReadableFixture(): void
    {
        $classMetadata = new ClassMetadata(ReadableFixture::class);

        self::assertTrue($this->loadClassMetadata($classMetadata));
        $this->assertClassMetadata($classMetadata, [
            'foo' => ['type' => 'string'],
            'bar' => ['type' => 'string'],
        ]);
    }

    public function testReadableClassFixture(): void
    {
        $classMetadata = new ClassMetadata(ReadableClassFixture::class);

        self::assertTrue($this->loadClassMetadata($classMetadata));
        $this->assertClassMetadata($classMetadata, [
            'foo' => ['type' => 'string'],
            'bar' => ['type' => 'string'],
        ]);
    }

    public function testWritableFixture(): void
    {
        $classMetadata = new ClassMetadata(WritableFixture::class);

        self::assertTrue($this->loadClassMetadata($classMetadata));
        $this->assertClassMetadata($classMetadata, [
            'foo' => ['type' => 'string'],
            'bar' => ['type' => 'string'],
        ]);
    }

    public function testWritableClassFixture(): void
    {
        $classMetadata = new ClassMetadata(WritableClassFixture::class);

        self::assertTrue($this->loadClassMetadata($classMetadata));
        $this->assertClassMetadata($classMetadata, [
            'foo' => ['type' => 'string'],
            'bar' => ['type' => 'string'],
        ]);
    }

    public function testAccessorFixture(): void
    {
        $classMetadata = new ClassMetadata(AccessorFixture::class);

        self::assertTrue($this->loadClassMetadata($classMetadata));
        $this->assertClassMetadata($classMetadata, [
            'name' => ['type' => 'string'],
        ]);
    }

    public function testMutatorFixture(): void
    {
        $classMetadata = new ClassMetadata(MutatorFixture::class);

        self::assertTrue($this->loadClassMetadata($classMetadata));
        $this->assertClassMetadata($classMetadata, [
            'name' => ['type' => 'string'],
        ]);
    }

    public function testMaxDepthFixture(): void
    {
        $classMetadata = new ClassMetadata(MaxDepthFixture::class);

        self::assertTrue($this->loadClassMetadata($classMetadata));
        $this->assertClassMetadata($classMetadata, [
            'parent'         => ['type' => MaxDepthFixture::class],
            'children'       => ['type' => 'array'],
            'orphanChildren' => ['type' => 'array'],
        ]);
    }

    public function testGroupFixture(): void
    {
        $classMetadata = new ClassMetadata(GroupFixture::class);

        self::assertTrue($this->loadClassMetadata($classMetadata));
        $this->assertClassMetadata($classMetadata, [
            'foo' => ['type' => 'string'],
            'bar' => ['type' => 'string'],
            'baz' => ['type' => 'string'],
            'bat' => ['type' => 'string'],
        ]);
    }

    public function testVersionFixture(): void
    {
        $classMetadata = new ClassMetadata(VersionFixture::class);

        self::assertTrue($this->loadClassMetadata($classMetadata));
        $this->assertClassMetadata($classMetadata, [
            'foo' => ['type' => 'string'],
            'bar' => ['type' => 'string'],
            'baz' => ['type' => 'string'],
            'bat' => ['type' => 'string'],
        ]);
    }

    public function testOrderFixture(): void
    {
        self::markTestSkipped('Not tested');
    }

    public function testAscFixture(): void
    {
        self::markTestSkipped('Not tested');
    }

    public function testDescFixture(): void
    {
        self::markTestSkipped('Not tested');
    }

    public function testXmlFixture(): void
    {
        self::markTestSkipped('Not tested');
    }

    public function testXmlValueFixture(): void
    {
        self::markTestSkipped('Not tested');
    }
}
