<?php
namespace MRS\InventarioBundle\Form\Listener;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Form;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Doctrine\ORM\EntityRepository;

class AddMotivoMovimentacao implements EventSubscriberInterface
{
    public static function getSubscribedEvents()
    {
        return array(
            FormEvents::PRE_SET_DATA => 'preSetData',
            FormEvents::PRE_SUBMIT => 'preSubmit'
        );
    }

    public function preSetData(FormEvent $event)
    {
        $tipoMovimentacao = $event->getData();

//        $tipoMovimentacao = ($tipoMovimentacao && $tipoMovimentacao->getMotivoMovimentacao())
//                        ? $tipoMovimentacao->getMotivoMovimentacao() : null;

        $this->addField($event->getForm(),  $tipoMovimentacao->getMotivoMovimentacao());
    }

    /**
     * Cuando el usuario llene los datos del formulario y haga el envío del mismo,
     * este método será ejecutado.
     */
    public function preSubmit(FormEvent $event)
    {
        $data = $event->getData();

        $this->addField($event->getForm(), $data['tipomovimentacao']);
    }

    protected function addField(Form $form, $tipoMovimentacao)
    {


        $form->add('motivomovimentacao',EntityType::class, array(
            'label'=>'Motivo de Movimentacao',
            'class' => 'MRS\InventarioBundle\Entity\Motivomovimentacao',
            'query_builder' => function(EntityRepository $er) use ($tipoMovimentacao){
                return $er->createQueryBuilder('MOTIVO')
                    ->where('MOTIVO.tipomovimentacao = :tipomovimentacao')
                    ->orderBy('MOTIVO.descricao')
                    ->setParameter('tipomovimentacao', $tipoMovimentacao);
            }
        ));
    }
}