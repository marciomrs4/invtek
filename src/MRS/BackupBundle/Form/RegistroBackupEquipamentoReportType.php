<?php

namespace MRS\BackupBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RegistroBackupEquipamentoReportType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('equipamento',TextType::class,array('label'=>'Equipamento (patrimônio|nome)',
                'attr'=>array('class'=>'input-sm')))
            ->add('data1',DateType::class,array('label'=>'Data Inicial',
                'widget'=> 'single_text',
                'attr' => array('class'=>'input-sm'),
                'mapped' => false))
            ->add('data2',DateType::class,array('label'=>'Data Final',
                'widget'=> 'single_text',
                'attr'=>array('class'=>'input-sm'),
                'mapped' => false));;
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
