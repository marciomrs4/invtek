<?php

namespace MRS\BackupBundle\Controller;

use MRS\BackupBundle\Entity\RegistroBackup;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use MRS\BackupBundle\Entity\AnexoBackup;
use MRS\BackupBundle\Form\AnexoBackupType;

/**
 * AnexoBackup controller.
 *
 * @Route("/cadastro/anexobackup")
 */
class AnexoBackupController extends Controller
{
    /**
     * Lists all AnexoBackup entities.
     *
     * @Route("/{registroBackup}", name="cadastro_anexobackup_index")
     * @Method("GET")
     */
    public function indexAction(RegistroBackup $registroBackup)
    {
        $em = $this->getDoctrine()->getManager();

        $anexoBackups = $em->getRepository('MRSBackupBundle:AnexoBackup')
            ->findBy(array('registroBackup' => $registroBackup));

        return $this->render('anexobackup/index.html.twig', array(
            'anexoBackups' => $anexoBackups,
        ));
    }

    /**
     * Creates a new AnexoBackup entity.
     *
     * @Route("/new/{registroBackup}", name="cadastro_anexobackup_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request, RegistroBackup $registroBackup)
    {
        $anexoBackup = new AnexoBackup();
        $anexoBackup->setRegistroBackup($registroBackup);

        $form = $this->createForm('MRS\BackupBundle\Form\AnexoBackupType', $anexoBackup);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($anexoBackup);
            $em->flush();

            $mensagens = [
                'mensagem' => 'Criado com sucesso!',
                'tipo_mensagem' => 'success'
            ];

            $this->addFlash('notice',$mensagens);

            return $this->redirectToRoute('cadastro_registrobackup_show', array('id' => $registroBackup->getId()));
        }

        return $this->render('anexobackup/new.html.twig', array(
            'anexoBackup' => $anexoBackup,
            'registroBackup' => $registroBackup,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a AnexoBackup entity.
     *
     * @Route("/{id}", name="cadastro_anexobackup_show")
     * @Method("GET")
     */
    public function showAction(AnexoBackup $anexoBackup)
    {
        $deleteForm = $this->createDeleteForm($anexoBackup);

        return $this->render('anexobackup/show.html.twig', array(
            'anexoBackup' => $anexoBackup,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing AnexoBackup entity.
     *
     * @Route("/{id}/edit", name="cadastro_anexobackup_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, AnexoBackup $anexoBackup)
    {
        $deleteForm = $this->createDeleteForm($anexoBackup);
        $editForm = $this->createForm('MRS\BackupBundle\Form\AnexoBackupType', $anexoBackup);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($anexoBackup);
            $em->flush();

            $mensagens = [
                'mensagem' => 'Criado com sucesso!',
                'tipo_mensagem' => 'success'
            ];

            $this->addFlash('notice',$mensagens);

            return $this->redirectToRoute('cadastro_registrobackup_show', array('id' => $anexoBackup->getRegistroBackup()->getId()));
        }

        return $this->render('anexobackup/edit.html.twig', array(
            'anexoBackup' => $anexoBackup,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a AnexoBackup entity.
     *
     * @Route("/{id}", name="cadastro_anexobackup_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, AnexoBackup $anexoBackup)
    {

        $id = $anexoBackup->getRegistroBackup()->getId();

        $form = $this->createDeleteForm($anexoBackup);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($anexoBackup);
            $em->flush();

            $mensagens = [
                'mensagem' => 'Removido com sucesso!',
                'tipo_mensagem' => 'success'
            ];

            $this->addFlash('notice',$mensagens);
        }

        return $this->redirectToRoute('cadastro_registrobackup_show',array('id' => $id));
    }

    /**
     * Creates a form to delete a AnexoBackup entity.
     *
     * @param AnexoBackup $anexoBackup The AnexoBackup entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(AnexoBackup $anexoBackup)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('cadastro_anexobackup_delete', array('id' => $anexoBackup->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }

    /**
     * @Route("/view/log/{anexoBackup}", name="view_log_anexo_backup")
     * @Method("GET")
     */
    public function viewLogAction(AnexoBackup $anexoBackup)
    {
        $gedmo = $this->getDoctrine()
            ->getRepository('Gedmo:LogEntry');

        $logs = $gedmo->getLogEntries($anexoBackup);

        return $this->render('logentry/logentry.html.twig',array(
            'logs' => $logs
        ));

    }
}
