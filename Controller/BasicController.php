<?php

namespace Maps_red\OpenIDConnectBundle\Controller;

use Maps_red\OpenIDConnectBundle\Security\User\User;
use Maps_red\OpenIDConnectBundle\Security\User\UserProvider;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Generator\UrlGenerator;

/**
 * Class BasicController
 *
 * @author François MATHIEU <francois.mathieu@livexp.fr>
 * @method User getUser()
 */
class BasicController extends Controller
{
    /**
     * @Route("/", name="openidconnect_homepage")
     *
     * @return Response
     */
    public function homepageAction()
    {
        return $this->render("@OpenIDConnect/Basic/homepage.html.twig");
    }

    /**
     * @Route("/logout", name="openidconnect_logout")
     */
    public function logoutAction()
    {
        $token = $this->getUser()->getToken();
        $this->get('security.token_storage')->setToken(null);
        $this->get('session')->invalidate();
        $route = $this->generateUrl('openidconnect_homepage', [], UrlGenerator::ABSOLUTE_URL);
        $this->container->get(UserProvider::class)->logout($token, $route);
    }
}