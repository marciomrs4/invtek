<?php

namespace MRS\InventarioBundle\Form;

use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
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
            ->add('nome',TextType::class,array('label'=>'Nome',
                'attr'=>array('class'=>'input-sm')))
            ->add('centroMovimentacao',EntityType::class,array('label'=>'Centro de Movimentação',
                'attr'=>array('class'=>'input-sm'),
                'class' => 'MRS\InventarioBundle\Entity\CentroMovimentacao',
                'query_builder' => function(EntityRepository $er){
                    return $er->createQueryBuilder('c')
                        ->orderBy('c.unidade')
                        ->addOrderBy('c.nome');
                },'placeholder' => ''))
            ->add('fornecedor',EntityType::class,array('label'=>'Fornecedor',
                'attr'=>array('class'=>'input-sm'),
                'class' => 'MRS\InventarioBundle\Entity\Fornecedor',
                'query_builder' => function(EntityRepository $er){
                    return $er->createQueryBuilder('f')
                        ->orderBy('f.nome');
                },'placeholder' => ''))
            ->add('marca',EntityType::class,array('label'=>'Marca',
                'attr'=>array('class'=>'input-sm'),
                'class' => 'MRS\InventarioBundle\Entity\Marca',
                'query_builder' => function(EntityRepository $er){
                    return $er->createQueryBuilder('m')
                        ->orderBy('m.nome');
                },'placeholder'=>''))
            ->add('tipoequipamento',EntityType::class,array('label'=>'Tipo de Equipamento',
                'attr'=>array('class'=>'input-sm'),
                'class'=> 'MRS\InventarioBundle\Entity\Tipoequipamento',
                'query_builder'=>function(EntityRepository $er){
                    return $er->createQueryBuilder('t')
                        ->orderBy('t.descricao');
                },'placeholder'=> ''))
            ->add('validade', DateType::class,array('label'=>'Vigência de Garantia',
                'widget'=>'single_text',
                'attr' => array('class'=>'input-sm')))
            ->add('dataCompra',DateType::class,array('label'=>'Data da Compra',
                'widget'=>'single_text',
                'attr' => array('class'=>'input-sm')))
            ->add('numeroserie',TextType::class,array('label'=>'Número de Série',
                'attr'=>array('class'=>'input-sm')))
            ->add('status',CheckboxType::class,array('label'=>'Status'))
            ->add('patrimonio',TextType::class,array('label'=>'Patrimônio',
                'attr'=>array('class'=>'input-sm')))
            ->add('descricao',TextType::class,array('label'=>'Descrição',
                'attr'=>array('class'=>'input-sm')))
            ->add('observacao',TextareaType::class,array('label'=>'Observação',
                'attr'=>array('class'=>'input-sm')))
            ->add('compradoPara',EntityType::class,array('label'=>'Comprado Para',
                'attr'=>array('class'=>'input-sm'),
                'class' => 'MRS\InventarioBundle\Entity\CentroMovimentacao',
                'query_builder' => function(EntityRepository $er){
                    return $er->createQueryBuilder('c')
                        ->orderBy('c.unidade')
                        ->addOrderBy('c.nome');
                },'placeholder' => ''))
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
