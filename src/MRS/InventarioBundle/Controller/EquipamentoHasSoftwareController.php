<?php

namespace MRS\InventarioBundle\Controller;

use MRS\InventarioBundle\Entity\Equipamento;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use MRS\InventarioBundle\Entity\EquipamentoHasSoftware;
use MRS\InventarioBundle\Form\EquipamentoHasSoftwareType;

/**
 * EquipamentoHasSoftware controller.
 *
 * @Route("/cadastro/equipamentoaddsoftware")
 */
class EquipamentoHasSoftwareController extends Controller
{
    /**
     * Lists all EquipamentoHasSoftware entities.
     *
     * @Route("/{equipamento}", name="cadastro_equipamentoaddsoftware_index")
     * @Method("GET")
     */
    public function indexAction(Equipamento $equipamento)
    {
        $em = $this->getDoctrine()->getManager();

        $equipamento = $this->getDoctrine()->getRepository('MRSInventarioBundle:Equipamento')
            ->find($equipamento);

        $equipamentoHasSoftwares = $em->getRepository('MRSInventarioBundle:EquipamentoHasSoftware')
            ->findBy(array('equipamento'=>$equipamento));

        return $this->render('equipamentohassoftware/index.html.twig', array(
            'equipamentoHasSoftwares' => $equipamentoHasSoftwares,
            'equipamento' => $equipamento
        ));
    }

    /**
     * Creates a new EquipamentoHasSoftware entity.
     *
     * @Route("/new/{equipamento}", name="cadastro_equipamentoaddsoftware_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request, Equipamento $equipamento)
    {
        $equipamentoHasSoftware = new EquipamentoHasSoftware();

        $equipamento = $this->getDoctrine()->getRepository('MRSInventarioBundle:Equipamento')
            ->find($equipamento);

        $equipamentoHasSoftware->setEquipamento($equipamento);

        $form = $this->createForm('MRS\InventarioBundle\Form\EquipamentoHasSoftwareType', $equipamentoHasSoftware);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($equipamentoHasSoftware);
            $em->flush();

            $this->addFlash('notice','Adicionado com sucesso!');

            return $this->redirectToRoute('cadastro_equipamentoaddsoftware_index',
                array('equipamento' => $equipamentoHasSoftware->getEquipamento()->getId()));
        }

        return $this->render('equipamentohassoftware/new.html.twig', array(
            'equipamentoHasSoftware' => $equipamentoHasSoftware,
            'equipamento' => $equipamento,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a EquipamentoHasSoftware entity.
     *
     * @Route("/{id}", name="cadastro_equipamentoaddsoftware_show")
     * @Method("GET")
     */
    public function showAction(EquipamentoHasSoftware $equipamentoHasSoftware)
    {
        $deleteForm = $this->createDeleteForm($equipamentoHasSoftware);

        return $this->render('equipamentohassoftware/show.html.twig', array(
            'equipamentoHasSoftware' => $equipamentoHasSoftware,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing EquipamentoHasSoftware entity.
     *
     * @Route("/{id}/edit", name="cadastro_equipamentoaddsoftware_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, EquipamentoHasSoftware $equipamentoHasSoftware)
    {
        $deleteForm = $this->createDeleteForm($equipamentoHasSoftware);
        $editForm = $this->createForm('MRS\InventarioBundle\Form\EquipamentoHasSoftwareType', $equipamentoHasSoftware);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($equipamentoHasSoftware);
            $em->flush();

            $this->addFlash('notice','Alterado com sucesso!');

            return $this->redirectToRoute('cadastro_equipamentoaddsoftware_index',
                array('equipamento' => $equipamentoHasSoftware->getEquipamento()->getId()));
        }

        return $this->render('equipamentohassoftware/edit.html.twig', array(
            'equipamentoHasSoftware' => $equipamentoHasSoftware,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a EquipamentoHasSoftware entity.
     *
     * @Route("/{id}", name="cadastro_equipamentoaddsoftware_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, EquipamentoHasSoftware $equipamentoHasSoftware)
    {
        $id = $equipamentoHasSoftware->getEquipamento()->getId();

        $form = $this->createDeleteForm($equipamentoHasSoftware);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($equipamentoHasSoftware);
            $em->flush();

            $this->addFlash('notice','Removido com sucesso!');

        }

        return $this->redirectToRoute('cadastro_equipamentoaddsoftware_index',
            array('equipamento' => $id));
    }

    /**
     * Creates a form to delete a EquipamentoHasSoftware entity.
     *
     * @param EquipamentoHasSoftware $equipamentoHasSoftware The EquipamentoHasSoftware entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(EquipamentoHasSoftware $equipamentoHasSoftware)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('cadastro_equipamentoaddsoftware_delete', array('id' => $equipamentoHasSoftware->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
