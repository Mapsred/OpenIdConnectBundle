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
        $this->loadParameters($container, $openIdConnectConfig);

        // load bundle's services
        $loader = new YamlFileLoader($container, new FileLocator(__DIR__ . '/../Resources/config'));
        $loader->load('services.yaml');
        $loader->load('routing.yaml');
    }

    private function loadParameters(ContainerBuilder $container, $configs)
    {
        foreach ($configs as $key => $value) {
            $key = sprintf('open_id_connect.%s', $key);
            $container->setParameter($key, $value);
        }
    }

}


