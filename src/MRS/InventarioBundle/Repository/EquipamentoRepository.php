<?php
/**
 * Created by PhpStorm.
 * User: marcio
 * Date: 03/08/16
 * Time: 18:26
 */
namespace MRS\InventarioBundle\Repository;


use Doctrine\ORM\EntityRepository;

class EquipamentoRepository extends EntityRepository
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

    public function reportEquipamentos($dataForm = array())
    {
        $query = "SELECT EQU.id AS 'id', TIP.descricao AS 'tipoEquipamento',
                        FORN.nome AS 'fornecedor', MAR.nome AS 'marca', EQU.patrimonio AS 'patrimonio',
                        EQU.data_compra AS 'dataCompra', EQU.numeroSerie AS 'numeroSerie',
                        IF (EQU.status = 1, 'Ativo', 'Inativo')  AS 'status',
                        CEN.nome AS 'centroMovimentacao', EQU.descricao AS 'descricao', EQU.observacao AS 'observacao'
                    FROM equipamento AS EQU
                     INNER JOIN tipoEquipamento AS TIP
                     ON EQU.tipoEquipamento_id = TIP.id
                     INNER JOIN fornecedor AS FORN
                     ON EQU.fornecedor_id = FORN.id
                     INNER JOIN marca AS MAR
                     ON EQU.marca_id = MAR.id
                     INNER JOIN centro_movimentacao AS CEN
                     ON EQU.centro_movimentacao_id = CEN.id
                        WHERE EQU.tipoEquipamento_id LIKE ?
                            AND EQU.fornecedor_id LIKE ?
                            AND EQU.marca_id LIKE ?
                            AND (EQU.patrimonio LIKE ? OR EQU.patrimonio IS NULL)
                            AND EQU.data_compra >= ?
                            AND EQU.data_compra <= ?
                            AND (EQU.numeroSerie LIKE ? OR EQU.numeroSerie IS NULL)
                            AND EQU.status LIKE ?
                            AND EQU.centro_movimentacao_id LIKE ?
                     ORDER BY TIP.descricao, EQU.patrimonio, EQU.numeroSerie, EQU.status";

        $stmt = $this->prepareStmt($query);

        $stmt->execute(array(
            "{$this->emptyValue($dataForm['tipoequipamento'])}",
            "{$this->emptyValue($dataForm['fornecedor'])}",
            "{$this->emptyValue($dataForm['marca'])}",
            "%{$this->emptyValue($dataForm['patrimonio'])}%",
            "{$dataForm['dataCompraA']}",
            "{$dataForm['dataCompraB']}",
            "%{$this->emptyValue($dataForm['numeroserie'])}%",
            "{$this->emptyValue($dataForm['status'])}",
            "{$this->emptyValue($dataForm['centroMovimentacao'])}",
        ));

        return $stmt->fetchAll();

    }


}