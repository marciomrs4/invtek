<?php
/**
 * Created by PhpStorm.
 * User: marcio
 * Date: 03/08/16
 * Time: 18:26
 */
namespace MRS\InventarioBundle\Repository;


use Doctrine\ORM\EntityRepository;

class SoftwareRepository extends EntityRepository
{

    private function emptyValue($value)
    {
        if($value == ''){
            return '%';
        }
        return $value;
    }

    private function prepareStmt($query)
    {

        return $this->getEntityManager()
            ->getConnection()
            ->prepare($query);

    }

    public function countSoftwareOnEquipamento($software, $ativo = 1)
    {
        $query = "SELECT COUNT(software_id) AS quantidade_equipamento
                    FROM equipamento_has_software AS SOF
                    INNER JOIN equipamento AS EQU
                    ON EQU.id = SOF.equipamento_id
                    WHERE software_id = ?
                    AND EQU.status = ?";

        $stmt = $this->prepareStmt($query);

        $stmt->execute(array($software, $ativo));

        $valor = $stmt->fetch();

        return $valor['quantidade_equipamento'];


    }

}