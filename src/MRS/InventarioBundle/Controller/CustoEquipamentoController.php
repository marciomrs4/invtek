<?php

namespace MRS\InventarioBundle\Controller;

use MRS\InventarioBundle\Entity\Equipamento;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use MRS\InventarioBundle\Entity\CustoEquipamento;
use MRS\InventarioBundle\Form\CustoEquipamentoType;

/**
 * CustoEquipamento controller.
 *
 * @Route("/cadastro/custoequipamento")
 */
class CustoEquipamentoController extends Controller
{
    /**
     * Lists all CustoEquipamento entities.
     *
     * @Route("/{equipamento}", name="cadastro_custoequipamento_index")
     * @Method("GET")
     */
    public function indexAction(Equipamento $equipamento)
    {
        $er = $this->getDoctrine()->getManager()
            ->getRepository('MRSInventarioBundle:CustoEquipamento');

        $custoEquipamentos = $er->findBy(array('equipamento' => $equipamento),
                                         array('data_criacao'=>'DESC'));

        $custo = $er->countTotalCusto($equipamento);


        return $this->render('custoequipamento/index.html.twig', array(
            'custoEquipamentos' => $custoEquipamentos,
            'custo' => $custo,
            'equipamento'=>$equipamento
        ));
    }

    /**
     * Creates a new CustoEquipamento entity.
     *
     * @Route("/new/{equipamento}", name="cadastro_custoequipamento_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Equipamento $equipamento, Request $request)
    {
        $custoEquipamento = new CustoEquipamento();

        $custoEquipamento->setEquipamento($equipamento);
        $custoEquipamento->setUsuario($this->getUser()->getUsuario());

        $form = $this->createForm('MRS\InventarioBundle\Form\CustoEquipamentoType', $custoEquipamento);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($custoEquipamento);
            $em->flush();

            $this->addFlash('notice','Criado com sucesso!');

            return $this->redirectToRoute('cadastro_custoequipamento_show', array('id' => $custoEquipamento->getId()));
        }

        return $this->render('custoequipamento/new.html.twig', array(
            'custoEquipamento' => $custoEquipamento,
            'equipamento' => $equipamento,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a CustoEquipamento entity.
     *
     * @Route("/{id}/show", name="cadastro_custoequipamento_show")
     * @Method("GET")
     */
    public function showAction(CustoEquipamento $custoEquipamento)
    {
        return $this->render('custoequipamento/show.html.twig', array(
            'custoEquipamento' => $custoEquipamento,
        ));
    }

    /**
     * Displays a form to edit an existing CustoEquipamento entity.
     *
     * @Route("/{id}/edit", name="cadastro_custoequipamento_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, CustoEquipamento $custoEquipamento)
    {
        $deleteForm = $this->createDeleteForm($custoEquipamento);
        $editForm = $this->createForm('MRS\InventarioBundle\Form\CustoEquipamentoType', $custoEquipamento);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($custoEquipamento);
            $em->flush();

            $this->addFlash('notice','Alterado com sucesso!');

            return $this->redirectToRoute('cadastro_custoequipamento_show', array('id' => $custoEquipamento->getId()));
        }

        return $this->render('custoequipamento/edit.html.twig', array(
            'custoEquipamento' => $custoEquipamento,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a CustoEquipamento entity.
     *
     * @Route("/{id}", name="cadastro_custoequipamento_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, CustoEquipamento $custoEquipamento)
    {
        $form = $this->createDeleteForm($custoEquipamento);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($custoEquipamento);
            $em->flush();
        }

        return $this->redirectToRoute('cadastro_custoequipamento_index');
    }

    /**
     * Creates a form to delete a CustoEquipamento entity.
     *
     * @param CustoEquipamento $custoEquipamento The CustoEquipamento entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(CustoEquipamento $custoEquipamento)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('cadastro_custoequipamento_delete', array('id' => $custoEquipamento->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
