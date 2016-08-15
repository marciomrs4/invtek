<?php

namespace MRS\InventarioBundle\Controller;

use MRS\InventarioBundle\Entity\Movimentacao;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use MRS\InventarioBundle\Form\Report\MovimentacoesReportType;


/**
 * Equipamento controller.
 *
 * @Route("/report/movimentacao")
 */
class MovimentacaoReportController extends Controller
{

    /**
     * @Route("/doc/{movimentacao}",name="report_doc_movimentacao")
     * @Method("GET")
     */
    public function docMovimentacaoAction(Movimentacao $movimentacao)
    {

        if(!$movimentacao) {
            throw $this->createNotFoundException('Movimentacao não encontrada!');
        }

        $itensMovimentacao = $this->getDoctrine()
            ->getRepository('MRSInventarioBundle:ItensMovimentacao')
            ->findBy(array('movimentacao'=>$movimentacao));


        return $this->render(':movimentacaoreport:docmovimentacao.html.twig',array(
            'movimentacao' => $movimentacao,
            'itensMovimentacao' => $itensMovimentacao
        ));

    }

    /**
     * @Route("/",name="report_movimentacoes")
     * @Method("GET|POST")
     */
    public function relatorioMovimentacaoAction(Request $request)
    {

        $form = $this->createForm(MovimentacoesReportType::class);

        $date = new \DateTime('now');

        $form->get('dataMovimentacaoA')->setData($date->modify('-240 day'));

        $form->get('dataMovimentacaoB')->setData($date->modify('+240 day'));


        if($request->isMethod('POST')) {
            $form->handleRequest($request);
        }

        $movimentacaoForm = $request->request->get('report_movimentacoes');

        $movimentacoes = $this->getDoctrine()
            ->getRepository('MRSInventarioBundle:Movimentacao')
            ->reportMovimentacao($movimentacaoForm);

        return $this->render(':movimentacaoreport:movimentacoes.html.twig',array(
            'movimentacoes' => $movimentacoes,
            'form' => $form->createView()
        ));

    }

    /**
     * @Route("/export/movimentacoes",name="report_export_relatorio_movimentacoes")
     * @Method("GET")
     */
    public function relatorioMovimentacaoExportToExcelAction(Request $request)
    {
        $dataForm['dataMovimentacaoA'] = $request->query->get('dataCompraA');
        $dataForm['dataMovimentacaoB'] = $request->query->get('dataCompraB');


        $movimentacoes = $this->getDoctrine()
            ->getRepository('MRSInventarioBundle:Movimentacao')
            ->reportMovimentacao($dataForm);

        $response =  $this->render('movimentacaoreport/exportmovimentacoes.html.twig',array(
            'movimentacoes' => $movimentacoes
        ));


        $response->headers->set('Content-Type', 'text/csv');

        $response->headers->set('Content-Disposition', 'attachment; filename=Movimentacoes.csv');

        return $response;

    }

}
