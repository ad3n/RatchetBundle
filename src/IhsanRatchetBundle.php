<?php

namespace Ihsan\RatchetBundle;

use Ihsan\RatchetBundle\DependencyInjection\Compiler\MessageProcessorPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

/**
 * @author Muhamad Surya Iksanudin <surya.kejawen@gmail.com>
 */
final class IhsanRatchetBundle extends Bundle
{
    /**
     * @param ContainerBuilder $container
     */
    public function build(ContainerBuilder $container)
    {
        $container->addCompilerPass(new MessageProcessorPass());
    }
}
