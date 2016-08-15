<?php

namespace MRS\InventarioBundle\Form;

use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CentroMovimentacaoType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nome',null,array('label'=>'Nome',
                'attr'=>array('class'=>'input-sm')))
            ->add('unidade',EntityType::class,array('label'=>'Unidade',
                'attr'=>array('class'=>'input-sm'),
                'class' => 'MRS\InventarioBundle\Entity\Unidade' ,
                'query_builder' =>    function(EntityRepository $er){
                    return $er->createQueryBuilder('u')
                        ->orderBy('u.nome');

                }))
        ;
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'MRS\InventarioBundle\Entity\CentroMovimentacao'
        ));
    }
}
