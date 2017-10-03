#Ihsan Ratchet Bundle

## Install 

Just add ```"ad3n/ratchet-bundle": "~0.1"```

## Activating Bundle

Add ```new Ihsan\RatchetBundle\IhsanRatchetBundle()``` in your `AppKernel.php`

## Create Your Message Processor

```php
<?php

namespace YourBundle\Message\Processor;

use Ihsan\RatchetBundle\Message\Message;
use Ihsan\RatchetBundle\Processor\MessageProcessorInterface;
use Ratchet\ConnectionInterface;

/**
 * @author Muhamad Surya Iksanudin <surya.kejawen@gmail.com>
 */
class MyOwnMessageProcessor implements MessageProcessorInterface
{
    /**
     * @param ConnectionInterface $connection
     * @param Message $message
     *
     * @return Message
     */
    public function process(ConnectionInterface $connection, Message $message): Message
    {
        //$message is message send by the client
        //Your Own Logic
        
        return $message;//return original message or
        
        //return new Message(json_encode(['message' => 'Hello', 'more_data_to_expose' => $data]));
    }
}

```

## Create Service

You must add tag `ihsan_ratchet.message_processor` to register your own message processor

```yaml
    YourBundle\Message\Processor\MyOwnMessageProcessor:
        tags:
            - { name: 'ihsan_ratchet.message_processor' }
```

## Add Configuration Key

```yaml
ihsan_ratchet:
    web_socket_port: 7777
```

## Start Server

Run ```php bin/console ihsan-ratchet:web-socket:start```
