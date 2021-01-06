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
use Ivory\Serializer\Mapping\Loader\ReflectionClassMetadataLoader;
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
class ReflectionClassMetadataLoaderTest extends AbstractReflectionClassMetadataLoaderTest
{
    public function testArrayFixture(): void
    {
        $classMetadata = new ClassMetadata(ArrayFixture::class);

        self::assertTrue($this->loadClassMetadata($classMetadata));
        $this->assertClassMetadata($classMetadata, [
            'scalars'    => [],
            'objects'    => [],
            'types'      => [],
            'inceptions' => [],
        ]);
    }

    public function testScalarFixture(): void
    {
        $classMetadata = new ClassMetadata(ScalarFixture::class);

        self::assertTrue($this->loadClassMetadata($classMetadata));
        $this->assertClassMetadata($classMetadata, [
            'bool'   => [],
            'float'  => [],
            'int'    => [],
            'string' => [],
            'type'   => [],
        ]);
    }

    public function testDateTimeFixture(): void
    {
        $classMetadata = new ClassMetadata(DateTimeFixture::class);

        self::assertTrue($this->loadClassMetadata($classMetadata));
        $this->assertClassMetadata($classMetadata, [
            'dateTime'                   => [],
            'formattedDateTime'          => [],
            'timeZonedDateTime'          => [],
            'immutableDateTime'          => [],
            'formattedImmutableDateTime' => [],
            'timeZonedImmutableDateTime' => [],
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
            'foo' => [],
            'bar' => [],
        ]);
    }

    public function testReadableClassFixture(): void
    {
        $classMetadata = new ClassMetadata(ReadableClassFixture::class);

        self::assertTrue($this->loadClassMetadata($classMetadata));
        $this->assertClassMetadata($classMetadata, [
            'foo' => [],
            'bar' => [],
        ]);
    }

    public function testWritableFixture(): void
    {
        $classMetadata = new ClassMetadata(WritableFixture::class);

        self::assertTrue($this->loadClassMetadata($classMetadata));
        $this->assertClassMetadata($classMetadata, [
            'foo' => [],
            'bar' => [],
        ]);
    }

    public function testWritableClassFixture(): void
    {
        $classMetadata = new ClassMetadata(WritableClassFixture::class);

        self::assertTrue($this->loadClassMetadata($classMetadata));
        $this->assertClassMetadata($classMetadata, [
            'foo' => [],
            'bar' => [],
        ]);
    }

    public function testAccessorFixture(): void
    {
        $classMetadata = new ClassMetadata(AccessorFixture::class);

        self::assertTrue($this->loadClassMetadata($classMetadata));
        $this->assertClassMetadata($classMetadata, [
            'name' => [],
        ]);
    }

    public function testMutatorFixture(): void
    {
        $classMetadata = new ClassMetadata(MutatorFixture::class);

        self::assertTrue($this->loadClassMetadata($classMetadata));
        $this->assertClassMetadata($classMetadata, [
            'name' => [],
        ]);
    }

    public function testMaxDepthFixture(): void
    {
        $classMetadata = new ClassMetadata(MaxDepthFixture::class);

        self::assertTrue($this->loadClassMetadata($classMetadata));
        $this->assertClassMetadata($classMetadata, [
            'parent'         => [],
            'children'       => [],
            'orphanChildren' => [],
        ]);
    }

    public function testGroupFixture(): void
    {
        $classMetadata = new ClassMetadata(GroupFixture::class);

        self::assertTrue($this->loadClassMetadata($classMetadata));
        $this->assertClassMetadata($classMetadata, [
            'foo' => [],
            'bar' => [],
            'baz' => [],
            'bat' => [],
        ]);
    }

    public function testVersionFixture(): void
    {
        $classMetadata = new ClassMetadata(VersionFixture::class);

        self::assertTrue($this->loadClassMetadata($classMetadata));
        $this->assertClassMetadata($classMetadata, [
            'foo' => [],
            'bar' => [],
            'baz' => [],
            'bat' => [],
        ]);
    }

    /**
     * {@inheritdoc}
     */
    protected function createLoader($file)
    {
        return new ReflectionClassMetadataLoader();
    }
}
