<?php
namespace MRS\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;


class LoginController extends Controller
{

    public function loginAction()
    {

        $authenticationUtils = $this->get('security.authentication_utils');

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();

        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('@User/Login/login.html.twig',[
            'last_username' => $lastUsername,
            'error'         => $error,
        ]);

    }


    public function loginCheckAction()
    {

    }


    public function logoutAction()
    {

    }

}
