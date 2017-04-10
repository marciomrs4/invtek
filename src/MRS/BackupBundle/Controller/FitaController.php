<?php

namespace MRS\BackupBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use MRS\BackupBundle\Entity\Fita;
use MRS\BackupBundle\Form\FitaType;

/**
 * Fita controller.
 *
 * @Route("/cadastro/fita")
 */
class FitaController extends Controller
{
    /**
     * Lists all Fita entities.
     *
     * @Route("/", name="cadastro_fita_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $fitas = $em->getRepository('MRSBackupBundle:Fita')
            ->findBy(array(),array('id' => 'DESC'));

        return $this->render('fita/index.html.twig', array(
            'fitas' => $fitas,
        ));
    }

    /**
     * Creates a new Fita entity.
     *
     * @Route("/new", name="cadastro_fita_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $fitum = new Fita();
        $form = $this->createForm('MRS\BackupBundle\Form\FitaType', $fitum);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($fitum);
            $em->flush();

            $this->addFlash('notice','Criado com sucesso!');

            return $this->redirectToRoute('cadastro_fita_show', array('id' => $fitum->getId()));
        }

        return $this->render('fita/new.html.twig', array(
            'fitum' => $fitum,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Fita entity.
     *
     * @Route("/{id}", name="cadastro_fita_show")
     * @Method("GET")
     */
    public function showAction(Fita $fitum)
    {
        $deleteForm = $this->createDeleteForm($fitum);

        return $this->render('fita/show.html.twig', array(
            'fitum' => $fitum,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Fita entity.
     *
     * @Route("/{id}/edit", name="cadastro_fita_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Fita $fitum)
    {
        $deleteForm = $this->createDeleteForm($fitum);
        $editForm = $this->createForm('MRS\BackupBundle\Form\FitaType', $fitum);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($fitum);
            $em->flush();

            $this->addFlash('notice','Alterado com sucesso!');

            return $this->redirectToRoute('cadastro_fita_show', array('id' => $fitum->getId()));
        }

        return $this->render('fita/edit.html.twig', array(
            'fitum' => $fitum,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Fita entity.
     *
     * @Route("/{id}", name="cadastro_fita_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Fita $fitum)
    {
        $form = $this->createDeleteForm($fitum);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($fitum);
            $em->flush();
        }

        return $this->redirectToRoute('cadastro_fita_index');
    }

    /**
     * Creates a form to delete a Fita entity.
     *
     * @param Fita $fitum The Fita entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Fita $fitum)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('cadastro_fita_delete', array('id' => $fitum->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }

    /**
     * @Route("/view/log/{fita}", name="view_log_fita")
     * @Method("GET")
     */
    public function viewLogAction(Fita $fita)
    {
        $gedmo = $this->getDoctrine()
            ->getRepository('Gedmo:LogEntry');

        $logs = $gedmo->getLogEntries($fita);

        return $this->render('logentry/logentry.html.twig',array(
            'logs' => $logs
        ));

    }

}
