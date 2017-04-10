<?php
namespace MRS\BackupBundle\Form\Listener;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Form;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Doctrine\ORM\EntityRepository;

class AddJob implements EventSubscriberInterface
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

        //dump($data); exit();

        $this->addField($event->getForm(), $data['unidade']);
    }

    protected function addField(Form $form, $registroBackupUnidade)
    {

        $form->add('job',EntityType::class,array('label'=>'Job',
        'attr'=>array('class'=>'input-sm'),
        'class' => 'MRS\BackupBundle\Entity\Job',
            'query_builder' => function(EntityRepository $er) use ($registroBackupUnidade){
                    return $er->createQueryBuilder('J')
                        ->where('J.unidade = :unidade')
                        ->setParameter('unidade',$registroBackupUnidade);
            }));

    }
}