<?php

/*
 * This file is part of the Ivory Serializer package.
 *
 * (c) Eric GELOEN <geloen.eric@gmail.com>
 *
 * For the full copyright and license information, please read the LICENSE
 * file that was distributed with this source code.
 */

namespace Ivory\Tests\Serializer\Mapping\Factory;

use Ivory\Serializer\Event\ClassMetadataLoadEvent;
use Ivory\Serializer\Event\ClassMetadataNotFoundEvent;
use Ivory\Serializer\Event\SerializerEvents;
use Ivory\Serializer\Mapping\ClassMetadataInterface;
use Ivory\Serializer\Mapping\Factory\ClassMetadataFactoryInterface;
use Ivory\Serializer\Mapping\Factory\EventClassMetadataFactory;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

/**
 * @author GeLo <geloen.eric@gmail.com>
 */
class EventClassMetadataFactoryTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @var EventClassMetadataFactory
     */
    private $eventFactory;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|ClassMetadataFactoryInterface
     */
    private $factory;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|EventDispatcherInterface
     */
    private $dispatcher;

    /**
     * {@inheritdoc}
     */
    protected function setUp(): void
    {
        $this->dispatcher = $this->createEventDispatcherMock();
        $this->factory = $this->createClassMetadataFactoryMock();

        $this->eventFactory = new EventClassMetadataFactory($this->factory, $this->dispatcher);
    }

    public function testClassMetadataLoadEvent(): void
    {
        $this->factory
            ->expects(self::once())
            ->method('getClassMetadata')
            ->with(self::identicalTo($class = \stdClass::class))
            ->willReturn($classMetadata = $this->createClassMetadataMock());

        $this->dispatcher
            ->expects(self::once())
            ->method('dispatch')
            ->with(
                self::callback(function ($event) use ($classMetadata) {
                    return $event instanceof ClassMetadataLoadEvent && $event->getClassMetadata() === $classMetadata;
                }),
                self::identicalTo(SerializerEvents::CLASS_METADATA_LOAD)
            );

        self::assertSame($classMetadata, $this->eventFactory->getClassMetadata($class));
    }

    public function testClassMetadataNotFoundEvent(): void
    {
        $classMetadata = $this->createClassMetadataMock();

        $this->factory
            ->expects(self::once())
            ->method('getClassMetadata')
            ->with(self::identicalTo($class = \stdClass::class))
            ->willReturn(null);

        $this->dispatcher
            ->expects(self::once())
            ->method('dispatch')
            ->with(
                self::callback(function ($event) use ($class, $classMetadata) {
                    if (!$event instanceof ClassMetadataNotFoundEvent) {
                        return false;
                    }

                    if ($event->getClass() !== $class) {
                        return false;
                    }

                    $event->setClassMetadata($classMetadata);

                    return true;
                }),
                self::identicalTo(SerializerEvents::CLASS_METADATA_NOT_FOUND)
            );

        self::assertSame($classMetadata, $this->eventFactory->getClassMetadata($class));
    }

    /**
     * @return \PHPUnit\Framework\MockObject\MockObject|ClassMetadataFactoryInterface
     */
    private function createClassMetadataFactoryMock()
    {
        return $this->createMock(ClassMetadataFactoryInterface::class);
    }

    /**
     * @return \PHPUnit\Framework\MockObject\MockObject|EventDispatcherInterface
     */
    private function createEventDispatcherMock()
    {
        return $this->createMock(EventDispatcherInterface::class);
    }

    /**
     * @return \PHPUnit\Framework\MockObject\MockObject|ClassMetadataInterface
     */
    private function createClassMetadataMock()
    {
        return $this->createMock(ClassMetadataInterface::class);
    }
}
