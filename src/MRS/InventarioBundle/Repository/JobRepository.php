<?php
/**
 * Created by PhpStorm.
 * User: marcio
 * Date: 03/08/16
 * Time: 18:26
 */
namespace MRS\InventarioBundle\Repository;


use Doctrine\ORM\EntityRepository;

class JobRepository extends EntityRepository
{

    public function getJobByUnidade($unidade)
    {
        return $this->createQueryBuilder('t')
            ->select('t.id','t.descricao as text')
            ->orderBy('t.descricao')
            ->where('t.unidade = :unidade')
            ->setParameter('unidade',$unidade)
            ->getQuery()
            ->getResult();
    }


}