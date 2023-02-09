<?php

namespace Thumper\Test;

use Thumper\AnonConsumer;

class AnonConsumerTest extends BaseTest
{
    public function testQueueOptionsAreSetProperly()
    {
        $connection = $this->getMockConnection(array('channel'));
        $connection->expects($this->once())
            ->method('channel');

        $consumer = new AnonConsumer($connection);

        $queueOptionsReflectionProperty = new \ReflectionProperty(AnonConsumer::class, 'queueOptions');
        $queueOptionsReflectionProperty->setAccessible(true);
        $queueOptionsValue = $queueOptionsReflectionProperty->getValue($consumer);

        $this->assertSame(
            [
                'name' => '',
                'passive' => false,
                'durable' => false,
                'exclusive' => true,
                'auto_delete' => true,
                'nowait' => false,
                'arguments' => null,
                'ticket' => null
            ],
            $queueOptionsValue
        );

        $connectionReflectionProperty = new \ReflectionProperty(AnonConsumer::class, 'connection');
        $connectionReflectionProperty->setAccessible(true);
        $connectionValue = $connectionReflectionProperty->getValue($consumer);

        $this->assertSame($connection, $connectionValue);
    }
}
