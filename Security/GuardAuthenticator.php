<?php

/*
 * This file is part of the MorningCheck Project
 *
 * (c) 2017 LiveXP <dev@livexp.fr>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Maps_red\OpenIDConnectBundle\Security;

use Maps_red\OpenIDConnectBundle\Security\User\User;
use Maps_red\OpenIDConnectBundle\Security\User\UserProvider;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Router;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Guard\AbstractGuardAuthenticator;

/**
 * Class GuardAuthenticator
 * Custom Authenticator used for this interface
 *
 * @author François MATHIEU <francois.mathieu@livexp.fr>
 */
class GuardAuthenticator extends AbstractGuardAuthenticator
{
    /** @var UserProvider $provider */
    private $provider;
    /** @var Router $router */
    private $router;

    /**
     * LiveXPAuthenticator constructor.
     *
     * @param UserProvider $provider
     * @param Router $router
     */
    public function __construct(UserProvider $provider, Router $router)
    {
        $this->provider = $provider;
        $this->router = $router;
    }

    /**
     * {@inheritdoc}
     */
    public function getCredentials(Request $request)
    {
        if ($request->getPathInfo() != '/login') {
            return null;
        }
        $userData = $this->provider->authenticate();

        return [
            'username' => $userData['preferred_username'],
            'fullname' => $userData['name'],
            'email' => $userData['email'],
            'firstname' => $userData['given_name'],
            'lastname' => $userData['family_name'],
            'token' => $userData['token']
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function start(Request $request, AuthenticationException $authException = null)
    {
        return new RedirectResponse($this->router->generate('login'));
    }

    /**
     * {@inheritdoc}
     */
    public function getUser($credentials, UserProviderInterface $userProvider)
    {
        $user = new User();
        $user
            ->setUsername($credentials['username'])
            ->setFirstName($credentials['firstname'])
            ->setLastName($credentials['lastname'])
            ->setFullname($credentials['fullname'])
            ->setEmail($credentials['email'])
            ->setToken($credentials['token'])
        ;

        return $user;
    }

    /**
     * {@inheritdoc}
     */
    public function checkCredentials($credentials, UserInterface $user)
    {
        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function onAuthenticationFailure(Request $request, AuthenticationException $exception)
    {
        $request->getSession()->set(Security::AUTHENTICATION_ERROR, $exception);

        return new RedirectResponse($this->router->generate('login'));
    }

    /**
     * {@inheritdoc}
     */
    public function onAuthenticationSuccess(Request $request, TokenInterface $token, $providerKey)
    {
        return new RedirectResponse($this->router->generate('openidconnect_homepage'));
    }

    /**
     * {@inheritdoc}
     */
    public function supportsRememberMe()
    {
        return false;
    }

    /**
     * Does the authenticator support the given Request?
     *
     * If this returns false, the authenticator will be skipped.
     *
     * @param Request $request
     *
     * @return bool
     */
    public function supports(Request $request)
    {
        return $this->getCredentials($request) !== null;
    }
}