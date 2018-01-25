<?php

namespace Maps_red\OpenIDConnectBundle\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;

/**
 * Class OpenIDConnectExtension
 *
 * @author François MATHIEU <francois.mathieu@livexp.fr>
 */
class OpenIDConnectExtension extends Extension
{
    /**
     * @param array $configs
     * @param ContainerBuilder $container
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $openIdConnectConfig = $this->processConfiguration(new Configuration(), $configs);
        $container->setParameter('openid_connect', $openIdConnectConfig);

        // load bundle's services
        $loader = new YamlFileLoader($container, new FileLocator(__DIR__ . '/../Resources/config'));
        $loader->load('services.yaml');
    }

}


