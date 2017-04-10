<?php

namespace MRS\BackupBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RegistroBackupEquipamentoType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('equipamento',null,array('label'=>'equipamento',
                                           'attr'=>array('class'=>'input-sm')))
            ->add('dataCriacao',null,array('label'=>'dataCriacao',
                                           'attr'=>array('class'=>'input-sm')))
            ->add('unidade',null,array('label'=>'unidade',
                                           'attr'=>array('class'=>'input-sm')))
            ->add('registroBackupId',null,array('label'=>'registroBackupId',
                                           'attr'=>array('class'=>'input-sm')))
        ;
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'MRS\BackupBundle\Entity\RegistroBackupEquipamento'
        ));
    }
}
