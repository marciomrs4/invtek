<?php

namespace MRS\BackupBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AnexoCompartilhadoType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('image_file',FileType::class,array('label'=>'Arquivo',
                                           'attr'=>array('class'=>'input-sm')))
            ->add('nome',TextType::class,array('label'=>'Descrição',
                                           'attr'=>array('class'=>'input-sm')))
            ->add('dataCriacao',DateTimeType::class,array('label'=>'dataCriacao',
                                           'attr'=>array('class'=>'input-sm'),
                    'date_widget' => 'single_text',
                    'time_widget' => 'single_text'
                ))
        ;
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'MRS\BackupBundle\Entity\AnexoCompartilhado'
        ));
    }
}
