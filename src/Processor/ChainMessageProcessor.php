<?php

namespace Ihsan\RatchetBundle\Processor;

use Ihsan\RatchetBundle\Exception\InvalidMessageException;
use Ihsan\RatchetBundle\Message\Message;
use Ratchet\ConnectionInterface;

/**
 * @author Muhamad Surya Iksanudin <surya.kejawen@gmail.com>
 */
final class ChainMessageProcessor implements MessageProcessorInterface
{
    /**
     * @var MessageProcessorInterface[]
     */
    private $messageProcessors;

    /**
     * @param array $messageProcessors
     */
    public function __construct(array $messageProcessors = [])
    {
        $this->messageProcessors = $messageProcessors;
    }

    /**
     * @param ConnectionInterface $connection
     * @param Message             $message
     *
     * @return Message
     */
    public function process(ConnectionInterface $connection, Message $message): Message
    {
        foreach ($this->messageProcessors as $messageProcessor) {
            try {
                return $messageProcessor->process($connection, $message);
            } catch (InvalidMessageException $e) {
                continue;
            }
        }

        throw new InvalidMessageException(sprintf('No processor can process %s', $message->getMessage()));
    }
}
