<?php

namespace MRS\BackupBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FitaType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('barCode',null,array('label'=>'barCode',
                                           'attr'=>array('class'=>'input-sm')))
            ->add('ciclo',null,array('label'=>'ciclo',
                                           'attr'=>array('class'=>'input-sm')))
            ->add('jogo',null,array('label'=>'jogo',
                                           'attr'=>array('class'=>'input-sm')))
            ->add('descricao',null,array('label'=>'descricao',
                                           'attr'=>array('class'=>'input-sm')))
            ->add('unidade',null,array('label'=>'unidade',
                                           'attr'=>array('class'=>'input-sm')))
            ->add('midia',null,array('label'=>'midia',
                                           'attr'=>array('class'=>'input-sm')))
        ;
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'MRS\BackupBundle\Entity\Fita'
        ));
    }
}
