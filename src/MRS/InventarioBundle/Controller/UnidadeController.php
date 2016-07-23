<?php

namespace MRS\InventarioBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use MRS\InventarioBundle\Entity\Unidade;
use MRS\InventarioBundle\Form\UnidadeType;

/**
 * Unidade controller.
 *
 * @Route("/cadastro/unidade")
 */
class UnidadeController extends Controller
{
    /**
     * Lists all Unidade entities.
     *
     * @Route("/", name="cadastro_unidade_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $unidades = $em->getRepository('MRSInventarioBundle:Unidade')->findAll();

        return $this->render('unidade/index.html.twig', array(
            'unidades' => $unidades,
        ));
    }

    /**
     * Creates a new Unidade entity.
     *
     * @Route("/new", name="cadastro_unidade_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $unidade = new Unidade();
        $form = $this->createForm('MRS\InventarioBundle\Form\UnidadeType', $unidade);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($unidade);
            $em->flush();

            $this->addFlash('notice','Criado com sucesso!');

            return $this->redirectToRoute('cadastro_unidade_show', array('id' => $unidade->getId()));
        }

        return $this->render('unidade/new.html.twig', array(
            'unidade' => $unidade,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Unidade entity.
     *
     * @Route("/{id}", name="cadastro_unidade_show")
     * @Method("GET")
     */
    public function showAction(Unidade $unidade)
    {
        $deleteForm = $this->createDeleteForm($unidade);

        return $this->render('unidade/show.html.twig', array(
            'unidade' => $unidade,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Unidade entity.
     *
     * @Route("/{id}/edit", name="cadastro_unidade_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Unidade $unidade)
    {
        $deleteForm = $this->createDeleteForm($unidade);
        $editForm = $this->createForm('MRS\InventarioBundle\Form\UnidadeType', $unidade);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($unidade);
            $em->flush();

            $this->addFlash('notice','Alterado com sucesso!');

            return $this->redirectToRoute('cadastro_unidade_show', array('id' => $unidade->getId()));
        }

        return $this->render('unidade/edit.html.twig', array(
            'unidade' => $unidade,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Unidade entity.
     *
     * @Route("/{id}", name="cadastro_unidade_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Unidade $unidade)
    {
        $form = $this->createDeleteForm($unidade);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($unidade);
            $em->flush();
        }

        return $this->redirectToRoute('cadastro_unidade_index');
    }

    /**
     * Creates a form to delete a Unidade entity.
     *
     * @param Unidade $unidade The Unidade entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Unidade $unidade)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('cadastro_unidade_delete', array('id' => $unidade->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
