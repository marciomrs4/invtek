<?php

namespace MRS\InventarioBundle\Controller;

use MRS\InventarioBundle\Entity\Equipamento;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use MRS\InventarioBundle\Entity\EquipamentoTag;
use MRS\InventarioBundle\Form\EquipamentoTagType;

/**
 * EquipamentoTag controller.
 *
 * @Route("/cadastro/equipamentotag")
 */
class EquipamentoTagController extends Controller
{
    /**
     * Lists all EquipamentoTag entities.
     *
     * @Route("/{equipamento}", name="cadastro_equipamentotag_index")
     * @Method("GET")
     */
    public function indexAction(Equipamento $equipamento)
    {
        $em = $this->getDoctrine()->getManager();

        $equipamentoTags = $em->getRepository('MRSInventarioBundle:EquipamentoTag')
            ->findBy(array('equipamento'=>$equipamento));

        return $this->render('equipamentotag/index.html.twig', array(
            'equipamentoTags' => $equipamentoTags,
            'equipamento'=>$equipamento
        ));
    }

    /**
     * Creates a new EquipamentoTag entity.
     *
     * @Route("/new/{equipamento}", name="cadastro_equipamentotag_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request, Equipamento $equipamento)
    {
        $equipamentoTag = new EquipamentoTag();

/*
        $equipamento = $this->getDoctrine()->getRepository('MRSInventarioBundle:Equipamento')
            ->find($equipamento);
*/

        $equipamentoTag->setEquipamento($equipamento);

        $form = $this->createForm('MRS\InventarioBundle\Form\EquipamentoTagType', $equipamentoTag);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($equipamentoTag);
            $em->flush();

            $this->addFlash('notice','Criado com sucesso!');

            //return $this->redirectToRoute('cadastro_equipamentotag_show', array('id' => $equipamentoTag->getId()));
            return $this->redirectToRoute('cadastro_equipamentotag_index',
                array('equipamento' => $equipamento->getId()));
        }

        return $this->render('equipamentotag/new.html.twig', array(
            'equipamentoTag' => $equipamentoTag,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a EquipamentoTag entity.
     *
     * @Route("/{id}", name="cadastro_equipamentotag_show")
     * @Method("GET")
     */
    public function showAction(EquipamentoTag $equipamentoTag)
    {
        $deleteForm = $this->createDeleteForm($equipamentoTag);

        return $this->render('equipamentotag/show.html.twig', array(
            'equipamentoTag' => $equipamentoTag,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing EquipamentoTag entity.
     *
     * @Route("/{id}/edit", name="cadastro_equipamentotag_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, EquipamentoTag $equipamentoTag)
    {
        $deleteForm = $this->createDeleteForm($equipamentoTag);
        $editForm = $this->createForm('MRS\InventarioBundle\Form\EquipamentoTagType', $equipamentoTag);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($equipamentoTag);
            $em->flush();

            $this->addFlash('notice','Alterado com sucesso!');

            return $this->redirectToRoute('cadastro_equipamentotag_index',
                array('equipamento' => $equipamentoTag->getEquipamento()->getId()));
        }

        return $this->render('equipamentotag/edit.html.twig', array(
            'equipamentoTag' => $equipamentoTag,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a EquipamentoTag entity.
     *
     * @Route("/{id}", name="cadastro_equipamentotag_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, EquipamentoTag $equipamentoTag)
    {
        $form = $this->createDeleteForm($equipamentoTag);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($equipamentoTag);
            $em->flush();

            $this->addFlash('notice','Removido com sucesso!');
        }

        return $this->redirectToRoute('cadastro_equipamentotag_index',
            array('equipamento'=>$equipamentoTag->getEquipamento()->getId()));
    }

    /**
     * Creates a form to delete a EquipamentoTag entity.
     *
     * @param EquipamentoTag $equipamentoTag The EquipamentoTag entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(EquipamentoTag $equipamentoTag)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('cadastro_equipamentotag_delete', array('id' => $equipamentoTag->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
