<?php

namespace MRS\BackupBundle\Controller;

use MRS\BackupBundle\Entity\RegistroBackupEquipamento;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use MRS\BackupBundle\Entity\RegistroBackup;
use MRS\BackupBundle\Form\RegistroBackupType;

/**
 * RegistroBackup controller.
 *
 * @Route("/cadastro/registrobackup")
 */
class RegistroBackupController extends Controller
{
    /**
     * Lists all RegistroBackup entities.
     *
     * @Route("/", name="cadastro_registrobackup_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $repository = $this->getDoctrine()
                           ->getRepository('MRSBackupBundle:RegistroBackup');

        $registroBackups = $repository->findBy(array(),array('id' => 'DESC'));

        $status_falha = $this->getParameter('status_falha');

        return $this->render('registrobackup/index.html.twig', array(
            'registroBackups' => $registroBackups,
            'status_falha' => $status_falha
        ));
    }

    /**
     * Creates a new RegistroBackup entity.
     *
     * @Route("/new", name="cadastro_registrobackup_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $registroBackup = new RegistroBackup();
        $registroBackup->setUser($this->getUser());

        $form = $this->createForm('MRS\BackupBundle\Form\RegistroBackupType', $registroBackup);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();

            $jobId = $registroBackup->getJob();

            $jobsServidor = $em->getRepository('MRSBackupBundle:JobServidor')
                               ->findBy(array('job' => $jobId));

            if(!$jobsServidor){

                $mensagens = array('mensagem' => 'Não existe servidores neste jobs!',
                                   'tipo_mensagem' => 'warning',
                                    'job_id' => $jobId->getId());

                $this->addFlash('notice',$mensagens);

                return $this->redirectToRoute('cadastro_registrobackup_new');
            }

            //dump($jobsServidor); exit();


            foreach($jobsServidor as $jobServidor){

                $registroBackupEquipamento = new RegistroBackupEquipamento();

                $registroBackupEquipamento->setUnidade($jobId->getUnidade())
                    ->setDataCriacao(new \DateTime('now'))
                    ->setEquipamento($jobServidor->getEquipamento())
                    ->setRegistroBackupId($registroBackup);

                $em->persist($registroBackupEquipamento);

            }

            $registroBackup->setTipoJob($registroBackup->getJob()->getTipoJob()->getDescricao())
                           ->setJobName($registroBackup->getJob()->getDescricao());


            $em->persist($registroBackup);

            $em->flush();

            $mensagens = array('mensagem' => 'Registrado com sucesso!',
                               'tipo_mensagem' => 'success');

            $this->addFlash('notice',$mensagens);


            return $this->redirectToRoute('cadastro_registrobackup_show', array('id' => $registroBackup->getId()));
        }

        return $this->render('registrobackup/new.html.twig', array(
            'registroBackup' => $registroBackup,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a RegistroBackup entity.
     *
     * @Route("/{id}", name="cadastro_registrobackup_show")
     * @Method("GET")
     */
    public function showAction(RegistroBackup $registroBackup)
    {
        $deleteForm = $this->createDeleteForm($registroBackup);

        return $this->render('registrobackup/show.html.twig', array(
            'registroBackup' => $registroBackup,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Finds and displays a RegistroBackup entity.
     *
     * @Route("/doc/{id}", name="cadastro_registrobackup_show_doc")
     * @Method("GET")
     */
    public function showDocAction(RegistroBackup $registroBackup)
    {

        return $this->render('registrobackup/doc_show.html.twig', array(
            'registroBackup' => $registroBackup,
        ));
    }

    /**
     * Displays a form to edit an existing RegistroBackup entity.
     *
     * @Route("/{id}/edit", name="cadastro_registrobackup_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, RegistroBackup $registroBackup)
    {

        $em = $this->getDoctrine()->getManager();

        $date = new \DateTime('now');

        if($registroBackup->getDataCriacao()->format('Y-m-d') != $date->format('Y-m-d')){

            $mensagens = array('mensagem' => 'Esse registro não pode ser alterado pois não foi criado hoje',
                                'tipo_mensagem' => 'danger');

            $this->addFlash('notice',$mensagens);

            return $this->redirectToRoute('cadastro_registrobackup_show', array('id' => $registroBackup->getId()));
        }


        $editForm = $this->createForm('MRS\BackupBundle\Form\RegistroBackupType', $registroBackup);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {

            $regitrosBackupEquipamentos = $em->getRepository('MRSBackupBundle:RegistroBackupEquipamento')
                ->findBy(array('registroBackupId' => $registroBackup));

            foreach($regitrosBackupEquipamentos as $regitroBackupEquipamento) {

                $em->remove($regitroBackupEquipamento);
            }

            $jobId = $registroBackup->getJob();

            $jobsServidor = $em->getRepository('MRSBackupBundle:JobServidor')
                ->findBy(array('job' => $jobId));

            foreach($jobsServidor as $jobServidor){

                $registroBackupEquipamento = new RegistroBackupEquipamento();

                $registroBackupEquipamento->setUnidade($jobId->getUnidade())
                    ->setDataCriacao($registroBackup->getData())
                    ->setEquipamento($jobServidor->getEquipamento())
                    ->setRegistroBackupId($registroBackup);

                $em->persist($registroBackupEquipamento);

            }

            $registroBackup->setTipoJob($registroBackup->getJob()->getTipoJob()->getDescricao())
                           ->setJobName($registroBackup->getJob()->getDescricao());

            $em->persist($registroBackup);

            $em->flush();

            $mensagens = array('mensagem' => 'Registrado com sucesso!',
                               'tipo_mensagem' => 'success');

            $this->addFlash('notice',$mensagens);

            return $this->redirectToRoute('cadastro_registrobackup_show', array('id' => $registroBackup->getId()));
        }

        return $this->render('registrobackup/edit.html.twig', array(
            'registroBackup' => $registroBackup,
            'edit_form' => $editForm->createView(),
        ));
    }

    /**
     * Deletes a RegistroBackup entity.
     *
     * @Route("/{id}", name="cadastro_registrobackup_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, RegistroBackup $registroBackup)
    {
        $form = $this->createDeleteForm($registroBackup);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($registroBackup);
            $em->flush();
        }

        return $this->redirectToRoute('cadastro_registrobackup_index');
    }

    /**
     * Creates a form to delete a RegistroBackup entity.
     *
     * @param RegistroBackup $registroBackup The RegistroBackup entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(RegistroBackup $registroBackup)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('cadastro_registrobackup_delete', array('id' => $registroBackup->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }

    /**
     * @param RegistroBackup $registrobackup
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("/view/log/{registrobackup}",name="view_log_registrobackup")
     */
    public function viewLogAction(RegistroBackup $registrobackup)
    {
        $logs = $this->getDoctrine()
                     ->getRepository('Gedmo:LogEntry')
                     ->getLogEntries($registrobackup);

        return $this->render('logentry/logentry.html.twig',array(
            'logs' => $logs
        ));
    }

}
