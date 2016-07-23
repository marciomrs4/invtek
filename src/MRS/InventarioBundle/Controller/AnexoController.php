<?php

namespace MRS\InventarioBundle\Controller;

use MRS\InventarioBundle\Entity\Equipamento;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use MRS\InventarioBundle\Entity\Anexo;
use MRS\InventarioBundle\Form\AnexoType;

/**
 * Anexo controller.
 *
 * @Route("/cadastro/anexoequipamento")
 */
class AnexoController extends Controller
{
    /**
     * Lists all Anexo entities.
     *
     * @Route("/{equipamento}", name="cadastro_anexoequipamento_index")
     * @Method("GET")
     */
    public function indexAction(Equipamento $equipamento)
    {
        $em = $this->getDoctrine()->getManager();

        $anexos = $em->getRepository('MRSInventarioBundle:Anexo')
            ->findBy(array('equipamento'=>$equipamento));

        return $this->render('anexo/index.html.twig', array(
            'anexos' => $anexos,
            'equipamento'=> $equipamento
        ));
    }

    /**
     * Creates a new Anexo entity.
     *
     * @Route("/new/{equipamento}", name="cadastro_anexoequipamento_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request, Equipamento $equipamento)
    {
        $anexo = new Anexo();
        $anexo->setEquipamento($equipamento);
        $form = $this->createForm('MRS\InventarioBundle\Form\AnexoType', $anexo);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($anexo);
            $em->flush();

            $this->addFlash('notice','Criado com sucesso!');

            return $this->redirectToRoute('cadastro_anexoequipamento_show', array('id' => $anexo->getId()));
        }

        return $this->render('anexo/new.html.twig', array(
            'anexo' => $anexo,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Anexo entity.
     *
     * @Route("/{id}/show", name="cadastro_anexoequipamento_show")
     * @Method("GET")
     */
    public function showAction(Anexo $anexo)
    {
        $deleteForm = $this->createDeleteForm($anexo);

        return $this->render('anexo/show.html.twig', array(
            'anexo' => $anexo,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Anexo entity.
     *
     * @Route("/{id}/edit", name="cadastro_anexoequipamento_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Anexo $anexo)
    {
        $deleteForm = $this->createDeleteForm($anexo);
        $editForm = $this->createForm('MRS\InventarioBundle\Form\AnexoType', $anexo);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($anexo);
            $em->flush();

            $this->addFlash('notice','Alterado com sucesso!');

            return $this->redirectToRoute('cadastro_anexoequipamento_show', array('id' => $anexo->getId()));
        }

        return $this->render('anexo/edit.html.twig', array(
            'anexo' => $anexo,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Anexo entity.
     *
     * @Route("/{id}", name="cadastro_anexoequipamento_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Anexo $anexo)
    {
        $form = $this->createDeleteForm($anexo);
        $form->handleRequest($request);

        $equipamento = $anexo->getEquipamento()->getId();

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($anexo);
            $em->flush();
        }

        return $this->redirectToRoute('cadastro_anexoequipamento_index', array(
            'equipamento' => $equipamento
        ));
    }

    /**
     * Creates a form to delete a Anexo entity.
     *
     * @param Anexo $anexo The Anexo entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Anexo $anexo)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('cadastro_anexoequipamento_delete', array('id' => $anexo->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }


}
