<?php
/**
 * Created by PhpStorm.
 * User: marcio
 * Date: 03/08/16
 * Time: 18:26
 */
namespace MRS\InventarioBundle\Repository;


use Doctrine\ORM\EntityRepository;

class AcompanhamentoRepository extends EntityRepository
{

    private function queryStringBase()
    {
        return 'SELECT E.id, E.descricao, E.patrimonio, E.numeroSerie,
	              (SELECT descricao FROM tipoEquipamento where id = E.tipoEquipamento_id) AS tipoEquipamento,
	              (SELECT nome FROM centro_movimentacao WHERE id = E.centro_movimentacao_id) AS centroMovimentacao,
                    max(A.id) AS acompanhamento_id,
                  (SELECT  nome FROM tipoAcompanhamento WHERE id = A.tipoAcompanhamento_id) AS tipoAcompanhamento,
                    max(A.dataHora) AS acompanhamento_data,
                  (SELECT tempo_prevencao FROM centro_movimentacao WHERE id = E.centro_movimentacao_id) AS tempoPrevencao
                FROM equipamento AS E
                LEFT JOIN acompanhamento AS A
                ON E.id = A.equipamento_id
                WHERE E.centro_movimentacao_id LIKE ?
                AND E.tipoEquipamento_id LIKE ?
                AND A.tipoAcompanhamento_id LIKE ?
                GROUP BY E.id, E.patrimonio, tipoAcompanhamento
                ORDER BY acompanhamento_data;';
    }


    private function validateField($field)
    {
        if(empty($field)){
            return '%';
        }else{
            return $field;
        }
    }

    public function getAllAcompanhamento($form)
    {

        $conn = $this->getEntityManager()->getConnection();

        $stmt = $conn->prepare($this->queryStringBase());

        $stmt->execute(array($this->validateField($form['centroMovimentacao']),
                             $this->validateField($form['tipoequipamento']),
                             $this->validateField($form['tipoAcompanhamento'])));

        return $stmt->fetchAll();
    }

    public function getAllEquipamentoNoAcompanhamento($form)
    {
        $query = ("SELECT E.id, E.descricao, E.patrimonio, E.numeroSerie,
                        (SELECT descricao FROM tipoEquipamento where id = E.tipoEquipamento_id) AS tipoEquipamento,
                        (SELECT nome FROM centro_movimentacao WHERE id = E.centro_movimentacao_id) AS centroMovimentacao,
                        max(A.id) AS acompanhamento_id,
                       (SELECT  nome FROM tipoAcompanhamento WHERE id = A.tipoAcompanhamento_id) AS tipoAcompanhamento,
                        max(A.dataHora) AS acompanhamento_data
                    FROM equipamento AS E
                    LEFT JOIN acompanhamento AS A
                    ON E.id = A.equipamento_id
                    WHERE E.centro_movimentacao_id LIKE ?
                    AND E.tipoEquipamento_id LIKE ?
                    AND A.tipoAcompanhamento_id IS NULL
                    GROUP BY E.id, E.patrimonio, tipoAcompanhamento
                    ORDER BY acompanhamento_data;");

        $conn = $this->getEntityManager()->getConnection();

        $stmt = $conn->prepare($query);

        $stmt->execute(array($this->validateField($form['centroMovimentacao']),
                             $this->validateField($form['tipoequipamento'])));

        return $stmt->fetchAll();
    }

}