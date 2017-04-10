<?php

namespace MRS\BackupBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use MRS\BackupBundle\Entity\TipoMidia;
use MRS\BackupBundle\Form\TipoMidiaType;

/**
 * TipoMidia controller.
 *
 * @Route("/cadastro/tipomidia")
 */
class TipoMidiaController extends Controller
{
    /**
     * Lists all TipoMidia entities.
     *
     * @Route("/", name="cadastro_tipomidia_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $tipoMidias = $em->getRepository('MRSBackupBundle:TipoMidia')->findAll();

        return $this->render('tipomidia/index.html.twig', array(
            'tipoMidias' => $tipoMidias,
        ));
    }

    /**
     * Creates a new TipoMidia entity.
     *
     * @Route("/new", name="cadastro_tipomidia_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $tipoMidium = new TipoMidia();
        $form = $this->createForm('MRS\BackupBundle\Form\TipoMidiaType', $tipoMidium);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($tipoMidium);
            $em->flush();

            $this->addFlash('notice','Criado com sucesso!');

            return $this->redirectToRoute('cadastro_tipomidia_show', array('id' => $tipoMidium->getId()));
        }

        return $this->render('tipomidia/new.html.twig', array(
            'tipoMidium' => $tipoMidium,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a TipoMidia entity.
     *
     * @Route("/{id}", name="cadastro_tipomidia_show")
     * @Method("GET")
     */
    public function showAction(TipoMidia $tipoMidium)
    {
        $deleteForm = $this->createDeleteForm($tipoMidium);

        return $this->render('tipomidia/show.html.twig', array(
            'tipoMidium' => $tipoMidium,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing TipoMidia entity.
     *
     * @Route("/{id}/edit", name="cadastro_tipomidia_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, TipoMidia $tipoMidium)
    {
        $deleteForm = $this->createDeleteForm($tipoMidium);
        $editForm = $this->createForm('MRS\BackupBundle\Form\TipoMidiaType', $tipoMidium);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($tipoMidium);
            $em->flush();

            $this->addFlash('notice','Alterado com sucesso!');

            return $this->redirectToRoute('cadastro_tipomidia_show', array('id' => $tipoMidium->getId()));
        }

        return $this->render('tipomidia/edit.html.twig', array(
            'tipoMidium' => $tipoMidium,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a TipoMidia entity.
     *
     * @Route("/{id}", name="cadastro_tipomidia_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, TipoMidia $tipoMidium)
    {
        $form = $this->createDeleteForm($tipoMidium);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($tipoMidium);
            $em->flush();
        }

        return $this->redirectToRoute('cadastro_tipomidia_index');
    }

    /**
     * Creates a form to delete a TipoMidia entity.
     *
     * @param TipoMidia $tipoMidium The TipoMidia entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(TipoMidia $tipoMidium)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('cadastro_tipomidia_delete', array('id' => $tipoMidium->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }


    /**
     * @Route("/view/log/{tipomidia}", name="view_log_tipomidia")
     * @Method("GET")
     */
    public function viewLogAction(TipoMidia $tipomidia)
    {
        $gedmo = $this->getDoctrine()
                      ->getRepository('Gedmo:LogEntry');

        $logs = $gedmo->getLogEntries($tipomidia);

        return $this->render('logentry/logentry.html.twig',array(
            'logs' => $logs
        ));

    }

}
