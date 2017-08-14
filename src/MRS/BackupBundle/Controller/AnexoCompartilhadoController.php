<?php

namespace MRS\BackupBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use MRS\BackupBundle\Entity\AnexoCompartilhado;
use MRS\BackupBundle\Form\AnexoCompartilhadoType;

/**
 * AnexoCompartilhado controller.
 *
 * @Route("/cadastro/anexocompartilhado")
 */
class AnexoCompartilhadoController extends Controller
{
    /**
     * Lists all AnexoCompartilhado entities.
     *
     * @Route("/", name="cadastro_anexocompartilhado_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $anexoCompartilhados = $em->getRepository('MRSBackupBundle:AnexoCompartilhado')
            ->findBy(array(),array('dataCriacao' => 'DESC'));

        return $this->render('anexocompartilhado/index.html.twig', array(
            'anexoCompartilhados' => $anexoCompartilhados,
        ));
    }

    /**
     * Creates a new AnexoCompartilhado entity.
     *
     * @Route("/new", name="cadastro_anexocompartilhado_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $anexoCompartilhado = new AnexoCompartilhado();
        $form = $this->createForm('MRS\BackupBundle\Form\AnexoCompartilhadoType', $anexoCompartilhado);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($anexoCompartilhado);
            $em->flush();

            $this->addFlash('notice','Criado com sucesso!');

            return $this->redirectToRoute('cadastro_anexocompartilhado_show', array('id' => $anexoCompartilhado->getId()));
        }

        return $this->render('anexocompartilhado/new.html.twig', array(
            'anexoCompartilhado' => $anexoCompartilhado,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a AnexoCompartilhado entity.
     *
     * @Route("/{id}", name="cadastro_anexocompartilhado_show")
     * @Method("GET")
     */
    public function showAction(AnexoCompartilhado $anexoCompartilhado)
    {
        $deleteForm = $this->createDeleteForm($anexoCompartilhado);

        return $this->render('anexocompartilhado/show.html.twig', array(
            'anexoCompartilhado' => $anexoCompartilhado,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing AnexoCompartilhado entity.
     *
     * @Route("/{id}/edit", name="cadastro_anexocompartilhado_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, AnexoCompartilhado $anexoCompartilhado)
    {
        $deleteForm = $this->createDeleteForm($anexoCompartilhado);
        $editForm = $this->createForm('MRS\BackupBundle\Form\AnexoCompartilhadoType', $anexoCompartilhado);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($anexoCompartilhado);
            $em->flush();

            $this->addFlash('notice','Alterado com sucesso!');

            return $this->redirectToRoute('cadastro_anexocompartilhado_show', array('id' => $anexoCompartilhado->getId()));
        }

        return $this->render('anexocompartilhado/edit.html.twig', array(
            'anexoCompartilhado' => $anexoCompartilhado,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a AnexoCompartilhado entity.
     *
     * @Route("/{id}", name="cadastro_anexocompartilhado_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, AnexoCompartilhado $anexoCompartilhado)
    {
        $form = $this->createDeleteForm($anexoCompartilhado);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($anexoCompartilhado);
            $em->flush();
        }

        return $this->redirectToRoute('cadastro_anexocompartilhado_index');
    }

    /**
     * Creates a form to delete a AnexoCompartilhado entity.
     *
     * @param AnexoCompartilhado $anexoCompartilhado The AnexoCompartilhado entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(AnexoCompartilhado $anexoCompartilhado)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('cadastro_anexocompartilhado_delete', array('id' => $anexoCompartilhado->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
