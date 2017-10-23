<?php

namespace MRS\BackupBundle\Form;

use Doctrine\ORM\EntityRepository;
use MRS\BackupBundle\Form\Listener\AddJob;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RegistroBackupType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('data',null,array('label'=>'Data',
                'widget'=>'single_text',
                'attr'=>array('class'=>'input-sm')))
            ->add('job',EntityType::class,array('label'=>'Job',
                'attr'=>array('class'=>'input-sm'),
                'class' => 'MRS\BackupBundle\Entity\Job',
                'placeholder'=>''))
            ->add('status',null,array('label'=>'Status',
                'attr'=>array('class'=>'input-sm')))
            ->add('observacao',null,array('label'=>'Observação',
                'attr'=>array('class'=>'input-sm')))
        ;

        //$builder->addEventSubscriber(new AddJob());
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'MRS\BackupBundle\Entity\RegistroBackup'
        ));
    }
}
