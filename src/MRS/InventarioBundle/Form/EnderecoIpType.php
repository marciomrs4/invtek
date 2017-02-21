<?php

namespace MRS\InventarioBundle\Form;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\CallbackTransformer;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EnderecoIpType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('enderecoIp',null,array('label'=>'Endereço IP',
                'attr'=>array('class'=>'input-sm')))
            ->add('nome',null,array('label'=>'Host Name',
                'attr'=>array('class'=>'input-sm',
                    'data-behavior'=>'uppercase')));

        $builder->get('nome',null,array('label'=>'Host Name',
            'attr'=>array('class'=>'input-sm',
                'data-behavior'=>'uppercase')))
            ->addModelTransformer(new CallbackTransformer(
                function($toUpperCase){
                    return strtoupper($toUpperCase);
                },
                function($toUpperCase){
                    return strtoupper($toUpperCase);
                }
            ));

        $builder->add('observacao',null,array('label'=>'Observação',
            'attr'=>array('class'=>'input-sm')))
            ->add('tipoAcessoIp',EntityType::class,array('label'=>'Tipo de Acesso',
                'attr'=>array('class'=>'input-sm'),
                'class' => 'MRS\InventarioBundle\Entity\TipoAcessoIp'))
            ->add('status',EntityType::class,array('label'=>'Status',
                'attr'=>array('class'=>'input-sm'),
                'class' => 'MRS\InventarioBundle\Entity\StatusIp'))
            ->add('unidade',null,array('label'=>'Unidade'))
            ->add('doPing',CheckboxType::class,array('label'=>'Faz Ping ?'))
        ;
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'MRS\InventarioBundle\Entity\EnderecoIp'
        ));
    }
}
