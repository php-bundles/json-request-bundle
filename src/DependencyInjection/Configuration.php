<?php declare(strict_types=1);

namespace SymfonyBundles\JsonRequestBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder('json_request');

        $treeBuilder->getRootNode()  // @phpstan-ignore-line
            ->children()
                ->arrayNode('content_types')
                    ->beforeNormalization()
                        ->ifNull()
                        ->thenUnset()
                    ->end()
                    ->beforeNormalization()
                        ->castToArray()
                    ->end()
                    ->defaultValue(['json', 'jsonld'])
                    ->requiresAtLeastOneElement()
                    ->scalarPrototype()->end()
                ->end()
            ->end()
        ;

        return $treeBuilder;
    }
}
