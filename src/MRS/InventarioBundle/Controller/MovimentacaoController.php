<?php

namespace MRS\InventarioBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use MRS\InventarioBundle\Entity\Movimentacao;
use MRS\InventarioBundle\Form\MovimentacaoType;

/**
 * Movimentacao controller.
 *
 * @Route("/movimentacao")
 */
class MovimentacaoController extends Controller
{
    /**
     * Lists all Movimentacao entities.
     *
     * @Route("/", name="movimentacao_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $movimentacaos = $em->getRepository('MRSInventarioBundle:Movimentacao')->findAll();

        return $this->render('movimentacao/index.html.twig', array(
            'movimentacaos' => $movimentacaos,
        ));
    }

    /**
     * Creates a new Movimentacao entity.
     *
     * @Route("/new", name="movimentacao_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $movimentacao = new Movimentacao();

        $form = $this->createForm('MRS\InventarioBundle\Form\MovimentacaoType', $movimentacao);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();

            $movimentacao->setUsuarioCriador($this->getUser()->getUsuario())
                         ->setStatus(false);

            $em->persist($movimentacao);
            $em->flush();

            $this->addFlash('notice','Criado com sucesso!');

            return $this->redirectToRoute('movimentacao_show', array('id' => $movimentacao->getId()));
        }

        return $this->render('movimentacao/new.html.twig', array(
            'movimentacao' => $movimentacao,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Movimentacao entity.
     *
     * @Route("/{id}", name="movimentacao_show")
     * @Method("GET")
     */
    public function showAction(Movimentacao $movimentacao)
    {
        $deleteForm = $this->createDeleteForm($movimentacao);

        $itensMovimentacao = $this->getDoctrine()
            ->getRepository('MRSInventarioBundle:ItensMovimentacao')
            ->findBy(array('movimentacao'=>$movimentacao));

        return $this->render('movimentacao/show.html.twig', array(
            'movimentacao' => $movimentacao,
            'itensMovimentacao' => $itensMovimentacao,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Movimentacao entity.
     *
     * @Route("/{id}/edit", name="movimentacao_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Movimentacao $movimentacao)
    {
        $itensMovimentacao = $this->getDoctrine()
                    ->getRepository('MRSInventarioBundle:ItensMovimentacao')
                    ->findBy(array('movimentacao'=>$movimentacao));

        if($itensMovimentacao){

            $this->addFlash('notice','Não é possivel alterar, pois já existem iten(s) associado!');
            return $this->redirectToRoute('movimentacao_show',array('id'=>$movimentacao));
        }

        $deleteForm = $this->createDeleteForm($movimentacao);
        $editForm = $this->createForm('MRS\InventarioBundle\Form\MovimentacaoType', $movimentacao);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($movimentacao);
            $em->flush();

            $this->addFlash('notice','Alterado com sucesso!');

            return $this->redirectToRoute('movimentacao_show', array('id' => $movimentacao->getId()));
        }

        return $this->render('movimentacao/edit.html.twig', array(
            'movimentacao' => $movimentacao,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Movimentacao entity.
     *
     * @Route("/{id}/createmove", name="movimentacao_createmove")
     * @Method({"GET", "POST"})
     */
    public function createMoveAction(Request $request, Movimentacao $movimentacao)
    {

        if($movimentacao) {

            $em = $this->getDoctrine()->getManager();

            $movimentacao->setStatus(true);

            $itensMovimentacao = $this->getDoctrine()->getRepository('MRSInventarioBundle:ItensMovimentacao')
                ->findBy(array('movimentacao'=>$movimentacao));

            $centroMovimentacaoDestino = $movimentacao->getUsuarioDestino()->getDepartamento();

            foreach($itensMovimentacao as $item){

                $idEquipamento = $item->getEquipamento()->getId();

                $equipamento = $this->getDoctrine()->getRepository('MRSInventarioBundle:Equipamento')
                    ->find($idEquipamento);

                $equipamento->setCentroMovimentacao($centroMovimentacaoDestino);

                $em->persist($equipamento);
                $em->flush();

            }



            $em->persist($movimentacao);
            $em->flush();


            $this->addFlash('notice','Movimentação Efetuada com sucesso!');

            return $this->redirectToRoute('movimentacao_show', array('id' => $movimentacao->getId()));

        }

        $this->addFlash('notice','Movimentação Efetuada com sucesso!');

        return $this->redirectToRoute('movimentacao_show', array('id' => $movimentacao->getId()));

    }


    /**
     * Deletes a Movimentacao entity.
     *
     * @Route("/{id}", name="movimentacao_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Movimentacao $movimentacao)
    {
        $form = $this->createDeleteForm($movimentacao);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($movimentacao);
            $em->flush();
        }

        return $this->redirectToRoute('movimentacao_index');
    }

    /**
     * Creates a form to delete a Movimentacao entity.
     *
     * @param Movimentacao $movimentacao The Movimentacao entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Movimentacao $movimentacao)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('movimentacao_delete', array('id' => $movimentacao->getId())))
            ->setMethod('DELETE')
            ->getForm()
            ;
    }
}
