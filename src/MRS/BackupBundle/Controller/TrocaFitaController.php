<?php

namespace MRS\BackupBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use MRS\BackupBundle\Entity\TrocaFita;
use MRS\BackupBundle\Form\TrocaFitaType;

/**
 * TrocaFita controller.
 *
 * @Route("/cadastro/trocafita")
 */
class TrocaFitaController extends Controller
{
    /**
     * Lists all TrocaFita entities.
     *
     * @Route("/", name="cadastro_trocafita_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $repository = $this->getDoctrine()
                           ->getRepository('MRSBackupBundle:TrocaFita');

        $trocaFitas = $repository->findBy(array(),array('id' => 'DESC','dataCriacao' => 'DESC'));


        return $this->render('trocafita/index.html.twig', array(
            'trocaFitas' => $trocaFitas,
         ));
    }

    /**
     * Creates a new TrocaFita entity.
     *
     * @Route("/new", name="cadastro_trocafita_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $trocaFitum = new TrocaFita();
        $trocaFitum->setUser($this->getUser());

        $form = $this->createForm('MRS\BackupBundle\Form\TrocaFitaType', $trocaFitum);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();

            $em->persist($trocaFitum);
            $em->flush();

            $mensagens = array('mensagem' => 'Criado com sucesso!',
                               'tipo_mensagem' => 'success');

            $this->addFlash('notice',$mensagens);

            return $this->redirectToRoute('cadastro_trocafita_show', array('id' => $trocaFitum->getId()));
        }

        return $this->render('trocafita/new.html.twig', array(
            'trocaFitum' => $trocaFitum,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a TrocaFita entity.
     *
     * @Route("/{id}", name="cadastro_trocafita_show")
     * @Method("GET")
     */
    public function showAction(TrocaFita $trocaFitum)
    {
        $deleteForm = $this->createDeleteForm($trocaFitum);

        return $this->render('trocafita/show.html.twig', array(
            'trocaFitum' => $trocaFitum,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Finds and displays a TrocaFita entity.
     *
     * @Route("/doc/{id}", name="cadastro_trocafita_show_doc")
     * @Method("GET")
     */
    public function showDocAction(TrocaFita $trocaFitum)
    {

        return $this->render('trocafita/doc_show.html.twig', array(
            'trocaFitum' => $trocaFitum,
        ));
    }

    /**
     * Displays a form to edit an existing TrocaFita entity.
     *
     * @Route("/{id}/edit", name="cadastro_trocafita_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, TrocaFita $trocaFitum)
    {
        $em = $this->getDoctrine()->getManager();

        $date = new \DateTime('now');

        if($trocaFitum->getCriadoEm()->format('Y-m-d') != $date->format('Y-m-d')) {

            $mensagens = array('mensagem' => 'Este registro não pode ser alterado pois não foi criado hoje!',
                               'tipo_mensagem' => 'danger');

            $this->addFlash('notice',$mensagens);

            return $this->redirectToRoute('cadastro_trocafita_show',array('id' => $trocaFitum->getId()));
        }

        $deleteForm = $this->createDeleteForm($trocaFitum);
        $editForm = $this->createForm('MRS\BackupBundle\Form\TrocaFitaType', $trocaFitum);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {

            $em->persist($trocaFitum);
            $em->flush();

            $mensagens = array('mensagem' => 'Este registro não pode ser alterado pois não foi criado hoje!',
                               'tipo_mensagem' => 'success');

            $this->addFlash('notice',$mensagens);

            return $this->redirectToRoute('cadastro_trocafita_show', array('id' => $trocaFitum->getId()));
        }

        return $this->render('trocafita/edit.html.twig', array(
            'trocaFitum' => $trocaFitum,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a TrocaFita entity.
     *
     * @Route("/{id}", name="cadastro_trocafita_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, TrocaFita $trocaFitum)
    {
        $form = $this->createDeleteForm($trocaFitum);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($trocaFitum);
            $em->flush();
        }

        return $this->redirectToRoute('cadastro_trocafita_index');
    }

    /**
     * Creates a form to delete a TrocaFita entity.
     *
     * @param TrocaFita $trocaFitum The TrocaFita entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(TrocaFita $trocaFitum)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('cadastro_trocafita_delete', array('id' => $trocaFitum->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }

    /**
     * @Route("/view/log/{trocafita}",name="view_log_trocafita")
     */
    public function viewLogAction(TrocaFita $trocafita)
    {
        $gedmo = $this->getDoctrine()->getRepository('Gedmo:LogEntry');

        $logs = $gedmo->getLogEntries($trocafita);

        return $this->render('logentry/logentry.html.twig', array(
            'logs' => $logs
        ));

    }
}
