<?php

namespace MRS\InventarioBundle\Controller;

use MRS\InventarioBundle\Entity\Software;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use MRS\InventarioBundle\Entity\LicencaSoftware;
use MRS\InventarioBundle\Form\LicencaSoftwareType;

/**
 * LicencaSoftware controller.
 *
 * @Route("/cadastro/licencasoftware")
 */
class LicencaSoftwareController extends Controller
{
    /**
     * Lists all LicencaSoftware entities.
     *
     * @Route("/{software}", name="cadastro_licencasoftware_index")
     * @Method("GET")
     */
    public function indexAction(Software $software)
    {
        $em = $this->getDoctrine()->getManager();

        $licencaSoftwares = $em->getRepository('MRSInventarioBundle:LicencaSoftware')
                               ->findBy(array('software' => $software));

        return $this->render('licencasoftware/index.html.twig', array(
            'licencaSoftwares' => $licencaSoftwares,
            'software' => $software
        ));
    }

    /**
     * Creates a new LicencaSoftware entity.
     *
     * @Route("/new/{software}", name="cadastro_licencasoftware_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request, Software $software)
    {
        $licencaSoftware = new LicencaSoftware();
        $licencaSoftware->setSoftware($software);
        $form = $this->createForm('MRS\InventarioBundle\Form\LicencaSoftwareType', $licencaSoftware);
        $form->handleRequest($request);




        if ($form->isSubmitted() && $form->isValid()) {

            $em = $this->getDoctrine()->getManager();
            $em->persist($licencaSoftware);
            $em->flush();


            $licencaSoftwareQuantidade = $this->getDoctrine()->getRepository('MRSInventarioBundle:LicencaSoftware');
            $quantidadeTotal = $licencaSoftwareQuantidade->countLicenca($software->getId());


            $em = $this->getDoctrine()->getManager();
            $software->setNumerolicensa($quantidadeTotal);
            $em->persist($software);
            $em->flush();

            $this->addFlash('notice','Criado com sucesso!');

            return $this->redirectToRoute('cadastro_licencasoftware_show', array('id' => $licencaSoftware->getId()));
        }

        return $this->render('licencasoftware/new.html.twig', array(
            'licencaSoftware' => $licencaSoftware,
            'software' => $software,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a LicencaSoftware entity.
     *
     * @Route("/show/{id}", name="cadastro_licencasoftware_show")
     * @Method("GET")
     */
    public function showAction(LicencaSoftware $licencaSoftware)
    {
        $deleteForm = $this->createDeleteForm($licencaSoftware);

        return $this->render('licencasoftware/show.html.twig', array(
            'licencaSoftware' => $licencaSoftware,
            'software' => $licencaSoftware->getSoftware(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing LicencaSoftware entity.
     *
     * @Route("/{id}/edit", name="cadastro_licencasoftware_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, LicencaSoftware $licencaSoftware)
    {
        $deleteForm = $this->createDeleteForm($licencaSoftware);
        $editForm = $this->createForm('MRS\InventarioBundle\Form\LicencaSoftwareType', $licencaSoftware);
        $editForm->handleRequest($request);


        if ($editForm->isSubmitted() && $editForm->isValid()) {

            $em = $this->getDoctrine()->getManager();
            $em->persist($licencaSoftware);
            $em->flush();

            $software = $licencaSoftware->getSoftware();

            $licencaSoftwareQuantidade = $this->getDoctrine()->getRepository('MRSInventarioBundle:LicencaSoftware');
            $quantidadeTotal = $licencaSoftwareQuantidade->countLicenca($software->getId());

            $em = $this->getDoctrine()->getManager();
            $software->setNumerolicensa($quantidadeTotal);
            $em->persist($software);


            $em->flush();

            $this->addFlash('notice','Alterado com sucesso!');

            return $this->redirectToRoute('cadastro_licencasoftware_show', array('id' => $licencaSoftware->getId()));
        }

        return $this->render('licencasoftware/edit.html.twig', array(
            'licencaSoftware' => $licencaSoftware,
            'software' => $licencaSoftware->getSoftware(),
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a LicencaSoftware entity.
     *
     * @Route("/{id}", name="cadastro_licencasoftware_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, LicencaSoftware $licencaSoftware)
    {
        $form = $this->createDeleteForm($licencaSoftware);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($licencaSoftware);
            $em->flush();
        }

        return $this->redirectToRoute('cadastro_licencasoftware_index');
    }

    /**
     * Creates a form to delete a LicencaSoftware entity.
     *
     * @param LicencaSoftware $licencaSoftware The LicencaSoftware entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(LicencaSoftware $licencaSoftware)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('cadastro_licencasoftware_delete', array('id' => $licencaSoftware->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
