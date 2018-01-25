<?php

/*
 * This file is part of the MorningCheck Project
 *
 * (c) 2017 LiveXP <dev@livexp.fr>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Maps_red\OpenIdConnectBundle\Security\User;

use OpenIDConnectClient;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;

/**
 * UserProvider to fetch the user with OpenID
 *
 * @author François MATHIEU <francois.mathieu@livexp.fr>
 */
class UserProvider implements UserProviderInterface
{
    /**
     * The issuer for the openID connection
     *
     * @var string $openidIssuer
     */
    private $openidIssuer;

    /**
     * The client id for the openID connection
     *
     * @var string $openidClientId
     */
    private $openidClientId;

    /**
     * The client secret for the openID connection
     *
     * @var string $openidClientSecret
     */
    private $openidClientSecret;

    /**
     * @var OpenIDConnectClient $openIDConnectClient
     */
    private $openIDConnectClient;

    /**
     * The parameters for the openID connection
     *
     * @var array $openid_parameters
     */
    private $openid_parameters;

    /**
     * UserProvider constructor.
     *
     * @param string $openidIssuer
     * @param string $openidClientId
     * @param string $openidClientSecret
     * @param array $openidParameters
     */
    public function __construct($openidIssuer, $openidClientId, $openidClientSecret, array $openidParameters)
    {
        $this->openidIssuer = $openidIssuer;
        $this->openidClientId = $openidClientId;
        $this->openidClientSecret = $openidClientSecret;
        $this->openIDConnectClient = new OpenIDConnectClient($this->openidIssuer, $this->openidClientId, $this->openidClientSecret);
        $this->openid_parameters = $openidParameters;
    }

    /**
     * @return OpenIDConnectClient
     */
    public function getOpenIDConnectClient()
    {
        return $this->openIDConnectClient;
    }

    /**
     * Redirect the user to the OpenID connection page
     *
     * @return array
     */
    public function authenticate()
    {
        $this->getOpenIDConnectClient()->providerConfigParam($this->openid_parameters);
        $this->getOpenIDConnectClient()->authenticate();
        $infos = (array)$this->getOpenIDConnectClient()->requestUserInfo();
        $infos['token'] = $this->getOpenIDConnectClient()->getAccessToken();

        return $infos;
    }

    /**
     * Redirect the user to the OpenID signout page so he can logi n with another account
     *
     * @param mixed|string $token
     * @param mixed|string $url
     */
    public function logout($token, $url)
    {
        $this->getOpenIDConnectClient()->signOut($token, $url);
    }

    /**
     * Inherited from UserProviderInterface, not used here

     * @param string $username The username
     *
     * @return null
     */
    public function loadUserByUsername($username)
    {
        return null;
    }

    /**
     * @param UserInterface $user
     *
     * @return UserInterface
     */
    public function refreshUser(UserInterface $user)
    {
        return $user;
    }

    /**
     * @param string $class
     *
     * @return bool
     */
    public function supportsClass($class)
    {
        return $class === User::class;
    }

    /**
     * Create and return an User object with default values for testing purpose
     *
     * @return User
     */
    public function getTestUser()
    {
        $user = new User();
        $user
            ->setUsername("TestUser")
            ->setFirstName("Test")
            ->setLastName("User")
            ->setFullname("TestUser")
            ->setEmail("testusr@test.com")
            ->setToken("testToken");

        return $user;
    }
}