<?php

namespace MRS\InventarioBundle\Controller;

use MRS\InventarioBundle\Entity\Equipamento;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use MRS\InventarioBundle\Entity\Acompanhamento;
use MRS\InventarioBundle\Form\AcompanhamentoType;

/**
 * Acompanhamento controller.
 *
 * @Route("/cadastro/acompanhamento")
 */
class AcompanhamentoController extends Controller
{
    /**
     * Lists all Acompanhamento entities.
     *
     * @Route("/{equipamento}", name="cadastro_acompanhamento_index")
     * @Method("GET")
     */
    public function indexAction(Equipamento $equipamento)
    {
        $em = $this->getDoctrine()->getManager();

        $acompanhamentos = $em->getRepository('MRSInventarioBundle:Acompanhamento')
            ->findBy(array('equipamento' => $equipamento));

        return $this->render('acompanhamento/index.html.twig', array(
            'acompanhamentos' => $acompanhamentos,
            'equipamento' => $equipamento
        ));
    }

    /**
     * Creates a new Acompanhamento entity.
     *
     * @Route("/new/{equipamento}", name="cadastro_acompanhamento_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request, Equipamento $equipamento)
    {
        $acompanhamento = new Acompanhamento();
        $acompanhamento->setEquipamento($equipamento);
        $form = $this->createForm('MRS\InventarioBundle\Form\AcompanhamentoType', $acompanhamento);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($acompanhamento);
            $em->flush();

            $this->addFlash('notice','Criado com sucesso!');

            return $this->redirectToRoute('cadastro_acompanhamento_show', array('id' => $acompanhamento->getId()));
        }

        return $this->render('acompanhamento/new.html.twig', array(
            'acompanhamento' => $acompanhamento,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Acompanhamento entity.
     *
     * @Route("/show/{id}", name="cadastro_acompanhamento_show")
     * @Method("GET")
     */
    public function showAction(Acompanhamento $acompanhamento)
    {
        $deleteForm = $this->createDeleteForm($acompanhamento);

        return $this->render('acompanhamento/show.html.twig', array(
            'acompanhamento' => $acompanhamento,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Acompanhamento entity.
     *
     * @Route("/{id}/edit", name="cadastro_acompanhamento_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Acompanhamento $acompanhamento)
    {
        $deleteForm = $this->createDeleteForm($acompanhamento);
        $editForm = $this->createForm('MRS\InventarioBundle\Form\AcompanhamentoType', $acompanhamento);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($acompanhamento);
            $em->flush();

            $this->addFlash('notice','Alterado com sucesso!');

            return $this->redirectToRoute('cadastro_acompanhamento_show', array('id' => $acompanhamento->getId()));
        }

        return $this->render('acompanhamento/edit.html.twig', array(
            'acompanhamento' => $acompanhamento,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Acompanhamento entity.
     *
     * @Route("/{id}", name="cadastro_acompanhamento_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Acompanhamento $acompanhamento)
    {
        $form = $this->createDeleteForm($acompanhamento);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($acompanhamento);
            $em->flush();
        }

        return $this->redirectToRoute('cadastro_acompanhamento_index');
    }

    /**
     * Creates a form to delete a Acompanhamento entity.
     *
     * @param Acompanhamento $acompanhamento The Acompanhamento entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Acompanhamento $acompanhamento)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('cadastro_acompanhamento_delete', array('id' => $acompanhamento->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
