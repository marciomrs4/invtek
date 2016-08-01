<?php

namespace MRS\InventarioBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

class DefaultController extends Controller
{
    /**
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("/",name="index")
     *
     */
    public function indexAction()
    {
        return $this->redirectToRoute('home');
    }

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("/home",name="home")
     *
     */
    public function homeAction()
    {
        return $this->render('MRSInventarioBundle:Default:index.html.twig');
    }
}
