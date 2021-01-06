<?php

/*
 * This file is part of the Ivory Serializer package.
 *
 * (c) Eric GELOEN <geloen.eric@gmail.com>
 *
 * For the full copyright and license information, please read the LICENSE
 * file that was distributed with this source code.
 */

namespace Ivory\Serializer\Mapping\Factory;

use Ivory\Serializer\Event\ClassMetadataLoadEvent;
use Ivory\Serializer\Event\ClassMetadataNotFoundEvent;
use Ivory\Serializer\Event\SerializerEvents;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

/**
 * @author GeLo <geloen.eric@gmail.com>
 */
class EventClassMetadataFactory implements ClassMetadataFactoryInterface
{
    /**
     * @var ClassMetadataFactoryInterface
     */
    private $factory;

    /**
     * @var EventDispatcherInterface
     */
    private $dispatcher;

    public function __construct(ClassMetadataFactoryInterface $factory, EventDispatcherInterface $dispatcher)
    {
        $this->factory = $factory;
        $this->dispatcher = $dispatcher;
    }

    /**
     * {@inheritdoc}
     */
    public function getClassMetadata($class)
    {
        $classMetadata = $this->factory->getClassMetadata($class);

        if (null === $classMetadata) {
            $this->dispatcher->dispatch(
                $event = new ClassMetadataNotFoundEvent($class),
                SerializerEvents::CLASS_METADATA_NOT_FOUND
            );
        } else {
            $this->dispatcher->dispatch(
                $event = new ClassMetadataLoadEvent($classMetadata),
                SerializerEvents::CLASS_METADATA_LOAD
            );
        }

        return $event->getClassMetadata();
    }
}
