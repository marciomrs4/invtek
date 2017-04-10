<?php

namespace MRS\BackupBundle\Controller;

use MRS\BackupBundle\Entity\RegistroBackup;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use MRS\BackupBundle\Entity\RegistroBackupEquipamento;
use MRS\BackupBundle\Form\RegistroBackupEquipamentoType;

/**
 * RegistroBackupEquipamento controller.
 *
 * @Route("/cadastro/regitrobackupequipamento")
 */
class RegistroBackupEquipamentoController extends Controller
{
    /**
     * Lists all RegistroBackupEquipamento entities.
     *
     * @Route("/{registrobackup}", name="cadastro_regitrobackupequipamento_index")
     * @Method("GET")
     */
    public function indexAction(RegistroBackup $registrobackup)
    {
        $em = $this->getDoctrine()->getManager();

        $registroBackupEquipamentos = $em->getRepository('MRSBackupBundle:RegistroBackupEquipamento')
            ->findBy(array('registroBackupId' => $registrobackup),array('id' => 'DESC'));

        return $this->render('registrobackupequipamento/index.html.twig', array(
            'registroBackupEquipamentos' => $registroBackupEquipamentos,
        ));
    }

    /**
     * Creates a new RegistroBackupEquipamento entity.
     *
     * @Route("/new", name="cadastro_regitrobackupequipamento_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $registroBackupEquipamento = new RegistroBackupEquipamento();
        $form = $this->createForm('MRS\BackupBundle\Form\RegistroBackupEquipamentoType', $registroBackupEquipamento);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($registroBackupEquipamento);
            $em->flush();

            $this->addFlash('notice','Criado com sucesso!');

            return $this->redirectToRoute('cadastro_regitrobackupequipamento_show', array('id' => $registroBackupEquipamento->getId()));
        }

        return $this->render('registrobackupequipamento/new.html.twig', array(
            'registroBackupEquipamento' => $registroBackupEquipamento,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a RegistroBackupEquipamento entity.
     *
     * @Route("/{id}", name="cadastro_regitrobackupequipamento_show")
     * @Method("GET")
     */
    public function showAction(RegistroBackupEquipamento $registroBackupEquipamento)
    {
        $deleteForm = $this->createDeleteForm($registroBackupEquipamento);

        return $this->render('registrobackupequipamento/show.html.twig', array(
            'registroBackupEquipamento' => $registroBackupEquipamento,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing RegistroBackupEquipamento entity.
     *
     * @Route("/{id}/edit", name="cadastro_regitrobackupequipamento_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, RegistroBackupEquipamento $registroBackupEquipamento)
    {
        $deleteForm = $this->createDeleteForm($registroBackupEquipamento);
        $editForm = $this->createForm('MRS\BackupBundle\Form\RegistroBackupEquipamentoType', $registroBackupEquipamento);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($registroBackupEquipamento);
            $em->flush();

            $this->addFlash('notice','Alterado com sucesso!');

            return $this->redirectToRoute('cadastro_regitrobackupequipamento_show', array('id' => $registroBackupEquipamento->getId()));
        }

        return $this->render('registrobackupequipamento/edit.html.twig', array(
            'registroBackupEquipamento' => $registroBackupEquipamento,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a RegistroBackupEquipamento entity.
     *
     * @Route("/{id}", name="cadastro_regitrobackupequipamento_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, RegistroBackupEquipamento $registroBackupEquipamento)
    {
        $form = $this->createDeleteForm($registroBackupEquipamento);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($registroBackupEquipamento);
            $em->flush();
        }

        return $this->redirectToRoute('cadastro_regitrobackupequipamento_index');
    }

    /**
     * Creates a form to delete a RegistroBackupEquipamento entity.
     *
     * @param RegistroBackupEquipamento $registroBackupEquipamento The RegistroBackupEquipamento entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(RegistroBackupEquipamento $registroBackupEquipamento)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('cadastro_regitrobackupequipamento_delete', array('id' => $registroBackupEquipamento->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
