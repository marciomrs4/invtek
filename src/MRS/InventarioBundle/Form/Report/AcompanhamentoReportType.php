<?php

namespace MRS\InventarioBundle\Form\Report;

use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AcompanhamentoReportType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('tipoequipamento',EntityType::class,array('label'=>'Tipo de Equipamento',
                'attr'=>array('class'=>'input-sm'),
                'class' => 'MRS\InventarioBundle\Entity\Tipoequipamento',
                'placeholder'=>'Todos'))
            ->add('centroMovimentacao',EntityType::class,array('label'=>'Centro de Movimentação',
                'attr'=>array('class'=>'input-sm'),
                'class'=>'MRS\InventarioBundle\Entity\CentroMovimentacao',
                'placeholder'=>'Todos'))
        ;
    }


    public function getBlockPrefix()
    {
        return 'report_acompanhamento';
    }
}
