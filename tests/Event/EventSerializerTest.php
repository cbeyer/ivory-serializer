<?php

/*
 * This file is part of the Ivory Serializer package.
 *
 * (c) Eric GELOEN <geloen.eric@gmail.com>
 *
 * For the full copyright and license information, please read the LICENSE
 * file that was distributed with this source code.
 */

namespace Ivory\Tests\Serializer\Event;

use Ivory\Serializer\Context\Context;
use Ivory\Serializer\Format;
use Ivory\Serializer\Navigator\EventNavigator;
use Ivory\Serializer\Navigator\Navigator;
use Ivory\Serializer\Serializer;
use Ivory\Serializer\Type\Type;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

/**
 * @author GeLo <geloen.eric@gmail.com>
 */
class EventSerializerTest extends TestCase
{
    /**
     * @var Serializer
     */
    private $serializer;

    /**
     * @var MockObject|EventDispatcherInterface
     */
    private $dispatcher;

    /**
     * {@inheritdoc}
     */
    protected function setUp(): void
    {
        $this->dispatcher = $this->createEventDispatcherMock();
        $this->serializer = new Serializer(new EventNavigator(new Navigator(), $this->dispatcher));
    }

    public function testPreSerializeEvent(): void
    {
        $data = 'data';
        $context = new Context();

        self::assertSame('"data"', $this->serializer->serialize($data, Format::JSON, $context));
    }

    public function testPostSerializeEvent(): void
    {
        $data = 'data';
        $context = new Context();

        self::assertSame('"data"', $this->serializer->serialize($data, Format::JSON, $context));
    }

    public function testPreDeserializeEvent(): void
    {
        $data = '123';
        $context = new Context();

        self::assertSame(123, $this->serializer->deserialize($data, 'integer', Format::JSON, $context));
    }

    public function testPostDeserializeEvent(): void
    {
        $data = 123;
        $context = new Context();

        self::assertSame($data, $this->serializer->deserialize('123', Type::INTEGER, Format::JSON, $context));
    }

    /**
     * @return \PHPUnit\Framework\MockObject\MockObject|EventDispatcherInterface
     */
    private function createEventDispatcherMock()
    {
        return $this->createMock(EventDispatcherInterface::class);
    }
}
