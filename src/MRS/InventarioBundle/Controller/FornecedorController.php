<?php

namespace MRS\InventarioBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use MRS\InventarioBundle\Entity\Fornecedor;
use MRS\InventarioBundle\Form\FornecedorType;

/**
 * Fornecedor controller.
 *
 * @Route("/cadastro/fornecedor")
 */
class FornecedorController extends Controller
{
    /**
     * Lists all Fornecedor entities.
     *
     * @Route("/", name="cadastro_fornecedor_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $fornecedors = $em->getRepository('MRSInventarioBundle:Fornecedor')->findAll();

        return $this->render('fornecedor/index.html.twig', array(
            'fornecedors' => $fornecedors,
        ));
    }

    /**
     * Creates a new Fornecedor entity.
     *
     * @Route("/new", name="cadastro_fornecedor_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $fornecedor = new Fornecedor();
        $form = $this->createForm('MRS\InventarioBundle\Form\FornecedorType', $fornecedor);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($fornecedor);
            $em->flush();

            $this->addFlash('notice','Criado com sucesso!');

            return $this->redirectToRoute('cadastro_fornecedor_show', array('id' => $fornecedor->getId()));
        }

        return $this->render('fornecedor/new.html.twig', array(
            'fornecedor' => $fornecedor,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Fornecedor entity.
     *
     * @Route("/{id}", name="cadastro_fornecedor_show")
     * @Method("GET")
     */
    public function showAction(Fornecedor $fornecedor)
    {
        $deleteForm = $this->createDeleteForm($fornecedor);

        return $this->render('fornecedor/show.html.twig', array(
            'fornecedor' => $fornecedor,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Fornecedor entity.
     *
     * @Route("/{id}/edit", name="cadastro_fornecedor_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Fornecedor $fornecedor)
    {
        $deleteForm = $this->createDeleteForm($fornecedor);
        $editForm = $this->createForm('MRS\InventarioBundle\Form\FornecedorType', $fornecedor);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($fornecedor);
            $em->flush();

            $this->addFlash('notice','Alterado com sucesso!');

            return $this->redirectToRoute('cadastro_fornecedor_show', array('id' => $fornecedor->getId()));
        }

        return $this->render('fornecedor/edit.html.twig', array(
            'fornecedor' => $fornecedor,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Fornecedor entity.
     *
     * @Route("/{id}", name="cadastro_fornecedor_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Fornecedor $fornecedor)
    {
        $form = $this->createDeleteForm($fornecedor);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($fornecedor);
            $em->flush();
        }

        return $this->redirectToRoute('cadastro_fornecedor_index');
    }

    /**
     * Creates a form to delete a Fornecedor entity.
     *
     * @param Fornecedor $fornecedor The Fornecedor entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Fornecedor $fornecedor)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('cadastro_fornecedor_delete', array('id' => $fornecedor->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
