<?php

namespace MRS\InventarioBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use MRS\InventarioBundle\Entity\TipoAcessoIp;
use MRS\InventarioBundle\Form\TipoAcessoIpType;

/**
 * TipoAcessoIp controller.
 *
 * @Route("/cadastro/tipoacessoip")
 */
class TipoAcessoIpController extends Controller
{
    /**
     * Lists all TipoAcessoIp entities.
     *
     * @Route("/", name="cadastro_tipoacessoip_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $tipoAcessoIps = $em->getRepository('MRSInventarioBundle:TipoAcessoIp')->findAll();

        return $this->render('tipoacessoip/index.html.twig', array(
            'tipoAcessoIps' => $tipoAcessoIps,
        ));
    }

    /**
     * Creates a new TipoAcessoIp entity.
     *
     * @Route("/new", name="cadastro_tipoacessoip_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $tipoAcessoIp = new TipoAcessoIp();
        $form = $this->createForm('MRS\InventarioBundle\Form\TipoAcessoIpType', $tipoAcessoIp);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($tipoAcessoIp);
            $em->flush();

            $this->addFlash('notice','Criado com sucesso!');

            return $this->redirectToRoute('cadastro_tipoacessoip_show', array('id' => $tipoAcessoIp->getId()));
        }

        return $this->render('tipoacessoip/new.html.twig', array(
            'tipoAcessoIp' => $tipoAcessoIp,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a TipoAcessoIp entity.
     *
     * @Route("/{id}", name="cadastro_tipoacessoip_show")
     * @Method("GET")
     */
    public function showAction(TipoAcessoIp $tipoAcessoIp)
    {
        $deleteForm = $this->createDeleteForm($tipoAcessoIp);

        return $this->render('tipoacessoip/show.html.twig', array(
            'tipoAcessoIp' => $tipoAcessoIp,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing TipoAcessoIp entity.
     *
     * @Route("/{id}/edit", name="cadastro_tipoacessoip_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, TipoAcessoIp $tipoAcessoIp)
    {
        $deleteForm = $this->createDeleteForm($tipoAcessoIp);
        $editForm = $this->createForm('MRS\InventarioBundle\Form\TipoAcessoIpType', $tipoAcessoIp);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($tipoAcessoIp);
            $em->flush();

            $this->addFlash('notice','Alterado com sucesso!');

            return $this->redirectToRoute('cadastro_tipoacessoip_show', array('id' => $tipoAcessoIp->getId()));
        }

        return $this->render('tipoacessoip/edit.html.twig', array(
            'tipoAcessoIp' => $tipoAcessoIp,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a TipoAcessoIp entity.
     *
     * @Route("/{id}", name="cadastro_tipoacessoip_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, TipoAcessoIp $tipoAcessoIp)
    {
        $form = $this->createDeleteForm($tipoAcessoIp);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($tipoAcessoIp);
            $em->flush();
        }

        return $this->redirectToRoute('cadastro_tipoacessoip_index');
    }

    /**
     * Creates a form to delete a TipoAcessoIp entity.
     *
     * @param TipoAcessoIp $tipoAcessoIp The TipoAcessoIp entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(TipoAcessoIp $tipoAcessoIp)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('cadastro_tipoacessoip_delete', array('id' => $tipoAcessoIp->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
