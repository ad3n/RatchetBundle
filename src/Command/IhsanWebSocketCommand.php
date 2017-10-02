<?php

namespace Ihsan\RatchetBundle\Command;

use Ratchet\Server\IoServer;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * @author Muhamad Surya Iksanudin <surya.kejawen@gmail.com>
 */
class IhsanWebSocketCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('ihsan-ratchet:web-socket:start')
            ->setDescription('Launch web socket server')
            ->setHelp('This command allows you to launch web socket server')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $webSocket = $this->getContainer()->get('Ratchet\Http\HttpServer');
        $server = IoServer::factory($webSocket, (int) $this->getContainer()->getParameter('ihsan_ratchet.web_socket_port'));

        $server->run();
    }
}
