<?php

namespace MRS\InventarioBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use MRS\InventarioBundle\Entity\CentroMovimentacao;
use MRS\InventarioBundle\Form\CentroMovimentacaoType;

/**
 * CentroMovimentacao controller.
 *
 * @Route("/cadastro/centromovimentacao")
 */
class CentroMovimentacaoController extends Controller
{
    /**
     * Lists all CentroMovimentacao entities.
     *
     * @Route("/", name="cadastro_centromovimentacao_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $centroMovimentacaos = $em->getRepository('MRSInventarioBundle:CentroMovimentacao')
            ->findBy(array(),array('nome' => 'ASC'));

        return $this->render('centromovimentacao/index.html.twig', array(
            'centroMovimentacaos' => $centroMovimentacaos,
        ));
    }

    /**
     * Creates a new CentroMovimentacao entity.
     *
     * @Route("/new", name="cadastro_centromovimentacao_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $centroMovimentacao = new CentroMovimentacao();
        $form = $this->createForm('MRS\InventarioBundle\Form\CentroMovimentacaoType', $centroMovimentacao);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($centroMovimentacao);
            $em->flush();

            $this->addFlash('notice','Criado com sucesso!');

            return $this->redirectToRoute('cadastro_centromovimentacao_show', array('id' => $centroMovimentacao->getId()));
        }

        return $this->render('centromovimentacao/new.html.twig', array(
            'centroMovimentacao' => $centroMovimentacao,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a CentroMovimentacao entity.
     *
     * @Route("/{id}", name="cadastro_centromovimentacao_show")
     * @Method("GET")
     */
    public function showAction(CentroMovimentacao $centroMovimentacao)
    {
        $deleteForm = $this->createDeleteForm($centroMovimentacao);

        return $this->render('centromovimentacao/show.html.twig', array(
            'centroMovimentacao' => $centroMovimentacao,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing CentroMovimentacao entity.
     *
     * @Route("/{id}/edit", name="cadastro_centromovimentacao_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, CentroMovimentacao $centroMovimentacao)
    {
        $deleteForm = $this->createDeleteForm($centroMovimentacao);
        $editForm = $this->createForm('MRS\InventarioBundle\Form\CentroMovimentacaoType', $centroMovimentacao);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($centroMovimentacao);
            $em->flush();

            $this->addFlash('notice','Alterado com sucesso!');

            return $this->redirectToRoute('cadastro_centromovimentacao_show', array('id' => $centroMovimentacao->getId()));
        }

        return $this->render('centromovimentacao/edit.html.twig', array(
            'centroMovimentacao' => $centroMovimentacao,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a CentroMovimentacao entity.
     *
     * @Route("/{id}", name="cadastro_centromovimentacao_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, CentroMovimentacao $centroMovimentacao)
    {
        $form = $this->createDeleteForm($centroMovimentacao);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($centroMovimentacao);
            $em->flush();
        }

        return $this->redirectToRoute('cadastro_centromovimentacao_index');
    }

    /**
     * Creates a form to delete a CentroMovimentacao entity.
     *
     * @param CentroMovimentacao $centroMovimentacao The CentroMovimentacao entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(CentroMovimentacao $centroMovimentacao)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('cadastro_centromovimentacao_delete', array('id' => $centroMovimentacao->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
