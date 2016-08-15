<?php

namespace MRS\InventarioBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use MRS\InventarioBundle\Entity\Equipamento;

/**
 * Equipamento controller.
 *
 * @Route("/qrcode/equipamento")
 */
class EquipamentoQrCodeController extends Controller
{
    /**
     * Lists all Equipamento entities.
     *
     * @Route("/generate/{equipamento}", name="equipamento_qrcode_generate")
     * @Method("GET")
     */
    public function indexAction(Equipamento $equipamento)
    {

        return $this->render(':equipamentoqrcode:qrcodeshow.html.twig', array(
            'equipamento' => $equipamento,
        ));
    }

    /**
     * Finds and displays a Equipamento entity.
     *
     * @Route("/{equipamento}/show", name="equipamento_qrcode_show")
     * @Method("GET")
     */
    public function showAction(Equipamento $equipamento)
    {

        return $this->render(':equipamentoqrcode:show.html.twig', array(
            'equipamento' => $equipamento,
        ));
    }

    /**
     * Lists all Equipamento entities.
     *
     * @Route("/moreinformation/{equipamento}", name="qrcode_equipamento_moreinformation_qrcode")
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

        $acompanhamentos = $this->getDoctrine()
            ->getRepository('MRSInventarioBundle:Acompanhamento')
            ->findBy(array('equipamento'=>$equipamento),
                     array('datahora'=>'DESC'),
                     3);

        return $this->render('equipamentoqrcode/moreinformationqrcode.html.twig', array(
            'equipamento' => $equipamento,
            'tags'=>$tags,
            'softwares'=>$softwares,
            'componentes'=>$componentes,
            'manyequipamentos' => $manyequipamentos,
            'equipamentosFilho' => $equipamentosFilho,
            'acompanhamentos' => $acompanhamentos
        ));

    }


}
