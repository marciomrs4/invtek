<?php

namespace MRS\BackupBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use MRS\BackupBundle\Entity\Fita;

/**
 * Fita controller.
 *
 * @Route("/report/fita")
 */
class FitaReportController extends Controller
{
    /**
     *
     * @Route("/utilizacao", name="report_utilizacao_by_fita")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $fitas = $em->getRepository('MRSBackupBundle:Fita')
            ->listarQuantidadeUtilizadaByFita();

        return $this->render('@MRSBackup/FitaReport/index.html.twig', array(
            'fitas' => $fitas,
        ));
    }


}
