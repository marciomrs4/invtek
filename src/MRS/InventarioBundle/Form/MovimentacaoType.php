<?php

namespace MRS\InventarioBundle\Form;

use MRS\InventarioBundle\Form\Listener\AddMotivoMovimentacao;
use MRS\InventarioBundle\Form\Listener\AddUsuarioDestinoMovimentacao;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MovimentacaoType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('datahora', DateTimeType::class, array('label'=>'Data e Hora',
                'date_widget'=>'single_text',
                'time_widget'=>'single_text',))
            ->add('usuarioOrigem',null,array('label'=>'Usuário Origem',
                'attr'=>array('class'=>'input-sm')))
            ->add('usuarioDestino',null,array('label'=>'Usuário Destino',
                'attr'=>array('class'=>'input-sm')))
            ->add('tipomovimentacao',null,array('label'=>'Tipo de Movimentacao',
                'placeholder'=>'Selecione',
                'attr'=>array('class'=>'input-sm')))
            ->add('motivomovimentacao',null,array('label'=>'Motivo de Movimentacao',
                'attr'=>array('class'=>'input-sm')))

        ;

        $builder->addEventSubscriber(new AddMotivoMovimentacao());
        //$builder->addEventSubscriber(new AddUsuarioDestinoMovimentacao());
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'MRS\InventarioBundle\Entity\Movimentacao'
        ));
    }
}
