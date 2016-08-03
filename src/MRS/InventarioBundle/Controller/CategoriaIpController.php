<?php

namespace MRS\InventarioBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use MRS\InventarioBundle\Entity\CategoriaIp;
use MRS\InventarioBundle\Form\CategoriaIpType;

/**
 * CategoriaIp controller.
 *
 * @Route("/cadastro/categoriaip")
 */
class CategoriaIpController extends Controller
{
    /**
     * Lists all CategoriaIp entities.
     *
     * @Route("/", name="cadastro_categoriaip_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $categoriaIps = $em->getRepository('MRSInventarioBundle:CategoriaIp')->findAll();

        return $this->render('categoriaip/index.html.twig', array(
            'categoriaIps' => $categoriaIps,
        ));
    }

    /**
     * Creates a new CategoriaIp entity.
     *
     * @Route("/new", name="cadastro_categoriaip_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $categoriaIp = new CategoriaIp();
        $form = $this->createForm('MRS\InventarioBundle\Form\CategoriaIpType', $categoriaIp);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($categoriaIp);
            $em->flush();

            $this->addFlash('notice','Criado com sucesso!');

            return $this->redirectToRoute('cadastro_categoriaip_show', array('id' => $categoriaIp->getId()));
        }

        return $this->render('categoriaip/new.html.twig', array(
            'categoriaIp' => $categoriaIp,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a CategoriaIp entity.
     *
     * @Route("/{id}", name="cadastro_categoriaip_show")
     * @Method("GET")
     */
    public function showAction(CategoriaIp $categoriaIp)
    {
        $deleteForm = $this->createDeleteForm($categoriaIp);

        return $this->render('categoriaip/show.html.twig', array(
            'categoriaIp' => $categoriaIp,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing CategoriaIp entity.
     *
     * @Route("/{id}/edit", name="cadastro_categoriaip_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, CategoriaIp $categoriaIp)
    {
        $deleteForm = $this->createDeleteForm($categoriaIp);
        $editForm = $this->createForm('MRS\InventarioBundle\Form\CategoriaIpType', $categoriaIp);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($categoriaIp);
            $em->flush();

            $this->addFlash('notice','Alterado com sucesso!');

            return $this->redirectToRoute('cadastro_categoriaip_show', array('id' => $categoriaIp->getId()));
        }

        return $this->render('categoriaip/edit.html.twig', array(
            'categoriaIp' => $categoriaIp,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a CategoriaIp entity.
     *
     * @Route("/{id}", name="cadastro_categoriaip_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, CategoriaIp $categoriaIp)
    {
        $form = $this->createDeleteForm($categoriaIp);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($categoriaIp);
            $em->flush();
        }

        return $this->redirectToRoute('cadastro_categoriaip_index');
    }

    /**
     * Creates a form to delete a CategoriaIp entity.
     *
     * @param CategoriaIp $categoriaIp The CategoriaIp entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(CategoriaIp $categoriaIp)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('cadastro_categoriaip_delete', array('id' => $categoriaIp->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
