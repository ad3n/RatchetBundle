<?php

namespace Ihsan\RatchetBundle\Processor;

use Ihsan\RatchetBundle\Message\Message;
use Ratchet\ConnectionInterface;

/**
 * @author Muhamad Surya Iksanudin <surya.kejawen@gmail.com>
 */
interface MessageProcessorInterface
{
    /**
     * @param ConnectionInterface $connection
     * @param Message $message
     *
     * @return Message
     */
    public function process(ConnectionInterface $connection, Message $message): Message;
}