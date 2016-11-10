<?php
/**
 * Created by PhpStorm.
 * User: marcio
 * Date: 03/08/16
 * Time: 18:26
 */
namespace MRS\InventarioBundle\Repository;


use Doctrine\ORM\EntityRepository;

class TipoequipamentoRepository extends EntityRepository
{

    public function getAllOrderByDescricao()
    {
        return $this->createQueryBuilder('t')
            ->orderBy('t.descricao')
            ->getQuery()
            ->getResult();
    }


}