<?php

/*
 * This file is part of the ZapikSubdomainTranslationBUndle package.
 *
 * (c) Alois Kužela <kuzela.alois@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Zapik\SubdomainTranslationBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * This is the class that validates and merges configuration from your app/config files
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html#cookbook-bundles-extension-config-class}
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritDoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('zapik_subdomain_translation');

        /* app/config.yml example:
         *
         * zapik_subdomain_translation:
         *      allowed_locales:
         *          en: English
         *          cs: Česky
         *      translation_dir: %kernel.root_dir%/../src/Acme/DemoBundle/Resources/translations // TODO?
         */
        $rootNode
            ->children()
                ->arrayNode('allowed_locales')
                    ->performNoDeepMerging()
                    ->useAttributeAsKey('key') // convert array into associative array as we wish!
                    ->prototype('variable')
                    ->end()
                 ->end()
            ->end();


        return $treeBuilder;
    }
}
