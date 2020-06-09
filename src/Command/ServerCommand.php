<?php

namespace Ihsan\RatchetBundle\Command;

use Ratchet\Http\HttpServerInterface;
use Ratchet\Server\IoServer;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * @author Muhamad Surya Iksanudin <surya.kejawen@gmail.com>
 */
class ServerCommand extends Command
{
    private $server;

    private $port;

    public function __construct(HttpServerInterface $server, int $port)
    {
        $this->server = $server;
        $this->port = $port;

        parent::__construct();
    }

    protected function configure()
    {
        $this
            ->setName('ihsan:server:start')
            ->setDescription('Launch web socket server')
            ->setHelp('This command allows you to launch web socket server')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $server = IoServer::factory($this->server, $this->port);

        $server->run();
    }
}
