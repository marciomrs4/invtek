<?php

namespace MRS\BackupBundle\Form;

use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class JobServidorType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('equipamento',EntityType::class,array('label'=>'equipamento',
                'class' => 'MRS\InventarioBundle\Entity\Equipamento',
                'query_builder' => function(EntityRepository $er){
                    return $er->createQueryBuilder('E')
                        ->where('E.tipoequipamento = 3')
                        ->andWhere('E.centroMovimentacao = 29');
                },
                'attr'=>array('class'=>'input-sm')))
        ;
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'MRS\BackupBundle\Entity\JobServidor'
        ));
    }
}
