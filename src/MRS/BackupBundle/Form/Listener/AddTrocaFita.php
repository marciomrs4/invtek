<?php
namespace MRS\BackupBundle\Form\Listener;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Form;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Doctrine\ORM\EntityRepository;

class AddTrocaFita implements EventSubscriberInterface
{

    public static function getSubscribedEvents()
    {
        return array(
            //FormEvents::PRE_SET_DATA => 'preSetData',
            FormEvents::PRE_SUBMIT => 'preSubmit'
        );
    }

//    public function preSetData(FormEvent $event)
//    {
//        $tipoMovimentacao = $event->getData();
//
//        $this->addField($event->getForm(),  $tipoMovimentacao->getMotivoMovimentacao());
//    }

    /**
     * Cuando el usuario llene los datos del formulario y haga el envío del mismo,
     * este método será ejecutado.
     */
    public function preSubmit(FormEvent $event)
    {
        $data = $event->getData();
        $this->addField($event->getForm(), $data['unidade']);
    }

    protected function addField(Form $form, $unidade)
    {

        $form->add('fita',EntityType::class,array('label'=>'Fita',
            'attr'=>array('class'=>'input-sm'),
            'class'=>'MRS\BackupBundle\Entity\Fita',
            'query_builder' => function(EntityRepository $er) use($unidade){
                return $er->createQueryBuilder('F')
                    ->where('F.unidade = :unidade')
                    ->setParameter('unidade',$unidade);
            },'placeholder' => 'Selecione'));
    }


}