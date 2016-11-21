<?php

namespace MRS\InventarioBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use MRS\InventarioBundle\Entity\FornecedorSoftware;
use MRS\InventarioBundle\Form\FornecedorSoftwareType;

/**
 * FornecedorSoftware controller.
 *
 * @Route("/cadastro/fornecedorsoftware")
 */
class FornecedorSoftwareController extends Controller
{
    /**
     * Lists all FornecedorSoftware entities.
     *
     * @Route("/", name="cadastro_fornecedorsoftware_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $fornecedorSoftwares = $em->getRepository('MRSInventarioBundle:FornecedorSoftware')->findAll();

        return $this->render('fornecedorsoftware/index.html.twig', array(
            'fornecedorSoftwares' => $fornecedorSoftwares,
        ));
    }

    /**
     * Creates a new FornecedorSoftware entity.
     *
     * @Route("/new", name="cadastro_fornecedorsoftware_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $fornecedorSoftware = new FornecedorSoftware();
        $form = $this->createForm('MRS\InventarioBundle\Form\FornecedorSoftwareType', $fornecedorSoftware);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($fornecedorSoftware);
            $em->flush();

            $this->addFlash('notice','Criado com sucesso!');

            return $this->redirectToRoute('cadastro_fornecedorsoftware_show', array('id' => $fornecedorSoftware->getId()));
        }

        return $this->render('fornecedorsoftware/new.html.twig', array(
            'fornecedorSoftware' => $fornecedorSoftware,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a FornecedorSoftware entity.
     *
     * @Route("/{id}", name="cadastro_fornecedorsoftware_show")
     * @Method("GET")
     */
    public function showAction(FornecedorSoftware $fornecedorSoftware)
    {
        $deleteForm = $this->createDeleteForm($fornecedorSoftware);

        return $this->render('fornecedorsoftware/show.html.twig', array(
            'fornecedorSoftware' => $fornecedorSoftware,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing FornecedorSoftware entity.
     *
     * @Route("/{id}/edit", name="cadastro_fornecedorsoftware_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, FornecedorSoftware $fornecedorSoftware)
    {
        $deleteForm = $this->createDeleteForm($fornecedorSoftware);
        $editForm = $this->createForm('MRS\InventarioBundle\Form\FornecedorSoftwareType', $fornecedorSoftware);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($fornecedorSoftware);
            $em->flush();

            $this->addFlash('notice','Alterado com sucesso!');

            return $this->redirectToRoute('cadastro_fornecedorsoftware_show', array('id' => $fornecedorSoftware->getId()));
        }

        return $this->render('fornecedorsoftware/edit.html.twig', array(
            'fornecedorSoftware' => $fornecedorSoftware,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a FornecedorSoftware entity.
     *
     * @Route("/{id}", name="cadastro_fornecedorsoftware_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, FornecedorSoftware $fornecedorSoftware)
    {
        $form = $this->createDeleteForm($fornecedorSoftware);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($fornecedorSoftware);
            $em->flush();
        }

        return $this->redirectToRoute('cadastro_fornecedorsoftware_index');
    }

    /**
     * Creates a form to delete a FornecedorSoftware entity.
     *
     * @param FornecedorSoftware $fornecedorSoftware The FornecedorSoftware entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(FornecedorSoftware $fornecedorSoftware)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('cadastro_fornecedorsoftware_delete', array('id' => $fornecedorSoftware->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
