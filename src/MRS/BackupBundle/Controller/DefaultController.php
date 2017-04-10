<?php

namespace MRS\BackupBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{

    public function indexAction()
    {
        return $this->render('MRSBackupBundle:Default:index.html.twig');
    }
}
