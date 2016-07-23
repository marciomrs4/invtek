<?php

namespace MRS\InventarioBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use MRS\InventarioBundle\Entity\Tipoacompanhamento;
use MRS\InventarioBundle\Form\TipoacompanhamentoType;

/**
 * Tipoacompanhamento controller.
 *
 * @Route("/cadastro/tipoacompanhamento")
 */
class TipoacompanhamentoController extends Controller
{
    /**
     * Lists all Tipoacompanhamento entities.
     *
     * @Route("/", name="cadastro_tipoacompanhamento_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $tipoacompanhamentos = $em->getRepository('MRSInventarioBundle:Tipoacompanhamento')->findAll();

        return $this->render('tipoacompanhamento/index.html.twig', array(
            'tipoacompanhamentos' => $tipoacompanhamentos,
        ));
    }

    /**
     * Creates a new Tipoacompanhamento entity.
     *
     * @Route("/new", name="cadastro_tipoacompanhamento_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $tipoacompanhamento = new Tipoacompanhamento();
        $form = $this->createForm('MRS\InventarioBundle\Form\TipoacompanhamentoType', $tipoacompanhamento);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($tipoacompanhamento);
            $em->flush();

            $this->addFlash('notice','Criado com sucesso!');

            return $this->redirectToRoute('cadastro_tipoacompanhamento_index');
        }

        return $this->render('tipoacompanhamento/new.html.twig', array(
            'tipoacompanhamento' => $tipoacompanhamento,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Tipoacompanhamento entity.
     *
     * @Route("/{id}", name="cadastro_tipoacompanhamento_show")
     * @Method("GET")
     */
    public function showAction(Tipoacompanhamento $tipoacompanhamento)
    {
        $deleteForm = $this->createDeleteForm($tipoacompanhamento);

        return $this->render('tipoacompanhamento/show.html.twig', array(
            'tipoacompanhamento' => $tipoacompanhamento,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Tipoacompanhamento entity.
     *
     * @Route("/{id}/edit", name="cadastro_tipoacompanhamento_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Tipoacompanhamento $tipoacompanhamento)
    {
        $deleteForm = $this->createDeleteForm($tipoacompanhamento);
        $editForm = $this->createForm('MRS\InventarioBundle\Form\TipoacompanhamentoType', $tipoacompanhamento);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($tipoacompanhamento);
            $em->flush();

            $this->addFlash('notice','Alterado com sucesso!');

            return $this->redirectToRoute('cadastro_tipoacompanhamento_show', array('id' => $tipoacompanhamento->getId()));
        }

        return $this->render('tipoacompanhamento/edit.html.twig', array(
            'tipoacompanhamento' => $tipoacompanhamento,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Tipoacompanhamento entity.
     *
     * @Route("/{id}", name="cadastro_tipoacompanhamento_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Tipoacompanhamento $tipoacompanhamento)
    {
        $form = $this->createDeleteForm($tipoacompanhamento);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($tipoacompanhamento);
            $em->flush();
        }

        return $this->redirectToRoute('cadastro_tipoacompanhamento_index');
    }

    /**
     * Creates a form to delete a Tipoacompanhamento entity.
     *
     * @param Tipoacompanhamento $tipoacompanhamento The Tipoacompanhamento entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Tipoacompanhamento $tipoacompanhamento)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('cadastro_tipoacompanhamento_delete', array('id' => $tipoacompanhamento->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
