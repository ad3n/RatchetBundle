<?php

namespace Ihsan\RatchetBundle\DependencyInjection;

use Ihsan\RatchetBundle\Message\MessageFactory;
use Ratchet\Http\HttpServer;
use Ratchet\WebSocket\WsServer;
use Symfony\Component\Config\Definition\Processor;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;
use Symfony\Component\Finder\Finder;

/**
 * @author Muhamad Surya Iksanudin <surya.kejawen@gmail.com>
 */
class IhsanRatchetExtension extends Extension
{
    /**
     * @param array            $configs   An array of configuration values
     * @param ContainerBuilder $container A ContainerBuilder instance
     *
     * @throws \InvalidArgumentException When provided tag is not defined in this extension
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $reflection = new \ReflectionObject($this);
        $directory = sprintf('%s/../Resources/config', dirname($reflection->getFileName()));

        $loader = new XmlFileLoader($container, new FileLocator($directory));

        $finder = new Finder();
        $finder->in($directory);
        $finder->ignoreDotFiles(true);
        $files = $finder->files()->name('*.xml');

        foreach ($files as $file) {
            /* @var \SplFileInfo $file */
            $loader->load($file->getFilename());
        }

        $processor = new Processor();
        $configuration = new Configuration();
        $config = $processor->processConfiguration($configuration, $configs);

        $container->setParameter('ihsan_ratchet.web_socket_port', $config['web_socket_port']);
    }
}