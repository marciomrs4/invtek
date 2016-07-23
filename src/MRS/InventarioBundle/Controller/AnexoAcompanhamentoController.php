<?php

namespace MRS\InventarioBundle\Controller;

use MRS\InventarioBundle\Entity\Acompanhamento;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use MRS\InventarioBundle\Entity\AnexoAcompanhamento;
use MRS\InventarioBundle\Form\AnexoAcompanhamentoType;

/**
 * AnexoAcompanhamento controller.
 *
 * @Route("/cadastro/anexoacompanhamento")
 */
class AnexoAcompanhamentoController extends Controller
{
    /**
     * Lists all AnexoAcompanhamento entities.
     *
     * @Route("/{acompanhamento}", name="cadastro_anexoacompanhamento_index")
     * @Method("GET")
     */
    public function indexAction(Acompanhamento $acompanhamento)
    {
        $em = $this->getDoctrine()->getManager();

        $anexoAcompanhamentos = $em->getRepository('MRSInventarioBundle:AnexoAcompanhamento')
            ->findBy(array('acompanhamento'=>$acompanhamento));

        return $this->render('anexoacompanhamento/index.html.twig', array(
            'anexoAcompanhamentos' => $anexoAcompanhamentos,
            'acompanhamento' => $acompanhamento
        ));
    }

    /**
     * Creates a new AnexoAcompanhamento entity.
     *
     * @Route("/new/{acompanhamento}", name="cadastro_anexoacompanhamento_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request, Acompanhamento $acompanhamento)
    {
        $anexoAcompanhamento = new AnexoAcompanhamento();

        $anexoAcompanhamento->setAcompanhamento($acompanhamento);

        $form = $this->createForm('MRS\InventarioBundle\Form\AnexoAcompanhamentoType', $anexoAcompanhamento);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($anexoAcompanhamento);
            $em->flush();

            $this->addFlash('notice','Criado com sucesso!');

            return $this->redirectToRoute('cadastro_anexoacompanhamento_show', array(
                'id' => $anexoAcompanhamento->getId()));
        }

        return $this->render('anexoacompanhamento/new.html.twig', array(
            'anexoAcompanhamento' => $anexoAcompanhamento,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a AnexoAcompanhamento entity.
     *
     * @Route("/show/{id}", name="cadastro_anexoacompanhamento_show")
     * @Method("GET")
     */
    public function showAction(AnexoAcompanhamento $anexoAcompanhamento)
    {
        $deleteForm = $this->createDeleteForm($anexoAcompanhamento);

        return $this->render('anexoacompanhamento/show.html.twig', array(
            'anexoAcompanhamento' => $anexoAcompanhamento,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing AnexoAcompanhamento entity.
     *
     * @Route("/{id}/edit", name="cadastro_anexoacompanhamento_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, AnexoAcompanhamento $anexoAcompanhamento)
    {
        $deleteForm = $this->createDeleteForm($anexoAcompanhamento);
        $editForm = $this->createForm('MRS\InventarioBundle\Form\AnexoAcompanhamentoType', $anexoAcompanhamento);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($anexoAcompanhamento);
            $em->flush();

            $this->addFlash('notice','Alterado com sucesso!');

            return $this->redirectToRoute('cadastro_anexoacompanhamento_show', array('id' => $anexoAcompanhamento->getId()));
        }

        return $this->render('anexoacompanhamento/edit.html.twig', array(
            'anexoAcompanhamento' => $anexoAcompanhamento,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a AnexoAcompanhamento entity.
     *
     * @Route("/{id}", name="cadastro_anexoacompanhamento_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, AnexoAcompanhamento $anexoAcompanhamento)
    {
        $form = $this->createDeleteForm($anexoAcompanhamento);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($anexoAcompanhamento);
            $em->flush();
        }

        return $this->redirectToRoute('cadastro_anexoacompanhamento_index');
    }

    /**
     * Creates a form to delete a AnexoAcompanhamento entity.
     *
     * @param AnexoAcompanhamento $anexoAcompanhamento The AnexoAcompanhamento entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(AnexoAcompanhamento $anexoAcompanhamento)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('cadastro_anexoacompanhamento_delete', array('id' => $anexoAcompanhamento->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
