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


    public function listInventario($dataForm = array())
    {
        $query = "SELECT EQU.id AS 'id',  CEN.nome AS 'centroMovimentacao', TIP.descricao AS 'tipoEquipamento',
                           EQU.patrimonio AS 'patrimonio', EQU.numeroSerie AS 'numeroSerie',
                           IF (EQU.status = 1, 'Ativo', 'Inativo')  AS 'status'
                    FROM equipamento AS EQU
                     INNER JOIN tipoEquipamento AS TIP
                     ON EQU.tipoEquipamento_id = TIP.id
                     INNER JOIN centro_movimentacao AS CEN
                     ON EQU.centro_movimentacao_id = CEN.id
                    WHERE EQU.centro_movimentacao_id LIKE ?
                        AND EQU.tipoEquipamento_id LIKE ?
                        AND EQU.status LIKE ?
                    ORDER BY CEN.nome, TIP.descricao, EQU.patrimonio, EQU.numeroSerie";

        $stmt = $this->prepareStmt($query);

        $stmt->execute(array(
            "{$this->emptyValue($dataForm['centroMovimentacao'])}",
            "{$this->emptyValue($dataForm['tipoequipamento'])}",
            "{$this->emptyValue($dataForm['status'])}",
        ));

        return $stmt->fetchAll();

    }


    public function equipamentosComprados($dataForm = array())
    {

        $query = "SELECT  EQU.id, TIP.descricao AS 'tipoEquipamento' ,
                     MAR.nome AS 'marca', FORN.nome AS 'fornecedor', EQU.patrimonio AS 'patrimonio',
                     EQU.numeroSerie AS 'numeroSerie', ANE.nome AS 'nome', EQU.data_compra AS 'dataCompra'
                    FROM equipamento AS EQU
                     INNER JOIN tipoEquipamento as TIP
                     ON EQU.tipoEquipamento_id = TIP.id
                     INNER JOIN marca AS MAR
                     ON EQU.marca_id = MAR.id
                     INNER JOIN fornecedor AS FORN
                     ON EQU.fornecedor_id = FORN.id
                     LEFT JOIN anexo AS ANE
                     ON EQU.id = ANE.equipamento_id
                    WHERE EQU.tipoEquipamento_id LIKE ?
                     AND EQU.data_compra >= ?
                     AND EQU.data_compra <= ?
	                GROUP BY EQU.id, TIP.descricao, MAR.nome, FORN.nome, EQU.patrimonio,
			                 EQU.numeroSerie, ANE.nome, EQU.data_compra
                    ORDER BY 5 DESC";
        $stmt = $this->prepareStmt($query);

        $stmt->execute(array(
            "{$this->emptyValue($dataForm['tipoequipamento'])}",
            "{$dataForm['dataCompraA']}",
            "{$dataForm['dataCompraB']}"
        ));

        return $stmt->fetchAll();

    }


    public function equipamentosSemGarantia($dataForm = array())
    {

        $query = "SELECT  EQU.id AS 'id', TIP.descricao AS 'tipoEquipamento',
                        FORN.nome AS 'fornecedor', MAR.nome AS 'marca', EQU.patrimonio AS 'patrimonio',
                        EQU.validade AS 'validade', EQU.numeroSerie AS 'numeroSerie',
                        IF (EQU.status = 1, 'Ativo', 'Inativo')  AS 'status',
                        CEN.nome AS 'centroMovimentacao', EQU.descricao AS 'descricao', EQU.observacao AS 'observacao'
                    FROM equipamento AS EQU
                     INNER JOIN tipoEquipamento as TIP
                     ON EQU.tipoEquipamento_id = TIP.id
                     INNER JOIN marca AS MAR
                     ON EQU.marca_id = MAR.id
                     INNER JOIN fornecedor AS FORN
                     ON EQU.fornecedor_id = FORN.id
                     INNER JOIN centro_movimentacao as CEN
   	                 ON EQU.centro_movimentacao_id = CEN.id
                     LEFT JOIN anexo AS ANE
                     ON EQU.id = ANE.equipamento_id
                    WHERE EQU.tipoEquipamento_id LIKE ?
                     AND EQU.centro_movimentacao_id LIKE ?
                     AND EQU.validade >= ?
                     AND EQU.validade <= ?
                     AND EQU.status LIKE ?
                    GROUP BY EQU.id, TIP.descricao, EQU.status, MAR.nome, FORN.nome, EQU.patrimonio,
                             EQU.numeroSerie, ANE.nome, EQU.data_compra
                    ORDER BY 6 ASC;";
        $stmt = $this->prepareStmt($query);

        $stmt->execute(array(
            "{$this->emptyValue($dataForm['tipoequipamento'])}",
            "{$this->emptyValue($dataForm['centroMovimentacao'])}",
            "{$dataForm['dataExperiedA']}",
            "{$dataForm['dataExperiedB']}",
            "{$dataForm['status']}"
        ));

        return $stmt->fetchAll();

    }

    public function chartEquipamentoByCentroMotivacao($data = array())
    {
        $query = "select
                    count(tipoEquipamento_id) as 'quantidade',
                    concat(
                        (SELECT nome
                            FROM centro_movimentacao
                            WHERE id = centro_movimentacao_id),' - ',
                        (SELECT descricao
                            FROM tipoEquipamento
                            WHERE id = tipoEquipamento_id)) AS 'centro_equipamento'
                    from equipamento
                    WHERE  tipoEquipamento_id LIKE ?
                    AND centro_movimentacao_id LIKE ?
                    group by tipoEquipamento_id,
                             centro_movimentacao_id
                    order by quantidade DESC;";

        $stmt = $this->prepareStmt($query);

        $stmt->execute(array($this->emptyValue($data['tipoequipamento']),
                             $this->emptyValue($data['centroMovimentacao'])));

        return $stmt->fetchAll();

    }

}