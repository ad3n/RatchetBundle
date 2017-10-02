<?php

namespace Ihsan\RatchetBundle\Message;

use Ihsan\RatchetBundle\Processor\MessageProcessorInterface;
use Psr\Log\LoggerInterface;
use Ratchet\AbstractConnectionDecorator;
use Ratchet\ConnectionInterface;
use Ratchet\MessageComponentInterface;

/**
 * @author Muhamad Surya Iksanudin <surya.kejawen@gmail.com>
 */
final class MessageFactory implements MessageComponentInterface
{
    /**
     * @var \SplObjectStorage
     */
    private $clients;

    /**
     * @var MessageProcessorInterface
     */
    private $messageProcessor;

    /**
     * @var LoggerInterface
     */
    private $logger;

    /**
     * @param MessageProcessorInterface       $messageProcessor
     * @param LoggerInterface                 $logger
     */
    public function __construct(MessageProcessorInterface $messageProcessor, LoggerInterface $logger = null)
    {
        $this->messageProcessor = $messageProcessor;
        $this->logger = $logger;
        $this->clients = new \SplObjectStorage();
    }

    /**
     * When a new connection is opened it will be passed to this method.
     *
     * @param ConnectionInterface $conn The socket/connection that just connected to your application
     *
     * @throws \Exception
     */
    public function onOpen(ConnectionInterface $conn)
    {/* @var AbstractConnectionDecorator $conn */
        $this->clients->attach($conn);
        if ($this->logger) {
            $this->logger->info(sprintf('New connection with resourceId: %s', $conn->resourceId));
        }
    }

    /**
     * This is called before or after a socket is closed (depends on how it's closed).  SendMessage to $conn will not result in an error if it has already been closed.
     *
     * @param ConnectionInterface $conn The socket/connection that is closing/closed
     *
     * @throws \Exception
     */
    public function onClose(ConnectionInterface $conn)
    {/* @var AbstractConnectionDecorator $conn */
        $this->clients->detach($conn);
        if ($this->logger) {
            $this->logger->info(sprintf('ResourceId %s disconnection', $conn->resourceId));
        }
    }

    /**
     * If there is an error with one of the sockets, or somewhere in the application where an Exception is thrown,
     * the Exception is sent back down the stack, handled by the Server and bubbled back up the application through this method.
     *
     * @param ConnectionInterface $conn
     * @param \Exception          $e
     *
     * @throws \Exception
     */
    public function onError(ConnectionInterface $conn, \Exception $e)
    {/* @var AbstractConnectionDecorator $conn */
        if ($this->logger) {
            $this->logger->error(sprintf('ResourceId %s error with message: %s', $conn->resourceId, $e->getMessage()));
        }
        $conn->close();
    }

    /**
     * Triggered when a client sends data through the socket.
     *
     * @param \Ratchet\ConnectionInterface $from The socket/connection that sent the message to your application
     * @param string                       $msg  The message received
     *
     * @throws \Exception
     */
    public function onMessage(ConnectionInterface $from, $msg)
    {
        $message = $this->messageProcessor->process($from, new Message($msg));
        foreach ($this->clients as $client) {
            $client->send($message->getMessage());
        }
    }
}
