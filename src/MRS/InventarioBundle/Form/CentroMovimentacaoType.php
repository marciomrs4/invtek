<?php

namespace MRS\InventarioBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CentroMovimentacaoType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nome',null,array('label'=>'nome',
                                           'attr'=>array('class'=>'input-sm')))
            ->add('unidade',null,array('label'=>'unidade',
                                           'attr'=>array('class'=>'input-sm')))
        ;
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'MRS\InventarioBundle\Entity\CentroMovimentacao'
        ));
    }
}
