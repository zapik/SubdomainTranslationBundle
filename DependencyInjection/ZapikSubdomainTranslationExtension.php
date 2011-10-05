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

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;
use Symfony\Component\Locale\Locale;


/**
 * This is the class that loads and manages your bundle configuration
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html}
 */
class ZapikSubdomainTranslationExtension extends Extension
{
    /**
     * {@inheritDoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);
        $loader = new Loader\XmlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.xml');

        // set all possible locales or only user defined subset
        $loader->load('locales.xml');
        $validLocales = $container->getParameter('zapik_subdomain_translation.valid_locales');
        if (empty($config['allowed_locales'])) {
            $container->setParameter('zapik_subdomain_translation.locales', $validLocales);
        } else {
            if ($config['validate_locales']) {
                // validate locales against internal defined
                $locales = array_keys($config['allowed_locales']);
                foreach ($locales as $locale) {
                    if (!isset($validLocales[$locale])) {
                        throw new \InvalidArgumentException(sprintf('Unknown locale "%s".', $locale));
                    }
                }
            }
            $container->setParameter('zapik_subdomain_translation.locales', $config['allowed_locales']);
        }
    }
}
