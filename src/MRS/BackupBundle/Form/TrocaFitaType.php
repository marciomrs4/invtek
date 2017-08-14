<?php

namespace MRS\BackupBundle\Form;

use Doctrine\ORM\EntityRepository;
use MRS\BackupBundle\Form\Listener\AddTrocaFita;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TrocaFitaType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('dataCriacao',DateType::class,array('label'=>'Data da troca',
                'widget' => 'single_text',
                'attr'=>array('class'=>'input-sm')))
            ->add('unidade',EntityType::class,array('label' =>'Unidade',
                'attr'=>array('class'=>'input-sm'),
                'mapped' => false,
                'class' => 'MRS\InventarioBundle\Entity\Unidade',
                'query_builder' => function(EntityRepository $er){
                    return $er->createQueryBuilder('U');
                },'placeholder' => 'Selecione'))
            ->add('fita',null,array('label'=>'Fita',
                'attr'=>array('class'=>'input-sm')))
        ;

        $builder->addEventSubscriber(new AddTrocaFita());
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'MRS\BackupBundle\Entity\TrocaFita'
        ));
    }
}
