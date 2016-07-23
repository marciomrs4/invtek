<?php

namespace MRS\InventarioBundle\Controller;

use Symfony\Component\Form\Tests\Extension\Core\Type\SubmitTypeTest;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use MRS\InventarioBundle\Entity\Equipamento;
use MRS\InventarioBundle\Form\EquipamentoReportType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

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
     * @Route("/", name="report_equipamento")
     * @Method("GET|POST")
     */
    public function reportEquipamentoAction(Request $request)
    {

        $tipocomponente = $request->request->get('equipamento_report');

        $em = $this->getDoctrine()->getManager();

        $tipoEquipamento = $em->getRepository('MRSInventarioBundle:Tipoequipamento')
            ->findBy(array('id'=>$tipocomponente['tipoequipamento']));

        $form = $this->createForm(EquipamentoReportType::class);


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
     * @Route("/equipomentos",name="report_relatorio_equipomentos")
     */
    public function relatorioEquipamentoAction()
    {
        $equipamentos = $this->getDoctrine()
            ->getRepository('MRSInventarioBundle:Equipamento')
            ->findAll();


    }

}
