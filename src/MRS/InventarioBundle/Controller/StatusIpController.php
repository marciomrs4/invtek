<?php

namespace MRS\InventarioBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use MRS\InventarioBundle\Entity\StatusIp;
use MRS\InventarioBundle\Form\StatusIpType;

/**
 * StatusIp controller.
 *
 * @Route("/cadastro/statusip")
 */
class StatusIpController extends Controller
{
    /**
     * Lists all StatusIp entities.
     *
     * @Route("/", name="cadastro_statusip_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $statusIps = $em->getRepository('MRSInventarioBundle:StatusIp')->findAll();

        return $this->render('statusip/index.html.twig', array(
            'statusIps' => $statusIps,
        ));
    }

    /**
     * Creates a new StatusIp entity.
     *
     * @Route("/new", name="cadastro_statusip_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $statusIp = new StatusIp();
        $form = $this->createForm('MRS\InventarioBundle\Form\StatusIpType', $statusIp);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($statusIp);
            $em->flush();

            $this->addFlash('notice','Criado com sucesso!');

            return $this->redirectToRoute('cadastro_statusip_show', array('id' => $statusIp->getId()));
        }

        return $this->render('statusip/new.html.twig', array(
            'statusIp' => $statusIp,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a StatusIp entity.
     *
     * @Route("/{id}", name="cadastro_statusip_show")
     * @Method("GET")
     */
    public function showAction(StatusIp $statusIp)
    {
        $deleteForm = $this->createDeleteForm($statusIp);

        return $this->render('statusip/show.html.twig', array(
            'statusIp' => $statusIp,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing StatusIp entity.
     *
     * @Route("/{id}/edit", name="cadastro_statusip_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, StatusIp $statusIp)
    {
        $deleteForm = $this->createDeleteForm($statusIp);
        $editForm = $this->createForm('MRS\InventarioBundle\Form\StatusIpType', $statusIp);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($statusIp);
            $em->flush();

            $this->addFlash('notice','Alterado com sucesso!');

            return $this->redirectToRoute('cadastro_statusip_show', array('id' => $statusIp->getId()));
        }

        return $this->render('statusip/edit.html.twig', array(
            'statusIp' => $statusIp,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a StatusIp entity.
     *
     * @Route("/{id}", name="cadastro_statusip_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, StatusIp $statusIp)
    {
        $form = $this->createDeleteForm($statusIp);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($statusIp);
            $em->flush();
        }

        return $this->redirectToRoute('cadastro_statusip_index');
    }

    /**
     * Creates a form to delete a StatusIp entity.
     *
     * @param StatusIp $statusIp The StatusIp entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(StatusIp $statusIp)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('cadastro_statusip_delete', array('id' => $statusIp->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
