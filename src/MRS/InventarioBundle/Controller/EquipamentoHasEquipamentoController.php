<?php

namespace MRS\InventarioBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use MRS\InventarioBundle\Entity\EquipamentoHasEquipamento;
use MRS\InventarioBundle\Entity\Equipamento;
use MRS\InventarioBundle\Form\EquipamentoHasEquipamentoType;

/**
 * EquipamentoHasEquipamento controller.
 *
 * @Route("/cadastro/equipamentoaddequipamento")
 */
class EquipamentoHasEquipamentoController extends Controller
{
    /**
     * Lists all EquipamentoHasEquipamento entities.
     *
     * @Route("/{equipamento}", name="cadastro_equipamentoaddequipamento_index")
     * @Method("GET")
     */
    public function indexAction(Equipamento $equipamento)
    {
        $em = $this->getDoctrine()->getManager();

        $equipamentoHasEquipamentos = $em->getRepository('MRSInventarioBundle:EquipamentoHasEquipamento')
            ->findBy(array('equipamentoPai' => $equipamento));

        return $this->render('equipamentohasequipamento/index.html.twig', array(
            'equipamentoHasEquipamentos' => $equipamentoHasEquipamentos,
            'equipamento' => $equipamento
        ));
    }

    /**
     * Creates a new EquipamentoHasEquipamento entity.
     *
     * @Route("/new/{equipamento}", name="cadastro_equipamentoaddequipamento_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request, Equipamento $equipamento)
    {
        $equipamentoHasEquipamento = new EquipamentoHasEquipamento();

        $equipamentoHasEquipamento->setEquipamentoPai($equipamento);

        $form = $this->createForm('MRS\InventarioBundle\Form\EquipamentoHasEquipamentoType', $equipamentoHasEquipamento);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($equipamentoHasEquipamento);
            $em->flush();

            $this->addFlash('notice','Criado com sucesso!');

            return $this->redirectToRoute('cadastro_equipamentoaddequipamento_show', array('id' => $equipamentoHasEquipamento->getId()));
        }

        return $this->render('equipamentohasequipamento/new.html.twig', array(
            'equipamentoHasEquipamento' => $equipamentoHasEquipamento,
            'equipamento' => $equipamento,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a EquipamentoHasEquipamento entity.
     *
     * @Route("/{id}", name="cadastro_equipamentoaddequipamento_show")
     * @Method("GET")
     */
    public function showAction(EquipamentoHasEquipamento $equipamentoHasEquipamento)
    {
        $deleteForm = $this->createDeleteForm($equipamentoHasEquipamento);

        return $this->render('equipamentohasequipamento/show.html.twig', array(
            'equipamentoHasEquipamento' => $equipamentoHasEquipamento,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing EquipamentoHasEquipamento entity.
     *
     * @Route("/{id}/edit", name="cadastro_equipamentoaddequipamento_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, EquipamentoHasEquipamento $equipamentoHasEquipamento)
    {
        $deleteForm = $this->createDeleteForm($equipamentoHasEquipamento);
        $editForm = $this->createForm('MRS\InventarioBundle\Form\EquipamentoHasEquipamentoType', $equipamentoHasEquipamento);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($equipamentoHasEquipamento);
            $em->flush();

            $this->addFlash('notice','Alterado com sucesso!');

            return $this->redirectToRoute('cadastro_equipamentoaddequipamento_show', array('id' => $equipamentoHasEquipamento->getId()));
        }

        return $this->render('equipamentohasequipamento/edit.html.twig', array(
            'equipamentoHasEquipamento' => $equipamentoHasEquipamento,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a EquipamentoHasEquipamento entity.
     *
     * @Route("/{id}", name="cadastro_equipamentoaddequipamento_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, EquipamentoHasEquipamento $equipamentoHasEquipamento)
    {
        $form = $this->createDeleteForm($equipamentoHasEquipamento);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($equipamentoHasEquipamento);
            $em->flush();
        }

        return $this->redirectToRoute('cadastro_equipamentoaddequipamento_index');
    }

    /**
     * Creates a form to delete a EquipamentoHasEquipamento entity.
     *
     * @param EquipamentoHasEquipamento $equipamentoHasEquipamento The EquipamentoHasEquipamento entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(EquipamentoHasEquipamento $equipamentoHasEquipamento)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('cadastro_equipamentoaddequipamento_delete', array('id' => $equipamentoHasEquipamento->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
