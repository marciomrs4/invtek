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

        return $this->render(':equipamentoqrcode:new.html.twig', array(
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

}
