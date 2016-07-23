<?php
namespace MRS\InventarioBundle\Form\Listener;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Form;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Doctrine\ORM\EntityRepository;

class AddUsuarioDestinoMovimentacao implements EventSubscriberInterface
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
        $usuarioOrigem = $event->getData();

        $usuarioOrigem = ($usuarioOrigem && $usuarioOrigem->getUsuarioDestino())
                        ? $usuarioOrigem->getUsuarioDestino() : null;

        $this->addField($event->getForm(),  $usuarioOrigem);
    }

    /**
     * Cuando el usuario llene los datos del formulario y haga el envío del mismo,
     * este método será ejecutado.
     */
    public function preSubmit(FormEvent $event)
    {
        $data = $event->getData();

        $this->addField($event->getForm(), $data['usuarioOrigem']);
    }

    protected function addField(Form $form, $usuarioOrigem)
    {


        $form->add('usuarioDestino',EntityType::class, array(
            'class' => 'MRS\InventarioBundle\Entity\Usuario',
            'query_builder' => function(EntityRepository $er) use ($usuarioOrigem){
                return $er->createQueryBuilder('User')
                    ->where('User.id NOT IN(:usuario)')
                    ->orderBy('User.nomecompleto')
                    ->setParameter('usuario', $usuarioOrigem);
            }
        ));
    }
}