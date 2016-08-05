<?php

namespace MRS\InventarioBundle\Controller;

use Symfony\Component\Form\Tests\Extension\Core\Type\SubmitTypeTest;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use MRS\InventarioBundle\Entity\Equipamento;
use MRS\InventarioBundle\Form\Report\PainelEquipamentoReportType;
use MRS\InventarioBundle\Form\Report\EquipamentoReportType;


/**
 * Equipamento controller.
 *
 * @Route("/report/equipamento")
 */
class EquipamentoReportController extends Controller
{
    /**
     * Lists all Equipamento entities.
     *
     * @Route("/painel", name="report_painel_equipamento")
     * @Method("GET|POST")
     */
    public function reportEquipamentoAction(Request $request)
    {

        $tipocomponente = $request->request->get('equipamento_report');

        $em = $this->getDoctrine()->getManager();

        $tipoEquipamento = $em->getRepository('MRSInventarioBundle:Tipoequipamento')
            ->findBy(array('id'=>$tipocomponente['tipoequipamento']));

        $form = $this->createForm(PainelEquipamentoReportType::class);

        $form->handleRequest($request);

        $equipamentos = $em->getRepository('MRSInventarioBundle:Equipamento')
            ->findBy(array('tipoequipamento'=> $tipoEquipamento));

        return $this->render('equipamentoreport/index.html.twig', array(
            'equipamentos' => $equipamentos,
            'form' => $form->createView()

        ));
    }

    /**
     * Lists all Equipamento entities.
     *
     * @Route("/moreinformation/{equipamento}", name="report_equipamento_moreinformation")
     * @Method("GET|POST")
     */
    public function moreInformationAction(Equipamento $equipamento)
    {

        $manyequipamentos = $this->getDoctrine()
            ->getRepository('MRSInventarioBundle:EquipamentoHasEquipamento')
            ->findBy(array('equipamentoPai' => $equipamento));

        $equipamentosFilho = $this->getDoctrine()
            ->getRepository('MRSInventarioBundle:EquipamentoHasEquipamento')
            ->findBy(array('equipamentoFilho' => $equipamento));

        $tags = $this->getDoctrine()
            ->getRepository('MRSInventarioBundle:EquipamentoTag')
            ->findBy(array('equipamento'=>$equipamento),
                array('descricao'=>'DESC'));

        $softwares = $this->getDoctrine()
            ->getRepository('MRSInventarioBundle:EquipamentoHasSoftware')
            ->findBy(array('equipamento'=>$equipamento));

        $componentes = $this->getDoctrine()
            ->getRepository('MRSInventarioBundle:EquipamentoHasComponente')
            ->findBy(array('equipamento'=>$equipamento),
                array('componente'=>'DESC'));

        return $this->render('equipamentoreport/moreinformation.html.twig', array(
            'equipamento' => $equipamento,
            'tags'=>$tags,
            'softwares'=>$softwares,
            'componentes'=>$componentes,
            'manyequipamentos' => $manyequipamentos,
            'equipamentosFilho' => $equipamentosFilho,
        ));

    }

    /**
     * @Route("/equipamentos",name="report_relatorio_equipamentos")
     */
    public function relatorioEquipamentoAction(Request $request)
    {

        $form = $this->createForm(EquipamentoReportType::class);

        $date = new \DateTime('now');

        $form->get('dataCompraA')->setData($date->modify('-240 day'));

        $form->get('dataCompraB')->setData($date->modify('+240 day'));


        if($request->isMethod('POST')) {
            $form->handleRequest($request);
        }

        $equipamentosForm = $request->request->get('report_equipamentos');

        $equipamentos = $this->getDoctrine()
            ->getRepository('MRSInventarioBundle:Equipamento')
            ->reportEquipamentos($equipamentosForm);

        return $this->render(':equipamentoreport:equipamentos.html.twig',array(
            'equipamentos' => $equipamentos,
            'form' => $form->createView()
        ));

    }

    /**
     * @Route("/export/equipamentos",name="report_export_relatorio_equipamentos")
     */
    public function relatorioEquipamentoExportToExcelAction(Request $request)
    {

        $equipamentosForm = $request->request->get('report_equipamentos');

        $equipamentos = $this->getDoctrine()
            ->getRepository('MRSInventarioBundle:Equipamento')
            ->reportEquipamentos($equipamentosForm);

        $response =  $this->render(':equipamentoreport:exportequipamentos.html.twig',array(
            'equipamentos' => $equipamentos
        ));

        $response->headers->set('Content-Type', 'text/csv');

        $response->headers->set('Content-Disposition', 'attachment; filename=Equipamentos.csv');

        return $response;

    }

}
