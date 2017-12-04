<?php

namespace MRS\InventarioBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use MRS\InventarioBundle\Entity\Tipoequipamento;
use MRS\InventarioBundle\Form\TipoequipamentoType;

/**
 * Tipoequipamento controller.
 *
 * @Route("/cadastro/tipoequipamento")
 */
class TipoequipamentoController extends Controller
{
    /**
     * Lists all Tipoequipamento entities.
     *
     * @Route("/", name="cadastro_tipoequipamento_index")
     * @Method("GET|POST")
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $tipoequipamentos = $em->getRepository('MRSInventarioBundle:Tipoequipamento')
            ->getAllOrderByDescricao();

        $file = '';
        $posicao = '';
        if($request->files->get('file_csv')) {

            $file = $request->files->get('file_csv');

            $file = file($file);

            foreach($file as $item){

                $posicao = explode(',',$item);

                $tipoequipamento = new Tipoequipamento();

                $tipoequipamento->setDescricao($posicao['0']);

                $em->persist($tipoequipamento);
            }

            $em->flush();

            return $this->redirectToRoute('cadastro_tipoequipamento_index');
        }


        return $this->render('tipoequipamento/index.html.twig', array(
            'tipoequipamentos' => $tipoequipamentos,
        ));
    }

    /**
     * Creates a new Tipoequipamento entity.
     *
     * @Route("/new", name="cadastro_tipoequipamento_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $tipoequipamento = new Tipoequipamento();
        $form = $this->createForm('MRS\InventarioBundle\Form\TipoequipamentoType', $tipoequipamento);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($tipoequipamento);
            $em->flush();

            $this->addFlash('notice','Criado com sucesso!');

            return $this->redirectToRoute('cadastro_tipoequipamento_show', array('id' => $tipoequipamento->getId()));
        }

        return $this->render('tipoequipamento/new.html.twig', array(
            'tipoequipamento' => $tipoequipamento,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Tipoequipamento entity.
     *
     * @Route("/{id}", name="cadastro_tipoequipamento_show")
     * @Method("GET")
     */
    public function showAction(Tipoequipamento $tipoequipamento)
    {
        $deleteForm = $this->createDeleteForm($tipoequipamento);

        return $this->render('tipoequipamento/show.html.twig', array(
            'tipoequipamento' => $tipoequipamento,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Tipoequipamento entity.
     *
     * @Route("/{id}/edit", name="cadastro_tipoequipamento_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Tipoequipamento $tipoequipamento)
    {
        $deleteForm = $this->createDeleteForm($tipoequipamento);
        $editForm = $this->createForm('MRS\InventarioBundle\Form\TipoequipamentoType', $tipoequipamento);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($tipoequipamento);
            $em->flush();

            $this->addFlash('notice','Alterado com sucesso!');

            return $this->redirectToRoute('cadastro_tipoequipamento_show', array('id' => $tipoequipamento->getId()));
        }

        return $this->render('tipoequipamento/edit.html.twig', array(
            'tipoequipamento' => $tipoequipamento,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Tipoequipamento entity.
     *
     * @Route("/{id}", name="cadastro_tipoequipamento_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Tipoequipamento $tipoequipamento)
    {
        $form = $this->createDeleteForm($tipoequipamento);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($tipoequipamento);
            $em->flush();
        }

        return $this->redirectToRoute('cadastro_tipoequipamento_index');
    }

    /**
     * Creates a form to delete a Tipoequipamento entity.
     *
     * @param Tipoequipamento $tipoequipamento The Tipoequipamento entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Tipoequipamento $tipoequipamento)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('cadastro_tipoequipamento_delete', array('id' => $tipoequipamento->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
