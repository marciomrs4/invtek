<?php

namespace MRS\BackupBundle\Controller;

use MRS\BackupBundle\Entity\RegistroBackup;
use MRS\InventarioBundle\Entity\Equipamento;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use MRS\BackupBundle\Form\RegistroBackupEquipamentoReportType;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

/**
 * Fita controller.
 *
 * @Route("/report/backup")
 */
class RegistroBackupEquipamentoReportController extends Controller
{
    /**
     *
     * @Route("/equipamento", name="report_backup_equipamento")
     * @Method("GET|POST")
     */
    public function indexAction(Request $request)
    {
        $form = $this->createForm(RegistroBackupEquipamentoReportType::class);

        $date = new \DateTime('now');

        $form->get('data2')->setData($date);

        $form->get('data1')->setData($date->modify('-30days'));

        $backups = array();

        if($request->isMethod('POST')) {

            $form->handleRequest($request);

            $dados = $request->request->all();

            $em = $this->getDoctrine()->getManager();

            $backups = $em->getRepository('MRSBackupBundle:RegistroBackupEquipamento')
                ->listarEquipamentosBackup($dados['registro_backup_equipamento_report']);
        }

        return $this->render('@MRSBackup/RegistroBackupEquipamento/index.html.twig',[
            'equipamento_form' => $form->createView(),
            'backups' => $backups
        ]);
    }


    /**
     * @Route("/show/{id}",name="show_report_equipamento_report")
     * @Method("GET")
     */
    public function showBackupEquipamentoReportAction(RegistroBackup $id)
    {
        return $this->render('MRSBackupBundle:RegistroBackupEquipamento:show.html.twig',[
           'registroBackup' => $id
        ]);
    }

}
