<?php

namespace MRS\InventarioBundle\Form;

use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EquipamentoHasEquipamentoType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        /*
        $builder
            ->add('equipamentoFilho',EntityType::class,array('label'=>'Equipamento',
                                           'attr'=>array('class'=>'input-sm'),
                'class' => 'MRS\InventarioBundle\Entity\Equipamento',
                'query_builder' => function(EntityRepository $er){
                    return $er->createQueryBuilder('e');
                }))

            /*->add('equipamentoPai',null,array('label'=>'equipamentoPai',
                                           'attr'=>array('class'=>'input-sm'))) ; */

//
//        $builder->addEventListener(FormEvents::PRE_SET_DATA,function(FormEvent $event){
//
//
//            $equipamentoHasEquipamento = $event->getData();
//            $form = $event->getForm();
//
//            EntityRepository::
//
//            $equipamento = $equipamentoHasEquipamento->getEquipamentoPai()->getId();
//
//            $equipamentos = $er->getRepository('MRSInventarioBundle:EquipamentoHasEquipamento')
//                ->findBy(array('equipamentoPai' => $equipamento));
//
//            if(!$equipamentos){
//                $itensId[] = 'null';
//            }
//
//            foreach($equipamentos as $item){
//                $itensId[] = $item->getEquipamentoFilho();
//            }
//
//            $form = $this->createForm('MRS\InventarioBundle\Form\EquipamentoHasEquipamentoType', $equipamentoHasEquipamento);
//
//            $form->add('equipamentoFilho',EntityType::class,array('label'=>'Equipamento',
//                'attr'=>array('class'=>'input-sm'),
//                'class' => 'MRS\InventarioBundle\Entity\Equipamento',
//                'query_builder' => function(EntityRepository $er)use($equipamento, $itensId){
//                    return $er->createQueryBuilder('e')
//                        ->where('e.id != :equipamento')
//                        ->andWhere('e.id NOT IN (:itens)')
//                        ->setParameter('equipamento',$equipamento)
//                        ->setParameter('itens',$itensId)
//                        ->orderBy('e.descricao');
//                }));
//
//
//        });


    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'MRS\InventarioBundle\Entity\EquipamentoHasEquipamento'
        ));
    }
}
