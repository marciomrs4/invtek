<?php
/**
 * Created by PhpStorm.
 * User: marcio
 * Date: 03/08/16
 * Time: 18:26
 */
namespace MRS\InventarioBundle\Repository;


use Doctrine\ORM\EntityRepository;

class LicencaSoftwareRepository extends EntityRepository
{
    private function prepareStmt($query)
    {

        return $this->getEntityManager()
            ->getConnection()
            ->prepare($query);

    }


    public function countLicenca($softwareId)
    {
        $query = "SELECT sum(quantidade_total) AS quantidade_total
                  FROM licenca_software
                  WHERE software_id = ?";

        $stmt = $this->prepareStmt($query);

        $stmt->execute(array($softwareId));

        $valor = $stmt->fetch();

        return $valor['quantidade_total'];

    }



}