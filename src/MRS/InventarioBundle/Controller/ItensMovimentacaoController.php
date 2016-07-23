<?php

namespace MRS\InventarioBundle\Controller;

use MRS\InventarioBundle\Entity\Movimentacao;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use MRS\InventarioBundle\Entity\ItensMovimentacao;
use MRS\InventarioBundle\Form\ItensMovimentacaoType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Doctrine\ORM\EntityRepository;

/**
 * ItensMovimentacao controller.
 *
 * @Route("/cadastro/itensmovimentacao")
 */
class ItensMovimentacaoController extends Controller
{
    /**
     * Lists all ItensMovimentacao entities.
     *
     * @Route("/{movimentacao}", name="cadastro_itensmovimentacao_index")
     * @Method("GET")
     */
    public function indexAction(Movimentacao $movimentacao)
    {
        $em = $this->getDoctrine()->getManager();

        $itensMovimentacaos = $em->getRepository('MRSInventarioBundle:ItensMovimentacao')
            ->findBy(array('movimentacao'=>$movimentacao));

        return $this->render('itensmovimentacao/index.html.twig', array(
            'itensMovimentacaos' => $itensMovimentacaos,
            'movimentacao' => $movimentacao
        ));
    }

    /**
     * Creates a new ItensMovimentacao entity.
     *
     * @Route("/new/{movimentacao}", name="cadastro_itensmovimentacao_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request, Movimentacao $movimentacao)
    {
        if($movimentacao->getStatus()){

            $this->addFlash('notice','Essa movimentação já está finalizado!');
            return $this->redirectToRoute('movimentacao_show',array(
                'id'=>$movimentacao->getId()));

        }

        $itensMovimentacao = new ItensMovimentacao();

        $itensMovimentacao->setMovimentacao($movimentacao);

        $departamentoId = $movimentacao->getUsuarioOrigem()->getDepartamento()->getId();

        $movimentacao = $this->getDoctrine()->getRepository('MRSInventarioBundle:Movimentacao')
            ->findBy(array('status'=>false));

        $itens = $this->getDoctrine()->getRepository('MRSInventarioBundle:ItensMovimentacao')
            ->findBy(array('movimentacao'=>$movimentacao));

        $itensId[] = ($itens == null) ? 'null' : $itens;

        foreach($itens as $iten){

            $itensId[] = $iten->getEquipamento()->getId();

        }


        $form = $this->createForm('MRS\InventarioBundle\Form\ItensMovimentacaoType', $itensMovimentacao);

        $form->add('equipamento',EntityType::class,array('label'=>'Equipamento',
            'attr'=>array('class'=>'input-sm'),
            'class'=>'MRS\InventarioBundle\Entity\Equipamento',
            'query_builder' => function(EntityRepository $er)use($departamentoId,$itensId) {

                return $er->createQueryBuilder('e')
                    ->join('e.centroMovimentacao', 'cm')
                    ->where('e.centroMovimentacao = :centro')
                    ->andWhere('e.id NOT IN (:equipamento)')
                    ->setParameter('centro', $departamentoId)
                    ->setParameter('equipamento',$itensId)
                    ->orderBy('e.tipoequipamento');
            }));



        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($itensMovimentacao);
            $em->flush();

            $this->addFlash('notice','Adicionado o Equipamento!');

            return $this->redirectToRoute('movimentacao_show', array('id' => $itensMovimentacao->getMovimentacao()->getId()));
        }

        return $this->render('itensmovimentacao/new.html.twig', array(
            'itensMovimentacao' => $itensMovimentacao,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a ItensMovimentacao entity.
     *
     * @Route("/{id}", name="cadastro_itensmovimentacao_show")
     * @Method("GET")
     */
    public function showAction(ItensMovimentacao $itensMovimentacao)
    {
        $deleteForm = $this->createDeleteForm($itensMovimentacao);

        return $this->render('itensmovimentacao/show.html.twig', array(
            'itensMovimentacao' => $itensMovimentacao,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing ItensMovimentacao entity.
     *
     * @Route("/{id}/edit", name="cadastro_itensmovimentacao_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, ItensMovimentacao $itensMovimentacao)
    {

        if($itensMovimentacao->getMovimentacao()->getStatus()){

            $this->addFlash('notice','Essa movimentação já está finalizado!');
            return $this->redirectToRoute('movimentacao_show',array(
                'id'=>$itensMovimentacao->getMovimentacao()->getId()));

        }

        $deleteForm = $this->createDeleteForm($itensMovimentacao);
        $editForm = $this->createForm('MRS\InventarioBundle\Form\ItensMovimentacaoType', $itensMovimentacao);

        $departamentoId = $itensMovimentacao->getMovimentacao()->getUsuarioOrigem()->getDepartamento();

        $equipamentoId = $itensMovimentacao->getEquipamento()->getId();

        $movimentacao = $this->getDoctrine()->getRepository('MRSInventarioBundle:Movimentacao')
            ->findBy(array('status'=>false));

        $itens = $this->getDoctrine()->getRepository('MRSInventarioBundle:ItensMovimentacao')
            ->findBy(array('movimentacao'=>$movimentacao));

        $itensId[] = ($itens == null) ? 'null' : $itens;

        foreach($itens as $iten){

            $itensId[] = $iten->getEquipamento()->getId();

        }

        $editForm->add('equipamento',EntityType::class,array('label'=>'Equipamento',
            'attr'=>array('class'=>'input-sm'),
            'class'=>'MRS\InventarioBundle\Entity\Equipamento',
            'query_builder' => function(EntityRepository $er)use($departamentoId, $equipamentoId, $itensId) {

                return $er->createQueryBuilder('e')
                    ->join('e.centroMovimentacao', 'cm')
                    ->where('e.centroMovimentacao = :centro')
                    ->andWhere('e.id = :equipamento OR e.id NOT IN(:itens)')
                    ->setParameter('centro',$departamentoId)
                    ->setParameter('equipamento',$equipamentoId)
                    ->setParameter('itens',$itensId)
                    ->orderBy('e.tipoequipamento');
            }));


        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($itensMovimentacao);
            $em->flush();

            $this->addFlash('notice','Alterado o item com sucesso!');

            return $this->redirectToRoute('movimentacao_show', array('id' => $itensMovimentacao->getMovimentacao()->getId()));
        }

        return $this->render('itensmovimentacao/edit.html.twig', array(
            'itensMovimentacao' => $itensMovimentacao,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a ItensMovimentacao entity.
     *
     * @Route("/{id}", name="cadastro_itensmovimentacao_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, ItensMovimentacao $itensMovimentacao)
    {
        $movimentacaoId = $itensMovimentacao->getMovimentacao()->getId();

        $form = $this->createDeleteForm($itensMovimentacao);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($itensMovimentacao);
            $em->flush();
        }

        $this->addFlash('notice','Removido o Equipamento com sucesso!');

        return $this->redirectToRoute('movimentacao_show',array('id' => $movimentacaoId));
    }

    /**
     * Creates a form to delete a ItensMovimentacao entity.
     *
     * @param ItensMovimentacao $itensMovimentacao The ItensMovimentacao entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(ItensMovimentacao $itensMovimentacao)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('cadastro_itensmovimentacao_delete', array('id' => $itensMovimentacao->getId())))
            ->setMethod('DELETE')
            ->getForm()
            ;
    }
}
