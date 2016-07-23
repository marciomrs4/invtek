<?php

namespace MRS\InventarioBundle\Controller;

use MRS\InventarioBundle\Entity\Equipamento;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use MRS\InventarioBundle\Entity\EquipamentoHasComponente;
use MRS\InventarioBundle\Form\EquipamentoHasComponenteType;

/**
 * EquipamentoHasComponente controller.
 *
 * @Route("/cadastro/equipamentocomponente")
 */
class EquipamentoHasComponenteController extends Controller
{
    /**
     * Lists all EquipamentoHasComponente entities.
     *
     * @Route("/{equipamento}", name="cadastro_equipamentocomponente_index")
     * @Method("GET")
     */
    public function indexAction(Equipamento $equipamento)
    {
        $em = $this->getDoctrine()->getManager();

        $equipamentoHasComponentes = $em->getRepository('MRSInventarioBundle:EquipamentoHasComponente')
            ->findBy(array('equipamento'=>$equipamento),
                array('componente'=>'ASC'));

        return $this->render('equipamentohascomponente/index.html.twig', array(
            'equipamentoHasComponentes' => $equipamentoHasComponentes,
            'equipamento' => $equipamento
        ));
    }

    /**
     * Creates a new EquipamentoHasComponente entity.
     *
     * @Route("/new/{equipamento}", name="cadastro_equipamentocomponente_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request, Equipamento $equipamento)
    {
        $equipamentoHasComponente = new EquipamentoHasComponente();

        $equipamento = $this->getDoctrine()->getRepository('MRSInventarioBundle:Equipamento')
            ->find($equipamento);

        $equipamentoHasComponente->setEquipamento($equipamento);

        $form = $this->createForm('MRS\InventarioBundle\Form\EquipamentoHasComponenteType', $equipamentoHasComponente);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($equipamentoHasComponente);
            $em->flush();

            $this->addFlash('notice','Adicionado com sucesso!');

            return $this->redirectToRoute('cadastro_equipamentocomponente_index',
                array('equipamento' => $equipamentoHasComponente->getEquipamento()->getId()));
        }

        return $this->render('equipamentohascomponente/new.html.twig', array(
            'equipamentoHasComponente' => $equipamentoHasComponente,
            'equipamento' => $equipamento,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a EquipamentoHasComponente entity.
     *
     * @Route("/{id}", name="cadastro_equipamentocomponente_show")
     * @Method("GET")
     */
    public function showAction(EquipamentoHasComponente $equipamentoHasComponente)
    {
        $deleteForm = $this->createDeleteForm($equipamentoHasComponente);

        return $this->render('equipamentohascomponente/show.html.twig', array(
            'equipamentoHasComponente' => $equipamentoHasComponente,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing EquipamentoHasComponente entity.
     *
     * @Route("/{id}/edit", name="cadastro_equipamentocomponente_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, EquipamentoHasComponente $equipamentoHasComponente)
    {
        $deleteForm = $this->createDeleteForm($equipamentoHasComponente);
        $editForm = $this->createForm('MRS\InventarioBundle\Form\EquipamentoHasComponenteType', $equipamentoHasComponente);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($equipamentoHasComponente);
            $em->flush();

            $this->addFlash('notice','Alterado com sucesso!');

            return $this->redirectToRoute('cadastro_equipamentocomponente_index',
                array('equipamento' => $equipamentoHasComponente->getEquipamento()->getId()));
        }

        return $this->render('equipamentohascomponente/edit.html.twig', array(
            'equipamentoHasComponente' => $equipamentoHasComponente,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a EquipamentoHasComponente entity.
     *
     * @Route("/{id}", name="cadastro_equipamentocomponente_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, EquipamentoHasComponente $equipamentoHasComponente)
    {
        $id = $equipamentoHasComponente->getEquipamento()->getId();
        $form = $this->createDeleteForm($equipamentoHasComponente);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($equipamentoHasComponente);
            $em->flush();

            $this->addFlash('notice','Removido com sucesso!');
        }

        return $this->redirectToRoute('cadastro_equipamentocomponente_index',
                    array( 'equipamento' => $id));
    }

    /**
     * Creates a form to delete a EquipamentoHasComponente entity.
     *
     * @param EquipamentoHasComponente $equipamentoHasComponente The EquipamentoHasComponente entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(EquipamentoHasComponente $equipamentoHasComponente)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('cadastro_equipamentocomponente_delete', array('id' => $equipamentoHasComponente->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
