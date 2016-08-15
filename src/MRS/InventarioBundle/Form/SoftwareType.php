<?php

namespace MRS\InventarioBundle\Form;

use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SoftwareType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('descricao',null,array('label'=>'Descrição',
                                           'attr'=>array('class'=>'input-sm')))
            ->add('numerolicensa',null,array('label'=>'Número liçensa',
                                           'attr'=>array('class'=>'input-sm')))
            ->add('versao',null,array('label'=>'Versão',
                                           'attr'=>array('class'=>'input-sm')))
            ->add('serial',null,array('label'=>'Serial',
                                           'attr'=>array('class'=>'input-sm')))
            ->add('tiposoftware',EntityType::class,array('label'=>'Tipo de Software',
                                           'attr'=>array('class'=>'input-sm'),
                'class' => 'MRS\InventarioBundle\Entity\Tiposoftware',
                'query_builder' => function(EntityRepository $er){
                    return $er->createQueryBuilder('t')
                        ->orderBy('t.descricao');
                },
                'placeholder'=>'Selecione'))
        ;
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'MRS\InventarioBundle\Entity\Software'
        ));
    }
}
