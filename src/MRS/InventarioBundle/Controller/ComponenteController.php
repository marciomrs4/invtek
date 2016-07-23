<?php

namespace MRS\InventarioBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use MRS\InventarioBundle\Entity\Componente;
use MRS\InventarioBundle\Form\ComponenteType;

/**
 * Componente controller.
 *
 * @Route("/cadastro/componente")
 */
class ComponenteController extends Controller
{
    /**
     * Lists all Componente entities.
     *
     * @Route("/", name="cadastro_componente_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $componentes = $em->getRepository('MRSInventarioBundle:Componente')->findAll();

        return $this->render('componente/index.html.twig', array(
            'componentes' => $componentes,
        ));
    }

    /**
     * Creates a new Componente entity.
     *
     * @Route("/new", name="cadastro_componente_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $componente = new Componente();
        $form = $this->createForm('MRS\InventarioBundle\Form\ComponenteType', $componente);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($componente);
            $em->flush();

            $this->addFlash('notice','Criado com sucesso!');

            return $this->redirectToRoute('cadastro_componente_show', array('id' => $componente->getId()));
        }

        return $this->render('componente/new.html.twig', array(
            'componente' => $componente,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Componente entity.
     *
     * @Route("/{id}", name="cadastro_componente_show")
     * @Method("GET")
     */
    public function showAction(Componente $componente)
    {
        $deleteForm = $this->createDeleteForm($componente);

        return $this->render('componente/show.html.twig', array(
            'componente' => $componente,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Componente entity.
     *
     * @Route("/{id}/edit", name="cadastro_componente_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Componente $componente)
    {
        $deleteForm = $this->createDeleteForm($componente);
        $editForm = $this->createForm('MRS\InventarioBundle\Form\ComponenteType', $componente);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($componente);
            $em->flush();

            $this->addFlash('notice','Alterado com sucesso!');

            return $this->redirectToRoute('cadastro_componente_show', array('id' => $componente->getId()));
        }

        return $this->render('componente/edit.html.twig', array(
            'componente' => $componente,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Componente entity.
     *
     * @Route("/{id}", name="cadastro_componente_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Componente $componente)
    {
        $form = $this->createDeleteForm($componente);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($componente);
            $em->flush();
        }

        return $this->redirectToRoute('cadastro_componente_index');
    }

    /**
     * Creates a form to delete a Componente entity.
     *
     * @param Componente $componente The Componente entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Componente $componente)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('cadastro_componente_delete', array('id' => $componente->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
