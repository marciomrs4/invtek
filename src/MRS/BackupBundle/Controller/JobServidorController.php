<?php

namespace MRS\BackupBundle\Controller;

use Doctrine\ORM\EntityRepository;
use MRS\BackupBundle\Entity\Job;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use MRS\BackupBundle\Entity\JobServidor;
use MRS\BackupBundle\Form\JobServidorType;

/**
 * JobServidor controller.
 *
 * @Route("/cadastro/jobservidor")
 */
class JobServidorController extends Controller
{
    /**
     * Lists all JobServidor entities.
     *
     * @Route("/{job}", name="cadastro_jobservidor_index")
     * @Method("GET")
     */
    public function indexAction(Job $job)
    {
        $em = $this->getDoctrine()->getManager();

        $jobServidors = $em->getRepository('MRSBackupBundle:JobServidor')
            ->findBy(array('job' => $job));

        return $this->render('jobservidor/index.html.twig', array(
            'jobServidors' => $jobServidors,
        ));
    }

    /**
     * Creates a new JobServidor entity.
     *
     * @Route("/new/{job}", name="cadastro_jobservidor_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request, Job $job)
    {
        $jobServidor = new JobServidor();
        $jobServidor->setJob($job);

        $em = $this->getDoctrine()->getManager();

        $form = $this->createForm('MRS\BackupBundle\Form\JobServidorType', $jobServidor);

        $centros = $em->getRepository('MRSInventarioBundle:CentroMovimentacao')
            ->findBy(array('unidade' => $job->getUnidade()));

        $jobs = $em->getRepository('MRSBackupBundle:JobServidor')
                   ->findBy(array('job' => $job));


        $centroMovimentacao = '';
        foreach($centros as $centroEquipamento){
            $centroMovimentacao[] = $centroEquipamento->getId();
        }

        $equipamento = '';
        foreach($jobs as $jobEquipamento){
            $equipamento[] = $jobEquipamento->getEquipamento()->getId();
        }

        $tipoEquipamento = $this->getParameter('tiposequipamentos');

        $form->add('equipamento',EntityType::class,array('label'=>'Equipamento',
        'class' => 'MRS\InventarioBundle\Entity\Equipamento',
        'query_builder' => function(EntityRepository $er) use ($tipoEquipamento, $equipamento, $centroMovimentacao){
            return $er->createQueryBuilder('E')
                ->where('E.tipoequipamento IN (:tipoequipamento)')
                ->andWhere('E.id NOT IN (:equipamento)')
                ->andWhere('E.centroMovimentacao IN (:centromovimentacao)')
                ->setParameters(array('tipoequipamento' => $tipoEquipamento,
                                      'equipamento' => $equipamento,
                                      'centromovimentacao' => $centroMovimentacao))
                ->orderBy('E.descricao');

        },
        'attr'=>array('class'=>'input-sm')));

        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()) {

            $em->persist($jobServidor);
            $em->flush();

            $this->addFlash('notice','Criado com sucesso!');

            return $this->redirectToRoute('cadastro_job_show', array('id' => $job->getId()));
        }

        return $this->render('jobservidor/new.html.twig', array(
            'jobServidor' => $jobServidor,
            'job' => $job,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a JobServidor entity.
     *
     * @Route("/{id}", name="cadastro_jobservidor_show")
     * @Method("GET")
     */
    public function showAction(JobServidor $jobServidor)
    {
        $deleteForm = $this->createDeleteForm($jobServidor);

        return $this->render('jobservidor/show.html.twig', array(
            'jobServidor' => $jobServidor,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing JobServidor entity.
     *
     * @Route("/{id}/edit", name="cadastro_jobservidor_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, JobServidor $jobServidor)
    {
        $deleteForm = $this->createDeleteForm($jobServidor);
        $editForm = $this->createForm('MRS\BackupBundle\Form\JobServidorType', $jobServidor);

        $em = $this->getDoctrine()->getManager();

        $job = $jobServidor->getJob();

        $jobs = $em->getRepository('MRSBackupBundle:JobServidor')
            ->findBy(array('job' => $job));

        $centros = $em->getRepository('MRSInventarioBundle:CentroMovimentacao')
            ->findBy(array('unidade' => $job->getUnidade()));

        $centroMovimentacao = '';
        foreach($centros as $centroEquipamento){
            $centroMovimentacao[] = $centroEquipamento->getId();
        }

        $id = $jobServidor->getEquipamento()->getId();

        $equipamento = '';
        foreach($jobs as $jobEquipamento){
            $equipamento[] = $jobEquipamento->getEquipamento()->getId();

        }

        $tipoEquipamento = $this->getParameter('tiposequipamentos');


        $editForm->add('equipamento',EntityType::class,array('label'=>'Equipamento',
            'class' => 'MRS\InventarioBundle\Entity\Equipamento',
            'query_builder' => function(EntityRepository $er) use ($tipoEquipamento, $equipamento, $centroMovimentacao, $id){
                return $er->createQueryBuilder('E')
                    ->where('E.tipoequipamento IN (:tipoequipamento)')
                    ->andWhere('E.id NOT IN (:equipamento) OR E.id = :id')
                    ->andWhere('E.centroMovimentacao IN (:centromovimentacao)')
                    ->setParameters(array('tipoequipamento' => $tipoEquipamento,
                                          'id' => $id,
                                          'equipamento' => $equipamento,
                                          'centromovimentacao' => $centroMovimentacao))
                    ->orderBy('E.descricao');

            },
            'attr'=>array('class'=>'input-sm')));


        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em->persist($jobServidor);
            $em->flush();

            $this->addFlash('notice','Alterado com sucesso!');

            return $this->redirectToRoute('cadastro_job_show', array('id' => $jobServidor->getJob()->getId()));
        }

        return $this->render('jobservidor/edit.html.twig', array(
            'jobServidor' => $jobServidor,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a JobServidor entity.
     *
     * @Route("/{id}", name="cadastro_jobservidor_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, JobServidor $jobServidor)
    {
        $job = $jobServidor->getJob()->getId();

        $form = $this->createDeleteForm($jobServidor);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            try {
                $em = $this->getDoctrine()->getManager();
                $em->remove($jobServidor);
                $em->flush();
            }catch(\Exception $e){

                $this->addFlash('notice','Criado com sucesso!');

                return $this->redirectToRoute('cadastro_job_show', array('id' => $jobServidor->getJob()->getId()));
            }
        }

        return $this->redirectToRoute('cadastro_job_show',array('id' => $job));
    }

    /**
     * Creates a form to delete a JobServidor entity.
     *
     * @param JobServidor $jobServidor The JobServidor entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(JobServidor $jobServidor)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('cadastro_jobservidor_delete', array('id' => $jobServidor->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
