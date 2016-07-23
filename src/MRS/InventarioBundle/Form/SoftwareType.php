<?php

namespace MRS\InventarioBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SoftwareType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('descricao',null,array('label'=>'descricao',
                                           'attr'=>array('class'=>'input-sm')))
            ->add('numerolicensa',null,array('label'=>'numerolicensa',
                                           'attr'=>array('class'=>'input-sm')))
            ->add('versao',null,array('label'=>'versao',
                                           'attr'=>array('class'=>'input-sm')))
            ->add('serial',null,array('label'=>'serial',
                                           'attr'=>array('class'=>'input-sm')))
            ->add('tiposoftware',null,array('label'=>'tiposoftware',
                                           'attr'=>array('class'=>'input-sm')))
        ;
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'MRS\InventarioBundle\Entity\Software'
        ));
    }
}
