<?php

namespace MRS\BackupBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class JobType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('descricao',null,array('label'=>'Descrição',
                                           'attr'=>array('class'=>'input-sm')))
            ->add('tipoJob',null,array('label'=>'Tipo de Job',
                                           'attr'=>array('class'=>'input-sm')))
            ->add('unidade',null,array('label'=>'Unidade',
                                           'attr'=>array('class'=>'input-sm')))
            ->add('status',null,array('label' => 'Status'))
        ;
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'MRS\BackupBundle\Entity\Job'
        ));
    }
}
