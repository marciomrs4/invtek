<?php

namespace MRS\InventarioBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use MRS\InventarioBundle\Entity\EnderecoIp;
use MRS\InventarioBundle\Form\EnderecoIpType;

/**
 * EnderecoIp controller.
 *
 * @Route("/cadastro/enderecoip")
 */
class EnderecoIpController extends Controller
{
    /**
     * Lists all EnderecoIp entities.
     *
     * @Route("/", name="cadastro_enderecoip_index")
     * @Method({"GET","POST"})
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $enderecoIps = $em->getRepository('MRSInventarioBundle:EnderecoIp')->findAll();

        $file = '';
        $posicao = '';
        if($request->files->get('ip_csv')){

            $file = $request->files->get('ip_csv');

            $file = file($file);


            foreach($file as $item){

            $posicao = explode(';',$item);

                $enderecoIp = new EnderecoIp();

                $TipoAcessoIp = $em->getRepository('MRSInventarioBundle:TipoAcessoIp')
                    ->find($posicao['3']);

                $CategoriaIp = $em->getRepository('MRSInventarioBundle:CategoriaIp')
                    ->find($posicao['4']);


                $enderecoIp->setEnderecoIp($posicao['0'])
                    ->setNome($posicao['1'])
                    ->setObservacao($posicao['2'])
                    ->setTipoAcessoIp($TipoAcessoIp)
                    ->setCategoria($CategoriaIp);

                $em->persist($enderecoIp);
                $em->flush();


            }


        }

        return $this->render('enderecoip/index.html.twig', array(
            'enderecoIps' => $enderecoIps,
        ));
    }

    /**
     * Creates a new EnderecoIp entity.
     *
     * @Route("/new", name="cadastro_enderecoip_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $enderecoIp = new EnderecoIp();
        $form = $this->createForm('MRS\InventarioBundle\Form\EnderecoIpType', $enderecoIp);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($enderecoIp);
            $em->flush();

            $this->addFlash('notice','Criado com sucesso!');

            return $this->redirectToRoute('cadastro_enderecoip_show', array('id' => $enderecoIp->getId()));
        }

        return $this->render('enderecoip/new.html.twig', array(
            'enderecoIp' => $enderecoIp,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a EnderecoIp entity.
     *
     * @Route("/{id}", name="cadastro_enderecoip_show")
     * @Method("GET")
     */
    public function showAction(EnderecoIp $enderecoIp)
    {
        $deleteForm = $this->createDeleteForm($enderecoIp);

        return $this->render('enderecoip/show.html.twig', array(
            'enderecoIp' => $enderecoIp,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing EnderecoIp entity.
     *
     * @Route("/{id}/edit", name="cadastro_enderecoip_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, EnderecoIp $enderecoIp)
    {
        $deleteForm = $this->createDeleteForm($enderecoIp);
        $editForm = $this->createForm('MRS\InventarioBundle\Form\EnderecoIpType', $enderecoIp);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($enderecoIp);
            $em->flush();

            $this->addFlash('notice','Alterado com sucesso!');

            return $this->redirectToRoute('cadastro_enderecoip_show', array('id' => $enderecoIp->getId()));
        }

        return $this->render('enderecoip/edit.html.twig', array(
            'enderecoIp' => $enderecoIp,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a EnderecoIp entity.
     *
     * @Route("/{id}", name="cadastro_enderecoip_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, EnderecoIp $enderecoIp)
    {
        $form = $this->createDeleteForm($enderecoIp);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($enderecoIp);
            $em->flush();
        }

        return $this->redirectToRoute('cadastro_enderecoip_index');
    }

    /**
     * Creates a form to delete a EnderecoIp entity.
     *
     * @param EnderecoIp $enderecoIp The EnderecoIp entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(EnderecoIp $enderecoIp)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('cadastro_enderecoip_delete', array('id' => $enderecoIp->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
