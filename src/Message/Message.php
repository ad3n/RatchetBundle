<?php

namespace Ihsan\RatchetBundle\Message;

/**
 * @author Muhamad Surya Iksanudin <surya.kejawen@gmail.com>
 */
final class Message
{
    /**
     * @var string
     */
    private $message;

    /**
     * @param string $message
     */
    public function __construct(string $message)
    {
        $this->message = $message;
    }

    /**
     * @return string
     */
    public function getMessage(): string
    {
        return $this->message;
    }
}
