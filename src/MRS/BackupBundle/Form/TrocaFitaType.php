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
            ->add('fita',EntityType::class,array('label'=>'Fita',
                'attr'=>array('class'=>'input-sm'),
                'class' => 'MRS\BackupBundle\Entity\Fita',
                'query_builder' => function(EntityRepository $er){
                    return $er->createQueryBuilder('F')
                        ->orderBy('F.unidade')
                        ->addOrderBy('F.barCode');
                }, 'placeholder' =>'Selecione'))
        ;

        //$builder->addEventSubscriber(new AddTrocaFita());
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
