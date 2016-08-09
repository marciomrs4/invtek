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
    public function relatorioEquipamentoAction(Request $request)
    {

        $form = $this->createForm(MovimentacoesReportType::class);

        $date = new \DateTime('now');

        $form->get('dataCompraA')->setData($date->modify('-240 day'));

        $form->get('dataCompraB')->setData($date->modify('+240 day'));


        if($request->isMethod('POST')) {
            $form->handleRequest($request);
        }

        $movimentacaoForm = $request->request->get('report_equipamentos');

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
    public function relatorioEquipamentoExportToExcelAction(Request $request)
    {

        $dataForm['tipoequipamento'] = $request->query->get('tipoEquipamento');
        $dataForm['fornecedor'] = $request->query->get('fornecedor');
        $dataForm['marca'] = $request->query->get('marca');
        $dataForm['patrimonio'] = $request->query->get('patrimonio');
        $dataForm['dataCompraA'] = $request->query->get('dataCompraA');
        $dataForm['dataCompraB'] = $request->query->get('dataCompraB');
        $dataForm['numeroserie'] = $request->query->get('numeroserie');
        $dataForm['status'] = $request->query->get('status');
        $dataForm['centroMovimentacao'] = $request->query->get('centroMovimentacao');

        $equipamentos = $this->getDoctrine()
            ->getRepository('MRSInventarioBundle:Equipamento')
            ->reportEquipamentos($dataForm);

        $response =  $this->render(':equipamentoreport:exportequipamentos.html.twig',array(
            'equipamentos' => $equipamentos
        ));


        $response->headers->set('Content-Type', 'text/csv');

        $response->headers->set('Content-Disposition', 'attachment; filename=Equipamentos.csv');

        return $response;

    }

}
