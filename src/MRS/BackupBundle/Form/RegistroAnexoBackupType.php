<?php

namespace MRS\BackupBundle\Form;

use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RegistroAnexoBackupType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('anexoCompartilhado',EntityType::class,array('label'=>'Anexo Compartilhado',
                                           'attr'=>array('class'=>'input-sm'),
                'class' => 'MRS\BackupBundle\Entity\AnexoCompartilhado',
                'query_builder' => function(EntityRepository $er){
                    $data = new \DateTime('now');
                    return $er->createQueryBuilder('AC')
                        ->where('AC.dataCriacao > :dataFinal')
                        ->setParameter('dataFinal',$data->modify('-3day'));
                }))
        ;
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'MRS\BackupBundle\Entity\RegistroAnexoBackup'
        ));
    }
}
