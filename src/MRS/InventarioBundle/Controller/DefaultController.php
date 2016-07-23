<?php

namespace MRS\InventarioBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

class DefaultController extends Controller
{
    /**
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("/",name="home")
     *
     */
    public function indexAction()
    {
        return $this->render('MRSInventarioBundle:Default:index.html.twig');
    }
}
