<?php

namespace MRS\InventarioBundle\Controller;

use MRS\InventarioBundle\Entity\Software;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use MRS\InventarioBundle\Entity\SoftwareTag;
use MRS\InventarioBundle\Form\SoftwareTagType;

/**
 * SoftwareTag controller.
 *
 * @Route("/cadastro/softwaretag")
 */
class SoftwareTagController extends Controller
{
    /**
     * Lists all SoftwareTag entities.
     *
     * @Route("/{software}", name="cadastro_softwaretag_index")
     * @Method("GET")
     */
    public function indexAction(Software $software)
    {
        $em = $this->getDoctrine()->getManager();

        $softwareTags = $em->getRepository('MRSInventarioBundle:SoftwareTag')
            ->findBy(array('software'=>$software));

        return $this->render('softwaretag/index.html.twig', array(
            'softwareTags' => $softwareTags,
            'software' => $software
        ));
    }

    /**
     * Creates a new SoftwareTag entity.
     *
     * @Route("/new/{software}", name="cadastro_softwaretag_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request, Software $software)
    {
        $softwareTag = new SoftwareTag();

        $softwareTag->setSoftware($software);

        $form = $this->createForm('MRS\InventarioBundle\Form\SoftwareTagType', $softwareTag);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($softwareTag);
            $em->flush();

            $this->addFlash('notice','Criado com sucesso!');

            return $this->redirectToRoute('cadastro_softwaretag_index', array('software' => $software->getId()));
        }

        return $this->render('softwaretag/new.html.twig', array(
            'softwareTag' => $softwareTag,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a SoftwareTag entity.
     *
     * @Route("/{id}", name="cadastro_softwaretag_show")
     * @Method("GET")
     */
    public function showAction(SoftwareTag $softwareTag)
    {
        $deleteForm = $this->createDeleteForm($softwareTag);

        return $this->render('softwaretag/show.html.twig', array(
            'softwareTag' => $softwareTag,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing SoftwareTag entity.
     *
     * @Route("/{id}/edit", name="cadastro_softwaretag_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, SoftwareTag $softwareTag)
    {
        $deleteForm = $this->createDeleteForm($softwareTag);
        $editForm = $this->createForm('MRS\InventarioBundle\Form\SoftwareTagType', $softwareTag);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($softwareTag);
            $em->flush();

            $this->addFlash('notice','Alterado com sucesso!');

            return $this->redirectToRoute('cadastro_softwaretag_index', array(
                'software' => $softwareTag->getSoftware()->getId()));
        }

        return $this->render('softwaretag/edit.html.twig', array(
            'softwareTag' => $softwareTag,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a SoftwareTag entity.
     *
     * @Route("/{id}", name="cadastro_softwaretag_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, SoftwareTag $softwareTag)
    {
        $form = $this->createDeleteForm($softwareTag);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($softwareTag);
            $em->flush();

            $this->addFlash('notice','Removido com sucesso!');
        }

        return $this->redirectToRoute('cadastro_softwaretag_index',array(
            'software' => $softwareTag->getSoftware()->getId()
        ));
    }

    /**
     * Creates a form to delete a SoftwareTag entity.
     *
     * @param SoftwareTag $softwareTag The SoftwareTag entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(SoftwareTag $softwareTag)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('cadastro_softwaretag_delete', array('id' => $softwareTag->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
