<?php

namespace MRS\InventarioBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use MRS\InventarioBundle\Entity\Motivomovimentacao;
use MRS\InventarioBundle\Form\MotivomovimentacaoType;

/**
 * Motivomovimentacao controller.
 *
 * @Route("/cadastro/motivomovimentacao")
 */
class MotivomovimentacaoController extends Controller
{
    /**
     * Lists all Motivomovimentacao entities.
     *
     * @Route("/", name="cadastro_motivomovimentacao_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $motivomovimentacaos = $em->getRepository('MRSInventarioBundle:Motivomovimentacao')->findAll();

        return $this->render('motivomovimentacao/index.html.twig', array(
            'motivomovimentacaos' => $motivomovimentacaos,
        ));
    }

    /**
     * Creates a new Motivomovimentacao entity.
     *
     * @Route("/new", name="cadastro_motivomovimentacao_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $motivomovimentacao = new Motivomovimentacao();
        $form = $this->createForm('MRS\InventarioBundle\Form\MotivomovimentacaoType', $motivomovimentacao);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($motivomovimentacao);
            $em->flush();

            $this->addFlash('notice','Criado com sucesso!');

            return $this->redirectToRoute('cadastro_motivomovimentacao_show', array('id' => $motivomovimentacao->getId()));
        }

        return $this->render('motivomovimentacao/new.html.twig', array(
            'motivomovimentacao' => $motivomovimentacao,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Motivomovimentacao entity.
     *
     * @Route("/{id}", name="cadastro_motivomovimentacao_show")
     * @Method("GET")
     */
    public function showAction(Motivomovimentacao $motivomovimentacao)
    {
        $deleteForm = $this->createDeleteForm($motivomovimentacao);

        return $this->render('motivomovimentacao/show.html.twig', array(
            'motivomovimentacao' => $motivomovimentacao,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Motivomovimentacao entity.
     *
     * @Route("/{id}/edit", name="cadastro_motivomovimentacao_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Motivomovimentacao $motivomovimentacao)
    {
        $deleteForm = $this->createDeleteForm($motivomovimentacao);
        $editForm = $this->createForm('MRS\InventarioBundle\Form\MotivomovimentacaoType', $motivomovimentacao);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($motivomovimentacao);
            $em->flush();

            $this->addFlash('notice','Alterado com sucesso!');

            return $this->redirectToRoute('cadastro_motivomovimentacao_show', array('id' => $motivomovimentacao->getId()));
        }

        return $this->render('motivomovimentacao/edit.html.twig', array(
            'motivomovimentacao' => $motivomovimentacao,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Motivomovimentacao entity.
     *
     * @Route("/{id}", name="cadastro_motivomovimentacao_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Motivomovimentacao $motivomovimentacao)
    {
        $form = $this->createDeleteForm($motivomovimentacao);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($motivomovimentacao);
            $em->flush();
        }

        return $this->redirectToRoute('cadastro_motivomovimentacao_index');
    }

    /**
     * Creates a form to delete a Motivomovimentacao entity.
     *
     * @param Motivomovimentacao $motivomovimentacao The Motivomovimentacao entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Motivomovimentacao $motivomovimentacao)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('cadastro_motivomovimentacao_delete', array('id' => $motivomovimentacao->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
