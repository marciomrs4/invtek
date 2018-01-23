<?php

namespace MRS\BackupBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use MRS\BackupBundle\Entity\RegistroRestore;
use MRS\BackupBundle\Form\RegistroRestoreType;

/**
 * RegistroRestore controller.
 *
 * @Route("/cadastro/registrorestore")
 */
class RegistroRestoreController extends Controller
{
    /**
     * Lists all RegistroRestore entities.
     *
     * @Route("/", name="cadastro_registrorestore_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $repository = $this->getDoctrine()
            ->getRepository('MRSBackupBundle:RegistroRestore');

        $registroRestores = $repository->findBy(array(),array('id' => 'DESC'));

        return $this->render('registrorestore/index.html.twig', array(
            'registroRestores' => $registroRestores
        ));
    }

    /**
     * Creates a new RegistroRestore entity.
     *
     * @Route("/new", name="cadastro_registrorestore_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $registroRestore = new RegistroRestore();
        $registroRestore->setUser($this->getUser());

        $form = $this->createForm('MRS\BackupBundle\Form\RegistroRestoreType', $registroRestore);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            if($this->validateFitaEquipamento($registroRestore)){

                $mensagens = [
                    'mensagem' => 'O equipamento e fita não são da mesma unidade!',
                    'tipo_mensagem' => 'warning'
                ];

                $this->addFlash('notice',$mensagens);

                return $this->redirectToRoute('cadastro_registrorestore_new');

            }

            $registroRestore->setTipoJobName($registroRestore->getTipoJob()->getDescricao())
                ->setEquipamentoName($registroRestore->getEquipamento()->getPatrimonio())
                ->setFitaName($registroRestore->getFita()->getBarCode());

            $em->persist($registroRestore);
            $em->flush();


            $mensagens = [
                'mensagem' => 'Criado com sucesso!',
                'tipo_mensagem' => 'success'
            ];

            $this->addFlash('notice',$mensagens);

            return $this->redirectToRoute('cadastro_registrorestore_show', array('id' => $registroRestore->getId()));
        }

        return $this->render('registrorestore/new.html.twig', array(
            'registroRestore' => $registroRestore,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a RegistroRestore entity.
     *
     * @Route("/{id}", name="cadastro_registrorestore_show")
     * @Method("GET")
     */
    public function showAction(RegistroRestore $registroRestore)
    {
        $deleteForm = $this->createDeleteForm($registroRestore);

        return $this->render('registrorestore/show.html.twig', array(
            'registroRestore' => $registroRestore,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Finds and displays a RegistroRestore entity.
     *
     * @Route("/doc/{id}", name="cadastro_registrorestore_show_doc")
     * @Method("GET")
     */
    public function showDocAction(RegistroRestore $registroRestore)
    {

        return $this->render('registrorestore/doc_show.html.twig', array(
            'registroRestore' => $registroRestore,
        ));
    }


    /**
     * Displays a form to edit an existing RegistroRestore entity.
     *
     * @Route("/{id}/edit", name="cadastro_registrorestore_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, RegistroRestore $registroRestore)
    {

        $em = $this->getDoctrine()->getManager();

        $date = new \DateTime('now');

        if($registroRestore->getDataCriacao()->format('Y-m-d') != $date->format('Y-m-d')){

            $mensagens = [
                'mensagem' => 'Esse registro não pode ser alterado pois não foi criado hoje!',
                'tipo_mensagem' => 'danger'
            ];

            $this->addFlash('notice',$mensagens);

            return $this->redirectToRoute('cadastro_registrorestore_show',array('id' => $registroRestore->getId()));
        }

        $editForm = $this->createForm('MRS\BackupBundle\Form\RegistroRestoreType', $registroRestore);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {

            if($this->validateFitaEquipamento($registroRestore)){

                $mensagens = [
                    'mensagem' => 'O equipamento e fita não são da mesma unidade!',
                    'tipo_mensagem' => 'warning'
                ];

                $this->addFlash('notice',$mensagens);

                return $this->redirectToRoute('cadastro_registrorestore_edit', array('id' => $registroRestore->getId()));

            }


            $registroRestore->setTipoJobName($registroRestore->getTipoJob()->getDescricao())
                ->setEquipamentoName($registroRestore->getEquipamento()->getPatrimonio())
                ->setFitaName($registroRestore->getFita()->getBarCode());

            $em->persist($registroRestore);
            $em->flush();


            $mensagens = [
                'mensagem' => 'Alterado com sucesso!',
                'tipo_mensagem' => 'success'
            ];

            $this->addFlash('notice',$mensagens);

            return $this->redirectToRoute('cadastro_registrorestore_show', array('id' => $registroRestore->getId()));
        }

        return $this->render('registrorestore/edit.html.twig', array(
            'registroRestore' => $registroRestore,
            'edit_form' => $editForm->createView(),
        ));
    }

    /**
     * Deletes a RegistroRestore entity.
     *
     * @Route("/{id}", name="cadastro_registrorestore_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, RegistroRestore $registroRestore)
    {
        $form = $this->createDeleteForm($registroRestore);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($registroRestore);
            $em->flush();
        }

        return $this->redirectToRoute('cadastro_registrorestore_index');
    }

    /**
     * Creates a form to delete a RegistroRestore entity.
     *
     * @param RegistroRestore $registroRestore The RegistroRestore entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(RegistroRestore $registroRestore)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('cadastro_registrorestore_delete', array('id' => $registroRestore->getId())))
            ->setMethod('DELETE')
            ->getForm()
            ;
    }

    /**
     * @Route("/view/log/{registrorestore}",name="view_log_registrorestore")
     */
    public function viewLogAction(RegistroRestore $registrorestore)
    {
        $gedmo = $this->getDoctrine()->getRepository('Gedmo:LogEntry');

        $logs = $gedmo->getLogEntries($registrorestore);

        return $this->render('logentry/logentry.html.twig',array(
            'logs' => $logs
        ));

    }

    private function validateFitaEquipamento(RegistroRestore $registroRestore)
    {
        $unidadeEquipamento = $registroRestore->getEquipamento()
                                              ->getCentroMovimentacao()
                                              ->getUnidade();

        $unidadeFita = $registroRestore->getFita()
                                       ->getUnidade();

        if($unidadeEquipamento != $unidadeFita){
            return true;
        }

    }
}
