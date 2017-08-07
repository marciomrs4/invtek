<?php

namespace MRS\BackupBundle\Controller;

use MRS\BackupBundle\Entity\RegistroRestore;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use MRS\BackupBundle\Entity\AnexoRestore;
use MRS\BackupBundle\Form\AnexoRestoreType;

/**
 * AnexoRestore controller.
 *
 * @Route("/cadastro/anexorestore")
 */
class AnexoRestoreController extends Controller
{
    /**
     * Lists all AnexoRestore entities.
     *
     * @Route("/{registroRestore}", name="cadastro_anexorestore_index")
     * @Method("GET")
     */
    public function indexAction(RegistroRestore $registroRestore)
    {
        $em = $this->getDoctrine()->getManager();

        $anexoRestores = $em->getRepository('MRSBackupBundle:AnexoRestore')
            ->findBy(array('registroRestore' => $registroRestore));

        return $this->render('anexorestore/index.html.twig', array(
            'anexoRestores' => $anexoRestores,
        ));
    }

    /**
     * Creates a new AnexoRestore entity.
     *
     * @Route("/new/{registroRestore}", name="cadastro_anexorestore_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request, RegistroRestore $registroRestore)
    {
        $anexoRestore = new AnexoRestore();
        $anexoRestore->setRegistroRestore($registroRestore);
        $form = $this->createForm('MRS\BackupBundle\Form\AnexoRestoreType', $anexoRestore);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($anexoRestore);
            $em->flush();


            $mensagens = [
                'mensagem' => 'Criado com sucesso!',
                'tipo_mensagem' => 'success'
            ];

            $this->addFlash('notice',$mensagens);

            return $this->redirectToRoute('cadastro_registrorestore_show', array(
                'id' => $registroRestore->getId()
            ));
        }

        return $this->render('anexorestore/new.html.twig', array(
            'anexoRestore' => $anexoRestore,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a AnexoRestore entity.
     *
     * @Route("/{id}", name="cadastro_anexorestore_show")
     * @Method("GET")
     */
    public function showAction(AnexoRestore $anexoRestore)
    {
        $deleteForm = $this->createDeleteForm($anexoRestore);

        return $this->render('anexorestore/show.html.twig', array(
            'anexoRestore' => $anexoRestore,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing AnexoRestore entity.
     *
     * @Route("/{id}/edit", name="cadastro_anexorestore_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, AnexoRestore $anexoRestore)
    {
        $deleteForm = $this->createDeleteForm($anexoRestore);
        $editForm = $this->createForm('MRS\BackupBundle\Form\AnexoRestoreType', $anexoRestore);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($anexoRestore);
            $em->flush();


            $mensagens = [
                'mensagem' => 'Alterado com sucesso!',
                'tipo_mensagem' => 'success'
            ];

            $this->addFlash('notice',$mensagens);

            return $this->redirectToRoute('cadastro_registrorestore_show', array(
                'id' => $anexoRestore->getRegistroRestore()->getId()));
        }

        return $this->render('anexorestore/edit.html.twig', array(
            'anexoRestore' => $anexoRestore,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a AnexoRestore entity.
     *
     * @Route("/{id}", name="cadastro_anexorestore_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, AnexoRestore $anexoRestore)
    {
        $form = $this->createDeleteForm($anexoRestore);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($anexoRestore);
            $em->flush();
        }

        return $this->redirectToRoute('cadastro_anexorestore_index');
    }

    /**
     * Creates a form to delete a AnexoRestore entity.
     *
     * @param AnexoRestore $anexoRestore The AnexoRestore entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(AnexoRestore $anexoRestore)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('cadastro_anexorestore_delete', array('id' => $anexoRestore->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }

    /**
     * @Route("/view/log/{anexoRestore}",name="view_log_anexo_restore")
     */
    public function viewLogAction(AnexoRestore $anexoRestore)
    {
        $gedmo = $this->getDoctrine()->getRepository('Gedmo:LogEntry');

        $logs = $gedmo->getLogEntries($anexoRestore);

        return $this->render('logentry/logentry.html.twig',array(
            'logs' => $logs
        ));

    }
}
