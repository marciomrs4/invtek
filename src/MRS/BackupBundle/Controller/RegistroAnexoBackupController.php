<?php

namespace MRS\BackupBundle\Controller;

use MRS\BackupBundle\Entity\RegistroBackup;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use MRS\BackupBundle\Entity\RegistroAnexoBackup;
use MRS\BackupBundle\Form\RegistroAnexoBackupType;

/**
 * RegistroAnexoBackup controller.
 *
 * @Route("/cadastro/registroanexobackup")
 */
class RegistroAnexoBackupController extends Controller
{
    /**
     * Lists all RegistroAnexoBackup entities.
     *
     * @Route("/{registroBackup}", name="cadastro_registroanexobackup_index")
     * @Method("GET")
     */
    public function indexAction(RegistroBackup $registroBackup)
    {
        $em = $this->getDoctrine()->getManager();

        $registroAnexoBackups = $em->getRepository('MRSBackupBundle:RegistroAnexoBackup')
            ->findBy(array('registroBackup' => $registroBackup));

        return $this->render('registroanexobackup/index.html.twig', array(
            'registroBackup' => $registroBackup,
            'registroAnexoBackups' => $registroAnexoBackups,
        ));
    }

    /**
     * Lists all RegistroAnexoBackup entities.
     *
     * @Route("/to-show/{registroBackup}", name="cadastro_registroanexobackup_to_show")
     * @Method("GET")
     */
    public function toShowAction(RegistroBackup $registroBackup)
    {
        $em = $this->getDoctrine()->getManager();

        $registroAnexoBackups = $em->getRepository('MRSBackupBundle:RegistroAnexoBackup')
            ->findBy(array('registroBackup' => $registroBackup));

        return $this->render('registroanexobackup/to_show.html.twig', array(
            'registroBackup' => $registroBackup,
            'registroAnexoBackups' => $registroAnexoBackups,
        ));
    }

    /**
     * Creates a new RegistroAnexoBackup entity.
     *
     * @Route("/new/{registroBackup}", name="cadastro_registroanexobackup_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request, RegistroBackup $registroBackup)
    {
        $registroAnexoBackup = new RegistroAnexoBackup();

        $registroAnexoBackup->setRegistroBackup($registroBackup);

        $form = $this->createForm('MRS\BackupBundle\Form\RegistroAnexoBackupType', $registroAnexoBackup);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($registroAnexoBackup);
            $em->flush();

            $mensagem = ['tipo_mensagem' => 'success',
                        'mensagem' => 'Anexo informado com sucesso!'];

            $this->addFlash('mensagem',$mensagem);

            return $this->redirectToRoute('cadastro_registrobackup_show', array('id' => $registroBackup->getId()));
        }

        return $this->render('registroanexobackup/new.html.twig', array(
            'registroAnexoBackup' => $registroAnexoBackup,
            'registroBackup' => $registroBackup,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a RegistroAnexoBackup entity.
     *
     * @Route("/show/{id}", name="cadastro_registroanexobackup_show")
     * @Method("GET")
     */
    public function showAction(RegistroAnexoBackup $registroAnexoBackup)
    {
        $deleteForm = $this->createDeleteForm($registroAnexoBackup);

        return $this->render('registroanexobackup/show.html.twig', array(
            'registroAnexoBackup' => $registroAnexoBackup,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing RegistroAnexoBackup entity.
     *
     * @Route("/{id}/edit", name="cadastro_registroanexobackup_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, RegistroAnexoBackup $registroAnexoBackup)
    {
        $deleteForm = $this->createDeleteForm($registroAnexoBackup);
        $editForm = $this->createForm('MRS\BackupBundle\Form\RegistroAnexoBackupType', $registroAnexoBackup);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($registroAnexoBackup);
            $em->flush();

            $mensagem = ['tipo_mensagem' => 'success',
                'mensagem' => 'Anexo alterado com sucesso!'];

            return $this->redirectToRoute('cadastro_registroanexobackup_show', array('id' => $registroAnexoBackup->getId()));
        }

        return $this->render('registroanexobackup/edit.html.twig', array(
            'registroAnexoBackup' => $registroAnexoBackup,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a RegistroAnexoBackup entity.
     *
     * @Route("/{id}", name="cadastro_registroanexobackup_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, RegistroAnexoBackup $registroAnexoBackup)
    {
        $registroBackup = $registroAnexoBackup->getRegistroBackup()->getId();

        $form = $this->createDeleteForm($registroAnexoBackup);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($registroAnexoBackup);
            $em->flush();
        }

        return $this->redirectToRoute('cadastro_registroanexobackup_index',array('registroBackup' => $registroBackup));
    }

    /**
     * Creates a form to delete a RegistroAnexoBackup entity.
     *
     * @param RegistroAnexoBackup $registroAnexoBackup The RegistroAnexoBackup entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(RegistroAnexoBackup $registroAnexoBackup)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('cadastro_registroanexobackup_delete', array('id' => $registroAnexoBackup->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
