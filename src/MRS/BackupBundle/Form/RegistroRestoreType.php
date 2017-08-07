<?php

namespace MRS\BackupBundle\Form;

use Doctrine\ORM\EntityRepository;
use MRS\BackupBundle\Form\Listener\AddRegistroRestore;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RegistroRestoreType extends AbstractType
{

    private $container;

    public function __construct(ContainerInterface $containerInterface)
    {
        $this->container = $containerInterface;

    }

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $tiposequipamentos = $this->container->getParameter('tiposequipamentos');

        $builder
            ->add('data',DateType::class,array('label'=>'Data',
                'widget' => 'single_text',
                'attr'=>array('class'=>'input-sm')))
            ->add('unidade',EntityType::class,array('label'=>'Unidade',
                'mapped' => false,
                'class' => 'MRS\InventarioBundle\Entity\Unidade',
                'placeholder' => 'Selecione'))
            ->add('equipamento',EntityType::class,array('label'=>'Equipamento',
                'attr'=>array('class'=>'input-sm'),
                'class' => 'MRS\InventarioBundle\Entity\Equipamento',
                'query_builder' => function(EntityRepository $er) use ($tiposequipamentos){
                    return $er->createQueryBuilder('Equipamento')
                        ->where('Equipamento.tipoequipamento IN (:tipoequipamento)')
                        ->setParameter('tipoequipamento',$tiposequipamentos)
                        ->orderBy('Equipamento.patrimonio');
                },'placeholder'=>''))
            ->add('fita',EntityType::class,array('label'=>'Fita',
                'attr'=>array('class'=>'input-sm'),
                'class' => 'MRS\BackupBundle\Entity\Fita',
                'query_builder' => function(EntityRepository $er){
                    return $er->createQueryBuilder('FITA')
                        ->orderBy('FITA.barCode')
                        ->addOrderBy('FITA.descricao');
                },'placeholder' =>''))
            ->add('tipoJob',null,array('label'=>'Tipo de Job',
                'attr'=>array('class'=>'input-sm')))
            ->add('status',null,array('label'=>'Status',
                'attr'=>array('class'=>'input-sm')))
            ->add('observacao',null,array('label'=>'Observação',
                'attr'=>array('class'=>'input-sm')));

        $builder->addEventSubscriber(new AddRegistroRestore($this->container));
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'MRS\BackupBundle\Entity\RegistroRestore'
        ));

    }
}
