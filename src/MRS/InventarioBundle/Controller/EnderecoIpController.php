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

        $enderecoIps = $em->getRepository('MRSInventarioBundle:EnderecoIp')
            ->findBy(array(),array('enderecoIp'=>'ASC'));

        $file = '';
        $posicao = '';
        if($request->files->get('ip_csv')){

            $file = $request->files->get('ip_csv');

            $file = file($file);


            foreach($file as $item){

            $posicao = explode(',',$item);

                //dump($posicao); die();

                $enderecoIp = new EnderecoIp();

                $TipoAcessoIp = $em->getRepository('MRSInventarioBundle:TipoAcessoIp')
                    ->find($posicao['3']);

                $Status = $em->getRepository('MRSInventarioBundle:StatusIp')
                    ->find($posicao['4']);

                $Unidade = $em->getRepository('MRSInventarioBundle:Unidade')
                    ->find($posicao['5']);


                $enderecoIp->setEnderecoIp($posicao['0'])
                    ->setNome($posicao['1'])
                    ->setObservacao($posicao['2'])
                    ->setTipoAcessoIp($TipoAcessoIp)
                    ->setStatus($Status)
                    ->setUnidade($Unidade);

                $em->persist($enderecoIp);
            }

            $em->flush();

            return $this->redirectToRoute('cadastro_enderecoip_index');

        }

        $status = $em->getRepository('MRSInventarioBundle:StatusIp')
            ->findAll();

        $tipoAcessos= $em->getRepository('MRSInventarioBundle:TipoAcessoIp')
            ->findAll();

        $unidades = $em->getRepository('MRSInventarioBundle:Unidade')
            ->findAll();

        return $this->render('enderecoip/index.html.twig', array(
            'enderecoIps' => $enderecoIps,
            'tiposAcessos' => $tipoAcessos,
            'status' => $status,
            'unidades' => $unidades
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
        $ping = false;

        if($enderecoIp->isDoPing() && $this->getParameter('do_ping')) {
            $ip = escapeshellarg($enderecoIp->getEnderecoIp());

            $ping = shell_exec("ping -c 4 {$ip}");
        }

        return $this->render('enderecoip/show.html.twig', array(
            'enderecoIp' => $enderecoIp,
            'ping' => $ping
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

    /**
     * @param EnderecoIp $equipamento
     * @Route("/view/log/{enderecoIp}",name="enderecoip_view_log")
     */
    public function viewLogEntryAction(EnderecoIp $enderecoIp)
    {

        $gedmo = $this->getDoctrine()->getRepository('Gedmo:LogEntry');

        $logs = $gedmo->getLogEntries($enderecoIp);

        //dump($logs); exit();

        return $this->render('logentry/logentry.html.twig',array(
            'logs' => $logs,
        ));

    }
}
