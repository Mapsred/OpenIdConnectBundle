<?php

/*
 * This file is part of the MorningCheck Project
 *
 * (c) 2017 LiveXP <dev@livexp.fr>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Maps_red\OpenIDConnectBundle\Security\User;

use Symfony\Component\Security\Core\User\UserInterface;

/**
 * Class User
 *
 * @author François MATHIEU <francois.mathieu@livexp.fr>
 */
class User implements UserInterface
{
    /** @var string $username */
    protected $username;
    /** @var array $roles */
    protected $roles = ['ROLE_USER'];
    /** @var string $firstname */
    protected $firstname;
    /** @var string $lastname */
    protected $lastname;
    /** @var string $email */
    protected $email;
    /** @var string $fullname */
    protected $fullname;
    /** @var string $token */
    protected $token;

    /**
     * @return array
     */
    public function getRoles()
    {
        return $this->roles;
    }

    /**
     * Inherited from UserInterface, not used here
     *
     * @return string
     */
    public function getPassword()
    {
        return null;
    }

    /**
     * Inherited from UserInterface, not used here
     *
     * @return null|string
     */
    public function getSalt()
    {
        return null;
    }

    /**
     * @return string
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * Inherited from UserInterface, not used here
     */
    public function eraseCredentials()
    {
    }

    /**
     * @param mixed $username
     *
     * @return User
     */
    public function setUsername($username)
    {
        $this->username = $username;

        return $this;
    }

    /**
     * @param mixed $roles
     *
     * @return User
     */
    public function setRoles($roles)
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @return string
     */
    public function getFirstname()
    {
        return $this->firstname;
    }

    /**
     * @param string $firstname
     *
     * @return User
     */
    public function setFirstname($firstname)
    {
        $this->firstname = $firstname;

        return $this;
    }

    /**
     * @return string
     */
    public function getLastname()
    {
        return $this->lastname;
    }

    /**
     * @param string $lastname
     *
     * @return User
     */
    public function setLastname($lastname)
    {
        $this->lastname = $lastname;

        return $this;
    }

    /**
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param string $email
     *
     * @return User
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * @return string
     */
    public function getFullname()
    {
        return $this->fullname;
    }

    /**
     * @param string $fullname
     *
     * @return User
     */
    public function setFullname($fullname)
    {
        $this->fullname = $fullname;

        return $this;
    }

    /**
     * @return string
     */
    public function getToken()
    {
        return $this->token;
    }

    /**
     * @param string $token
     *
     * @return User
     */
    public function setToken($token)
    {
        $this->token = $token;

        return $this;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return (string) $this->fullname;
    }
}