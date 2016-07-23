<?php

namespace MRS\InventarioBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EquipamentoHasEquipamentoType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('equipamentoFilho',null,array('label'=>'equipamentoFilho',
                                           'attr'=>array('class'=>'input-sm')))
            ->add('equipamentoPai',null,array('label'=>'equipamentoPai',
                                           'attr'=>array('class'=>'input-sm')))
        ;
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'MRS\InventarioBundle\Entity\EquipamentoHasEquipamento'
        ));
    }
}
