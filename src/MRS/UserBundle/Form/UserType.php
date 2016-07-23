<?php

namespace MRS\UserBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('username',TextType::class,array('label'=>'login',
                                           'attr'=>array('class'=>'input-sm')))
            ->add('email',TextType::class,array('label'=>'Email',
                                           'attr'=>array('class'=>'input-sm')))
            ->add('plainPassword',PasswordType::class,array('label'=>'Senha',
                                           'attr'=>array('class'=>'input-sm')))
            ->add('isActive',null,array('label'=>'Ativo'))
            ->add('roles',null,array('label'=>'Permissões',
                'attr'=>array('class'=>'input-sm')))
        ;
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'MRS\UserBundle\Entity\User'
        ));
    }
}
