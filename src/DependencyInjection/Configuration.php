<?php

namespace Ihsan\RatchetBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * @author Muhamad Surya Iksanudin <surya.kejawen@gmail.com>
 */
class Configuration implements ConfigurationInterface
{
    const ALIAS = 'ihsan_ratchet';

    /**
     * @return TreeBuilder
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();

        $root = $treeBuilder->root(self::ALIAS);
        $root
            ->addDefaultsIfNotSet()
            ->children()
                ->scalarNode('web_socket_port')
                    ->isRequired()
                    ->cannotBeEmpty()
                ->end()
            ->end()
        ;

        return $treeBuilder;
    }
}
