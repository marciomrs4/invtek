<?php

namespace MRS\BackupBundle\Controller;

use MRS\InventarioBundle\Entity\Unidade;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use MRS\BackupBundle\Entity\Job;
use MRS\BackupBundle\Form\JobType;

/**
 * Job controller.
 *
 * @Route("/cadastro/job")
 */
class JobController extends Controller
{
    /**
     * Lists all Job entities.
     *
     * @Route("/", name="cadastro_job_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $jobs = $em->getRepository('MRSBackupBundle:Job')
                   ->findBy(array(),array('unidade' => 'ASC',
                                          'descricao' => 'ASC'));

        return $this->render('job/index.html.twig', array(
            'jobs' => $jobs,
        ));
    }

    /**
     * Creates a new Job entity.
     *
     * @Route("/new", name="cadastro_job_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $job = new Job();
        $form = $this->createForm('MRS\BackupBundle\Form\JobType', $job);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($job);
            $em->flush();

            $this->addFlash('notice','Criado com sucesso!');

            return $this->redirectToRoute('cadastro_job_show', array('id' => $job->getId()));
        }

        return $this->render('job/new.html.twig', array(
            'job' => $job,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Job entity.
     *
     * @Route("/{id}", name="cadastro_job_show")
     * @Method("GET")
     */
    public function showAction(Job $job)
    {
        $deleteForm = $this->createDeleteForm($job);

        return $this->render('job/show.html.twig', array(
            'job' => $job,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Job entity.
     *
     * @Route("/{id}/edit", name="cadastro_job_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Job $job)
    {
        $deleteForm = $this->createDeleteForm($job);
        $editForm = $this->createForm('MRS\BackupBundle\Form\JobType', $job);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($job);
            $em->flush();

            $this->addFlash('notice','Alterado com sucesso!');

            return $this->redirectToRoute('cadastro_job_show', array('id' => $job->getId()));
        }

        return $this->render('job/edit.html.twig', array(
            'job' => $job,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Job entity.
     *
     * @Route("/{id}", name="cadastro_job_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Job $job)
    {
        $form = $this->createDeleteForm($job);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            try {
                $em = $this->getDoctrine()->getManager();
                $em->remove($job);
                $em->flush();
            }catch(\Exception $e){

                $menssage = ['tipo_message' => 'danger',
                             'message' => 'Não é possivel remover este item!'];

                $this->addFlash('notice', $menssage);

                return $this->redirectToRoute('cadastro_job_edit', array('id' => $job->getId()));
            }
        }

        return $this->redirectToRoute('cadastro_job_index');
    }

    /**
     * Creates a form to delete a Job entity.
     *
     * @param Job $job The Job entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Job $job)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('cadastro_job_delete', array('id' => $job->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }

    /**
     * @Route("/view/log/{job}",name="view_log_job")
     */
    public function viewLogAction(Job $job)
    {
        $gedmo = $this->getDoctrine()->getRepository('Gedmo:LogEntry');

        $logs = $gedmo->getLogEntries($job);

        return $this->render('logentry/logentry.html.twig',array(
            'logs' => $logs
        ));

    }

    /**
     * @Route("/json/list/{unidade}",name="job_list_by_unidade")
     * @Method("GET")
     */
    public function jobListByUnidadeAction(Unidade $unidade = null)
    {
        $data = $this->getDoctrine()->getRepository('MRSBackupBundle:Job')
                     ->getJobByUnidade($unidade);

        return new JsonResponse($data);

    }
}
