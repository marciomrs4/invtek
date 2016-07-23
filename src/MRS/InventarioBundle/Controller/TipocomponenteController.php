<?php

namespace MRS\InventarioBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use MRS\InventarioBundle\Entity\Tipocomponente;
use MRS\InventarioBundle\Form\TipocomponenteType;

/**
 * Tipocomponente controller.
 *
 * @Route("/cadastro/tipocomponente")
 */
class TipocomponenteController extends Controller
{
    /**
     * Lists all Tipocomponente entities.
     *
     * @Route("/", name="cadastro_tipocomponente_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $tipocomponentes = $em->getRepository('MRSInventarioBundle:Tipocomponente')->findAll();

        return $this->render('tipocomponente/index.html.twig', array(
            'tipocomponentes' => $tipocomponentes,
        ));
    }

    /**
     * Creates a new Tipocomponente entity.
     *
     * @Route("/new", name="cadastro_tipocomponente_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $tipocomponente = new Tipocomponente();
        $form = $this->createForm('MRS\InventarioBundle\Form\TipocomponenteType', $tipocomponente);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($tipocomponente);
            $em->flush();

            $this->addFlash('notice','Criado com sucesso!');

            return $this->redirectToRoute('cadastro_tipocomponente_show', array('id' => $tipocomponente->getId()));
        }

        return $this->render('tipocomponente/new.html.twig', array(
            'tipocomponente' => $tipocomponente,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Tipocomponente entity.
     *
     * @Route("/{id}", name="cadastro_tipocomponente_show")
     * @Method("GET")
     */
    public function showAction(Tipocomponente $tipocomponente)
    {
        $deleteForm = $this->createDeleteForm($tipocomponente);

        return $this->render('tipocomponente/show.html.twig', array(
            'tipocomponente' => $tipocomponente,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Tipocomponente entity.
     *
     * @Route("/{id}/edit", name="cadastro_tipocomponente_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Tipocomponente $tipocomponente)
    {
        $deleteForm = $this->createDeleteForm($tipocomponente);
        $editForm = $this->createForm('MRS\InventarioBundle\Form\TipocomponenteType', $tipocomponente);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($tipocomponente);
            $em->flush();

            $this->addFlash('notice','Alterado com sucesso!');

            return $this->redirectToRoute('cadastro_tipocomponente_show', array('id' => $tipocomponente->getId()));
        }

        return $this->render('tipocomponente/edit.html.twig', array(
            'tipocomponente' => $tipocomponente,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Tipocomponente entity.
     *
     * @Route("/{id}", name="cadastro_tipocomponente_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Tipocomponente $tipocomponente)
    {
        $form = $this->createDeleteForm($tipocomponente);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($tipocomponente);
            $em->flush();
        }

        return $this->redirectToRoute('cadastro_tipocomponente_index');
    }

    /**
     * Creates a form to delete a Tipocomponente entity.
     *
     * @param Tipocomponente $tipocomponente The Tipocomponente entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Tipocomponente $tipocomponente)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('cadastro_tipocomponente_delete', array('id' => $tipocomponente->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
