<?php

namespace MRS\BackupBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use MRS\BackupBundle\Entity\TipoJob;
use MRS\BackupBundle\Form\TipoJobType;

/**
 * TipoJob controller.
 *
 * @Route("/cadastro/tipojob")
 */
class TipoJobController extends Controller
{
    /**
     * Lists all TipoJob entities.
     *
     * @Route("/", name="cadastro_tipojob_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $tipoJobs = $em->getRepository('MRSBackupBundle:TipoJob')->findAll();

        return $this->render('tipojob/index.html.twig', array(
            'tipoJobs' => $tipoJobs,
        ));
    }

    /**
     * Creates a new TipoJob entity.
     *
     * @Route("/new", name="cadastro_tipojob_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $tipoJob = new TipoJob();
        $form = $this->createForm('MRS\BackupBundle\Form\TipoJobType', $tipoJob);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($tipoJob);
            $em->flush();

            $this->addFlash('notice','Criado com sucesso!');

            return $this->redirectToRoute('cadastro_tipojob_show', array('id' => $tipoJob->getId()));
        }

        return $this->render('tipojob/new.html.twig', array(
            'tipoJob' => $tipoJob,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a TipoJob entity.
     *
     * @Route("/{id}", name="cadastro_tipojob_show")
     * @Method("GET")
     */
    public function showAction(TipoJob $tipoJob)
    {
        $deleteForm = $this->createDeleteForm($tipoJob);

        return $this->render('tipojob/show.html.twig', array(
            'tipoJob' => $tipoJob,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing TipoJob entity.
     *
     * @Route("/{id}/edit", name="cadastro_tipojob_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, TipoJob $tipoJob)
    {
        $deleteForm = $this->createDeleteForm($tipoJob);
        $editForm = $this->createForm('MRS\BackupBundle\Form\TipoJobType', $tipoJob);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($tipoJob);
            $em->flush();

            $this->addFlash('notice','Alterado com sucesso!');

            return $this->redirectToRoute('cadastro_tipojob_show', array('id' => $tipoJob->getId()));
        }

        return $this->render('tipojob/edit.html.twig', array(
            'tipoJob' => $tipoJob,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a TipoJob entity.
     *
     * @Route("/{id}", name="cadastro_tipojob_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, TipoJob $tipoJob)
    {
        $form = $this->createDeleteForm($tipoJob);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($tipoJob);
            $em->flush();
        }

        return $this->redirectToRoute('cadastro_tipojob_index');
    }

    /**
     * Creates a form to delete a TipoJob entity.
     *
     * @param TipoJob $tipoJob The TipoJob entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(TipoJob $tipoJob)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('cadastro_tipojob_delete', array('id' => $tipoJob->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }

    /**
     * @param TipoJob $tipojob
     * @Route("/view/log/{tipojob}",name="view_log_tipojob")
     */
    public function viewLogAction(TipoJob $tipojob)
    {
        $gedmo = $this->getDoctrine()->getRepository('Gedmo:LogEntry');

        $logs = $gedmo->getLogEntries($tipojob);

        return $this->render('logentry/logentry.html.twig',array(
            'logs' => $logs
        ));
    }
}
