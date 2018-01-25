<?php


use Maps_red\OpenIDConnectBundle\Security\User\User;
use Maps_red\OpenIDConnectBundle\Security\User\UserProvider;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Generator\UrlGenerator;

/**
 * Class BasicController
 *
 * @author François MATHIEU <francois.mathieu@livexp.fr>
 * @method User getUser()
 */
class BasicController extends Controller
{
    public function homepageAction()
    {
        return $this->render("Maps_red/BasicController:Basic:homepage.html.twig");
    }

    public function logoutAction()
    {
        $token = $this->getUser()->getToken();
        $this->get('security.token_storage')->setToken(null);
        $this->get('session')->invalidate();
        $route = $this->generateUrl('openidconnect_homepage', [], UrlGenerator::ABSOLUTE_URL);
        $this->get(UserProvider::class)->logout($token, $route);
    }

}