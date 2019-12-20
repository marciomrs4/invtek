<?php

namespace MRS\InventarioBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CurrencyType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class LicencaSoftwareType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nota_fiscal',TextType::class,array('label'=>'Nota fiscal',
                                           'attr'=>array('class'=>'input-sm')))
            ->add('data_emissao',DateType::class,array('label'=>'Data emissão',
                  'widget' => 'single_text',
                  'attr'=>array('class'=>'input-sm')))
            ->add('valor_unitario',MoneyType::class,array('label'=>'Valor Unitário',
                                           'attr'=>array('class'=>'input-sm'),
                'currency' => 'BRL', 'scale' => 2))
            ->add('quantidade_total',IntegerType::class,array('label'=>'Quantidade Total',
                                           'attr'=>array('class'=>'input-sm')))
            ->add('anotacoes',TextType::class,array('label'=>'Anotações',
                                           'attr'=>array('class'=>'input-sm')))
        ;
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'MRS\InventarioBundle\Entity\LicencaSoftware'
        ));
    }
}
