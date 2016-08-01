<?php

namespace MRS\InventarioBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EquipamentoType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nome',null,array('label'=>'nome',
                'attr'=>array('class'=>'input-sm')))
            ->add('fornecedor',null,array('label'=>'fornecedor',
                'attr'=>array('class'=>'input-sm')))
            ->add('tipoequipamento',null,array('label'=>'tipoequipamento',
                'attr'=>array('class'=>'input-sm')))
            ->add('validade', DateType::class,array('label'=>'Vigência de Garantia',
                'widget'=>'single_text',
                'attr' => array('class'=>'input-sm')))
            ->add('dataCompra',DateType::class,array('label'=>'Data da Compra',
                'widget'=>'single_text',
                'attr' => array('class'=>'input-sm')))
            ->add('numeroserie',TextType::class,array('label'=>'numeroserie',
                'attr'=>array('class'=>'input-sm')))
            ->add('status',null,array('label'=>'Status'))
            ->add('patrimonio',null,array('label'=>'patrimonio',
                'attr'=>array('class'=>'input-sm')))
            ->add('descricao',null,array('label'=>'descricao',
                'attr'=>array('class'=>'input-sm')))
            ->add('observacao',null,array('label'=>'observacao',
                'attr'=>array('class'=>'input-sm')))
            ->add('centroMovimentacao',null,array('label'=>'centroMovimentacao',
                'attr'=>array('class'=>'input-sm')))
            ->add('marca',null,array('label'=>'marca',
                'attr'=>array('class'=>'input-sm')))
        ;
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'MRS\InventarioBundle\Entity\Equipamento'
        ));
    }
}
