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

    public function listAllSoftware()
    {

        $query = "SELECT
                        id, descricao, versao, serial,
                        (SELECT descricao FROM tipoSoftware WHERE id = tipoSoftware_id) AS 'tiposoftware',
                        (SELECT nome FROM fornecedor_software WHERE id = fornecedor_software_id ) AS 'fornecedor',
                        numerolicensa, numeroreserva AS 'numeroReserva',

                        (SELECT COUNT(software_id)
                            FROM equipamento_has_software AS EQUI_SOF
                                INNER JOIN equipamento AS EQU
                                ON EQU.id = EQUI_SOF.equipamento_id
                                WHERE software_id = SOF.id
                                AND EQU.status = 1) AS quantidadeEquipamento,

                                (numerolicensa - (
                                        (SELECT COUNT(software_id)
                                            FROM equipamento_has_software AS EQUI_SOF
                                            INNER JOIN equipamento AS EQU
                                            ON EQU.id = EQUI_SOF.equipamento_id
                                            WHERE software_id = SOF.id
                                            AND EQU.status = 1)
                                         + numeroreserva)) AS disponiveis
                  FROM software AS SOF";

        $stmt = $this->prepareStmt($query);

        $stmt->execute();

        return $stmt->fetchAll();

    }

}