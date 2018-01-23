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

    public function getJobByDataRegisterBackup($data)
    {
        $em = $this->getEntityManager()->getConnection();

        $stmt = $em->prepare("SELECT id,
                                     (SELECT descricao FROM tipo_job WHERE id = tipo_job_id) AS tipo_job_id,
                                     (SELECT nome FROM unidade WHERE id = unidade_id) AS unidade,
                                     descricao,
                                     status
                              FROM job
                              WHERE id
                              NOT IN(SELECT job_id FROM registro_backup WHERE data = ?);");

        $stmt->execute([$data]);

        return $stmt->fetchAll();

    }



}