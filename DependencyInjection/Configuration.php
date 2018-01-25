<?php

namespace Maps_red\OpenIDConnectBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * Class Configuration
 *
 * @author François MATHIEU <francois.mathieu@livexp.fr>
 */
class Configuration implements ConfigurationInterface
{
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('open_id_connect');

        $rootNode
            ->children()
                ->scalarNode('issuer')
                    ->info('The base URL of the issuer')
                ->end()
                ->scalarNode('client_id')
                    ->info('The client id')
                ->end()
                ->scalarNode('client_secret')
                    ->info('The client Secret')
                ->end()
            ->end()
            ->children()
                ->arrayNode("parameters")
                ->addDefaultsIfNotSet()
                    ->children()
                        ->scalarNode('authorization_endpoint')
                            ->defaultValue('%open_id_connect.issuer%/protocol/openid-connect/auth')
                        ->end()
                        ->scalarNode('token_endpoint')
                            ->defaultValue('%open_id_connect.issuer%/protocol/openid-connect/token')
                        ->end()
                        ->scalarNode('token_introspection_endpoint')
                            ->defaultValue('%open_id_connect.issuer%/protocol/openid-connect/token/introspect')
                        ->end()
                        ->scalarNode('userinfo_endpoint')
                            ->defaultValue('%open_id_connect.issuer%/protocol/openid-connect/userinfo')
                        ->end()
                        ->scalarNode('end_session_endpoint')
                            ->defaultValue('%open_id_connect.issuer%/protocol/openid-connect/logout')
                        ->end()
                        ->scalarNode('jwks_uri')
                            ->defaultValue('%open_id_connect.issuer%/protocol/openid-connect/certs')
                        ->end()
                        ->scalarNode('check_session_iframe')
                            ->defaultValue('%open_id_connect.issuer%/protocol/openid-connect/login-status-iframe.html')
                        ->end()
                    ->end()
            ->end();

        return $treeBuilder;
    }
}

