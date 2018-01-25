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
        $rootNode = $treeBuilder->root('openid_connect');

        $rootNode
            ->children()
                ->scalarNode('issuer')
                    ->info('The base URL of the issuer')
                    ->isRequired()
                ->end()
                ->scalarNode('openid_client_secret')
                    ->info('The client Secret')
                    ->isRequired()
                ->end()
            ->end()
            ->arrayNode("parameters")
                ->addDefaultChildrenIfNoneSet()
                ->children()
                    ->scalarNode('authorization_endpoint')
                    ->defaultValue('%openid_connect.issuer%/protocol/openid-connect/auth')
                ->end()
                ->children()
                    ->scalarNode('token_endpoint')
                    ->defaultValue('%openid_connect.issuer%/protocol/openid-connect/token')
                ->end()
                ->children()
                    ->scalarNode('token_introspection_endpoint')
                    ->defaultValue('%openid_connect.issuer%/protocol/openid-connect/token/introspect')
                ->end()
                ->children()
                    ->scalarNode('userinfo_endpoint')
                    ->defaultValue('%openid_connect.issuer%/protocol/openid-connect/userinfo')
                ->end()
                ->children()
                    ->scalarNode('end_session_endpoint')
                    ->defaultValue('%openid_connect.issuer%/protocol/openid-connect/logout')
                ->end()
                ->children()
                    ->scalarNode('jwks_uri')
                    ->defaultValue('%openid_connect.issuer%/protocol/openid-connect/certs')
                ->end()
                ->children()
                    ->scalarNode('check_session_iframe')
                    ->defaultValue('%openid_connect.issuer%/protocol/openid-connect/login-status-iframe.html')
                ->end()
            ->end();


        return $treeBuilder;
    }
}

