<?php

namespace MRS\InventarioBundle\Controller;

use MRS\InventarioBundle\Entity\Equipamento;
use MRS\InventarioBundle\Entity\EquipamentoHasSoftware;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use MRS\InventarioBundle\Entity\Software;
use MRS\InventarioBundle\Form\SoftwareType;

/**
 * Software controller.
 *
 * @Route("/cadastro/software")
 */
class SoftwareController extends Controller
{
    /**
     * Lists all Software entities.
     *
     * @Route("/", name="cadastro_software_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $softwares = $em->getRepository('MRSInventarioBundle:Software')->findAll();

        return $this->render('software/index.html.twig', array(
            'softwares' => $softwares,
        ));
    }

    /**
     * Creates a new Software entity.
     *
     * @Route("/new", name="cadastro_software_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $software = new Software();

        $form = $this->createForm('MRS\InventarioBundle\Form\SoftwareType', $software);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($software);
            $em->flush();

            $this->addFlash('notice','Criado com sucesso!');

            return $this->redirectToRoute('cadastro_software_show', array('id' => $software->getId()));
        }

        return $this->render('software/new.html.twig', array(
            'software' => $software,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Software entity.
     *
     * @Route("/{id}", name="cadastro_software_show")
     * @Method("GET")
     */
    public function showAction(Software $software)
    {
        $deleteForm = $this->createDeleteForm($software);

        $tags = $this->getDoctrine()->getRepository('MRSInventarioBundle:SoftwareTag')
            ->findBy(array('software'=>$software));

        $quantidadeEquipamento = $this->getDoctrine()->getRepository('MRSInventarioBundle:Software')
            ->countSoftwareOnEquipamento($software->getId());

        return $this->render('software/show.html.twig', array(
            'software' => $software,
            'quantidadeEquipamento' => $quantidadeEquipamento,
            'tags' => $tags,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Software entity.
     *
     * @Route("/{id}/edit", name="cadastro_software_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Software $software)
    {
        $deleteForm = $this->createDeleteForm($software);
        $editForm = $this->createForm('MRS\InventarioBundle\Form\SoftwareType', $software);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($software);
            $em->flush();

            $this->addFlash('notice','Alterado com sucesso!');

            return $this->redirectToRoute('cadastro_software_show', array('id' => $software->getId()));
        }

        return $this->render('software/edit.html.twig', array(
            'software' => $software,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Software entity.
     *
     * @Route("/{id}", name="cadastro_software_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Software $software)
    {
        $form = $this->createDeleteForm($software);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($software);
            $em->flush();
        }

        return $this->redirectToRoute('cadastro_software_index');
    }

    /**
     * Creates a form to delete a Software entity.
     *
     * @param Software $software The Software entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Software $software)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('cadastro_software_delete', array('id' => $software->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
