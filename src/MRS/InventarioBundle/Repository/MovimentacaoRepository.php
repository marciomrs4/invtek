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

    private function prepareStmt($query)
    {

        return $this->getEntityManager()
            ->getConnection()
            ->prepare($query);

    }

    public function reportMovimentacao($dataForm = array())
    {
        $query = "SELECT  EQU.id AS 'id', EQU.nome AS 'equipamentoNome' , EQU.patrimonio AS 'patrimonio',
                          EQU.numeroSerie AS 'numeroSerie', COUNT(MOV.tipoMovimentacao_id) AS 'quantidadeMovimentacoes',
                          TIP.nome AS 'tipoMovimentacao'
                        FROM itens_movimentacao AS ITM
                         INNER JOIN movimentacao AS MOV
                            ON ITM.movimentacao_id = MOV.id
                         INNER JOIN tipoMovimentacao as TIP
                            ON MOV.tipoMovimentacao_id = TIP.id
                         INNER JOIN equipamento as EQU
                            ON ITM.equipamento_id = EQU.id
                        WHERE MOV.dataHora >= ?
                          AND MOV.dataHora <= ?
                        GROUP BY equipamento_id, MOV.tipoMovimentacao_id
                        ORDER BY 5 DESC, 1 DESC, EQU.patrimonio, EQU.numeroSerie";

        $stmt = $this->prepareStmt($query);

        $stmt->execute(array(
            "{$dataForm['dataMovimentacaoA']}",
            "{$dataForm['dataMovimentacaoB']}",
        ));

         return $stmt->fetchAll();

    }

    public function finAllOrderByData()
    {
        return $this->getEntityManager()
            ->createQueryBuilder('m')
            ->orderBy('m.datahora','DESC')
            ->getQuery()
            ->getResult();

    }


}