<?php

namespace MRS\InventarioBundle\Controller;


use MRS\InventarioBundle\Form\Report\AcompanhamentoReportType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use MRS\InventarioBundle\Entity\Acompanhamento;

/**
 * Acompanhamento controller.
 *
 * @Route("/report/acompanhamento")
 */
class AcompanhamentoReportController extends Controller
{
    /**
     * Lists all Acompanhamento entities.
     *
     * @Route("/equipamento", name="report_acompanhamento_equipamento")
     * @Method("GET|POST")
     */
    public function reportAcompanhamentoAction(Request $request)
    {
        $form = $this->createForm(AcompanhamentoReportType::class);

        $form->add('tipoAcompanhamento',EntityType::class,array('label'=>'Tipo de Acompanhamento',
        'attr'=>array('class'=>'input-sm'),
        'class'=>'MRS\InventarioBundle\Entity\Tipoacompanhamento',
        'placeholder'=>'Todos'));

        $acompanhamentos = '';

        $em = $this->getDoctrine()->getManager();

//        $equipamentosNoAcompanhamento = $em->getRepository('MRSInventarioBundle:Acompanhamento')
//            ->getAllEquipamentoNoAcompanhamento(null);

        if($request->getMethod() == 'POST') {

            $form->handleRequest($request);

            $acompanhamentos = $em->getRepository('MRSInventarioBundle:Acompanhamento')
                ->getAllAcompanhamento($request->request->get('report_acompanhamento'));
        }

        return $this->render(':acompanhamentoreport:reportacompanhamento.html.twig', array(
            'acompanhamentos' => $acompanhamentos,
            //'equipamentoNoAcompanhamento' => $equipamentosNoAcompanhamento,
            'form_acompanhamento' => $form->createView()
        ));
    }

    /**
     *
     * @Route("/equipamentonoacompanhamento", name="report_equipamento_no_acompanhamento")
     * @Method("GET|POST")
     */
    public function reportEquipamentoNoAcompanhamentoAction(Request $request)
    {
        $form = $this->createForm(AcompanhamentoReportType::class);

        $acompanhamentos = '';

        if($request->getMethod() == 'POST') {
            $form->handleRequest($request);
        }

        $em = $this->getDoctrine()->getManager();

        $acompanhamentos = $em->getRepository('MRSInventarioBundle:Acompanhamento')
            ->getAllEquipamentoNoAcompanhamento($request->request->get('report_acompanhamento'));

        return $this->render(':acompanhamentoreport:reportequipamentonoacompanhamento.html.twig', array(
            'acompanhamentos' => $acompanhamentos,
            'form_acompanhamento' => $form->createView()
        ));
    }

}
