<?php

namespace MRS\InventarioBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use MRS\InventarioBundle\Entity\Tipomovimentacao;
use MRS\InventarioBundle\Form\TipomovimentacaoType;

/**
 * Tipomovimentacao controller.
 *
 * @Route("/cadastro/tipomovimentacao")
 */
class TipomovimentacaoController extends Controller
{
    /**
     * Lists all Tipomovimentacao entities.
     *
     * @Route("/", name="cadastro_tipomovimentacao_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $tipomovimentacaos = $em->getRepository('MRSInventarioBundle:Tipomovimentacao')->findAll();

        return $this->render('tipomovimentacao/index.html.twig', array(
            'tipomovimentacaos' => $tipomovimentacaos,
        ));
    }

    /**
     * Creates a new Tipomovimentacao entity.
     *
     * @Route("/new", name="cadastro_tipomovimentacao_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $tipomovimentacao = new Tipomovimentacao();
        $form = $this->createForm('MRS\InventarioBundle\Form\TipomovimentacaoType', $tipomovimentacao);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($tipomovimentacao);
            $em->flush();

            $this->addFlash('notice','Criado com sucesso!');

            return $this->redirectToRoute('cadastro_tipomovimentacao_show', array('id' => $tipomovimentacao->getId()));
        }

        return $this->render('tipomovimentacao/new.html.twig', array(
            'tipomovimentacao' => $tipomovimentacao,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Tipomovimentacao entity.
     *
     * @Route("/{id}", name="cadastro_tipomovimentacao_show")
     * @Method("GET")
     */
    public function showAction(Tipomovimentacao $tipomovimentacao)
    {
        $deleteForm = $this->createDeleteForm($tipomovimentacao);

        return $this->render('tipomovimentacao/show.html.twig', array(
            'tipomovimentacao' => $tipomovimentacao,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Tipomovimentacao entity.
     *
     * @Route("/{id}/edit", name="cadastro_tipomovimentacao_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Tipomovimentacao $tipomovimentacao)
    {
        $deleteForm = $this->createDeleteForm($tipomovimentacao);
        $editForm = $this->createForm('MRS\InventarioBundle\Form\TipomovimentacaoType', $tipomovimentacao);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($tipomovimentacao);
            $em->flush();

            $this->addFlash('notice','Alterado com sucesso!');

            return $this->redirectToRoute('cadastro_tipomovimentacao_show', array('id' => $tipomovimentacao->getId()));
        }

        return $this->render('tipomovimentacao/edit.html.twig', array(
            'tipomovimentacao' => $tipomovimentacao,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Tipomovimentacao entity.
     *
     * @Route("/{id}", name="cadastro_tipomovimentacao_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Tipomovimentacao $tipomovimentacao)
    {
        $form = $this->createDeleteForm($tipomovimentacao);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($tipomovimentacao);
            $em->flush();
        }

        return $this->redirectToRoute('cadastro_tipomovimentacao_index');
    }

    /**
     * Creates a form to delete a Tipomovimentacao entity.
     *
     * @param Tipomovimentacao $tipomovimentacao The Tipomovimentacao entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Tipomovimentacao $tipomovimentacao)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('cadastro_tipomovimentacao_delete', array('id' => $tipomovimentacao->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
