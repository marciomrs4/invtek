<?php

namespace MRS\InventarioBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CustoEquipamentoType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('valor',MoneyType::class,array('label'=>'Valor',
                                           'attr'=>array('class'=>'input-sm'),
                'currency' => 'BRL', 'scale' => 2))
            ->add('data_criacao',DateType::class,array('label'=>'Data Lançamento',
                        'widget' => 'single_text',
                        'attr' => array('class'=> 'input-sm')))
            ->add('descricao',null,array('label'=>'Descrição',
                                           'attr'=>array('class'=>'input-sm')))
        ;
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'MRS\InventarioBundle\Entity\CustoEquipamento'
        ));
    }
}
