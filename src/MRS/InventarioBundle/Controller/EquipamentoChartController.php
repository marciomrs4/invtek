<?php

namespace MRS\InventarioBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use MRS\InventarioBundle\Form\Report\EquipamentoChartType;

/**
 * Equipamento controller.
 *
 * @Route("/report/charts")
 */
class EquipamentoChartController extends Controller
{

    /**
     * @Route("/equipamentobycentromovimentacao", name="report_chart_equipamento_by_centro_movimentacao")
     * @Method("POST|GET")
     */
    public function equipamentoByCentroMovimentacaoAction(Request $request)
    {
        $formEquipamento = $this->createForm(EquipamentoChartType::class);

        $dadosRequest = $request->request->all();

        $equipamentos = [];
        $quantidade = 0;

        if ($request->isMethod('POST')) {

            $formEquipamento->handleRequest($request);

            $equipamentos = $this->getDoctrine()
                ->getRepository('MRSInventarioBundle:Equipamento')
                ->chartEquipamentoByCentroMotivacao($dadosRequest['chart_equipamentos']);

            foreach($equipamentos as $equipamento) {
                $quantidade += $equipamento['quantidade'];
            }

        }

        return $this->render('MRSInventarioBundle:EquipamentoChart:index.html.twig',[
            'form' => $formEquipamento->createView(),
            'quantidadeEquipamentos' => $quantidade,
            'equipamentos' => json_encode($equipamentos)
        ]);

    }


}
