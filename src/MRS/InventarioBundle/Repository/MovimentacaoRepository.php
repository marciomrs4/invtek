<?php
/**
 * Created by PhpStorm.
 * User: marcio
 * Date: 03/08/16
 * Time: 18:26
 */
namespace MRS\InventarioBundle\Repository;


use Doctrine\ORM\EntityRepository;

class MovimentacaoRepository extends EntityRepository
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

    public function reportMovimentacao($dataForm = array())
    {
        $query = "SELECT MOV.id AS 'id', TIP.descricao AS 'tipoEquipamento', FORN.nome AS 'fornecedor', MAR.nome AS 'marca', EQU.patrimonio AS 'patrimonio',
                        TIM.nome AS 'tipoMovimentacao', USUO.nome AS 'usuarioOrigem', USUD.nome AS 'usuarioDestino',
                        MOT.descricao AS 'motivoMovimentacao', MOV.dataHora AS 'dataMovimentacao', EQU.data_compra AS 'dataCompra',
                        EQU.numeroSerie AS 'numeroSerie', IF (EQU.status = 1, 'Aberto', 'Finalizado')  AS 'status',
                        CEN.nome AS 'centroMovimentacao', EQU.descricao AS 'descricao', EQU.observacao AS 'observacao'
                    FROM movimentacao AS MOV
                        INNER JOIN itens_movimentacao AS ITM
                        ON MOV.id = ITM.movimentacao_id
                        INNER JOIN equipamento AS EQU
                        ON ITM.movimentacao_id = EQU.tipoEquipamento_id
                        INNER JOIN tipoEquipamento AS TIP
                        ON EQU.tipoEquipamento_id = TIP.id
                        INNER JOIN fornecedor AS FORN
                     ON EQU.fornecedor_id = FORN.id
                        INNER JOIN marca AS MAR
                     ON EQU.marca_id = MAR.id
                        INNER JOIN tipoMovimentacao AS TIM
                        ON TIM.id = MOV.tipoMovimentacao_id
                        INNER JOIN usuario AS USUO
                        ON USUO.id = MOV.usuario_id_origem
                        INNER JOIN usuario AS USUD
                        ON USUD.id = MOV.usuario_id_destino
                        INNER JOIN motivoMovimentacao AS MOT
                        ON MOT.id = MOV.motivoMovimentacao_id
                        INNER JOIN centro_movimentacao AS CEN
                        ON EQU.centro_movimentacao_id = CEN.id

                    WHERE EQU.tipoEquipamento_id LIKE '%'
                        AND EQU.fornecedor_id LIKE '%'
                        AND EQU.marca_id LIKE '%'
                        AND (EQU.patrimonio LIKE '%' OR EQU.patrimonio IS NULL)
                        AND MOV.dataHora >= '2016-06-26 00:00:01'
                        AND MOV.dataHora <= '2016-08-26 23:59:59'
                        AND MOV.tipoMovimentacao_id LIKE '%'
                        AND MOV.tipoMovimentacao_id LIKE '%'
                        AND (EQU.numeroSerie LIKE '%' OR EQU.numeroSerie IS NULL)
                        AND EQU.status LIKE '%'
                        AND EQU.centro_movimentacao_id LIKE '%'

                    ORDER BY MOV.dataHora, TIM.nome, MOT.descricao";

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