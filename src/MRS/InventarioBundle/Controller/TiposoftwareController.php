<?php

namespace MRS\InventarioBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use MRS\InventarioBundle\Entity\Tiposoftware;
use MRS\InventarioBundle\Form\TiposoftwareType;

/**
 * Tiposoftware controller.
 *
 * @Route("/cadastro/tiposoftware")
 */
class TiposoftwareController extends Controller
{
    /**
     * Lists all Tiposoftware entities.
     *
     * @Route("/", name="cadastro_tiposoftware_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $tiposoftwares = $em->getRepository('MRSInventarioBundle:Tiposoftware')->findAll();

        return $this->render('tiposoftware/index.html.twig', array(
            'tiposoftwares' => $tiposoftwares,
        ));
    }

    /**
     * Creates a new Tiposoftware entity.
     *
     * @Route("/new", name="cadastro_tiposoftware_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $tiposoftware = new Tiposoftware();
        $form = $this->createForm('MRS\InventarioBundle\Form\TiposoftwareType', $tiposoftware);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($tiposoftware);
            $em->flush();

            $this->addFlash('notice','Criado com sucesso!');

            return $this->redirectToRoute('cadastro_tiposoftware_index', array('id' => $tiposoftware->getId()));
        }

        return $this->render('tiposoftware/new.html.twig', array(
            'tiposoftware' => $tiposoftware,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Tiposoftware entity.
     *
     * @Route("/{id}", name="cadastro_tiposoftware_show")
     * @Method("GET")
     */
    public function showAction(Tiposoftware $tiposoftware)
    {
        $deleteForm = $this->createDeleteForm($tiposoftware);

        return $this->render('tiposoftware/show.html.twig', array(
            'tiposoftware' => $tiposoftware,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Tiposoftware entity.
     *
     * @Route("/{id}/edit", name="cadastro_tiposoftware_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Tiposoftware $tiposoftware)
    {
        $deleteForm = $this->createDeleteForm($tiposoftware);
        $editForm = $this->createForm('MRS\InventarioBundle\Form\TiposoftwareType', $tiposoftware);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($tiposoftware);
            $em->flush();

            $this->addFlash('notice','Alterado com sucesso!');

            return $this->redirectToRoute('cadastro_tiposoftware_show', array('id' => $tiposoftware->getId()));
        }

        return $this->render('tiposoftware/edit.html.twig', array(
            'tiposoftware' => $tiposoftware,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Tiposoftware entity.
     *
     * @Route("/{id}", name="cadastro_tiposoftware_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Tiposoftware $tiposoftware)
    {
        $form = $this->createDeleteForm($tiposoftware);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($tiposoftware);
            $em->flush();
        }

        return $this->redirectToRoute('cadastro_tiposoftware_index');
    }

    /**
     * Creates a form to delete a Tiposoftware entity.
     *
     * @param Tiposoftware $tiposoftware The Tiposoftware entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Tiposoftware $tiposoftware)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('cadastro_tiposoftware_delete', array('id' => $tiposoftware->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
