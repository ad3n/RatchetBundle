<?php

namespace Ihsan\RatchetBundle\DependencyInjection\Compiler;

use Ihsan\RatchetBundle\Processor\ChainMessageProcessor;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

/**
 * @author Muhamad Surya Iksanudin <surya.kejawen@gmail.com>
 */
final class MessageProcessorPass implements CompilerPassInterface
{
    /**
     * @param ContainerBuilder $container
     */
    public function process(ContainerBuilder $container)
    {
        if (!$container->hasDefinition(ChainMessageProcessor::class)) {
            return;
        }

        $services = $container->findTaggedServiceIds('ihsan_ratchet.message_processor');
        $processors = [];
        foreach ($services as $serviceId => $tags) {
            $processors[] = new Reference($serviceId);
        }

        $container->getDefinition(ChainMessageProcessor::class)->addArgument($processors);
    }
}
