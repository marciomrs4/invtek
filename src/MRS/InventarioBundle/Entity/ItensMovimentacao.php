<?php

namespace MRS\InventarioBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * ItensMovimentacao
 *
 * @ORM\Table(name="itens_movimentacao", indexes={@ORM\Index(name="fk_intens_movimentadocao_equipamento1_idx", columns={"equipamento_id"}), @ORM\Index(name="fk_intens_movimentadocao_movimentacao1_idx", columns={"movimentacao_id"})})
 * @ORM\Entity
 */
class ItensMovimentacao
{
    /**
     * @var string
     *
     * @ORM\Column(name="numero_chamado", type="string", length=45, nullable=true)
     */
    private $numeroChamado;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var \MRS\InventarioBundle\Entity\Movimentacao
     *
     * @ORM\ManyToOne(targetEntity="MRS\InventarioBundle\Entity\Movimentacao")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="movimentacao_id", referencedColumnName="id")
     * })
     */
    private $movimentacao;

    /**
     * @var \MRS\InventarioBundle\Entity\Equipamento
     *
     * @ORM\ManyToOne(targetEntity="MRS\InventarioBundle\Entity\Equipamento")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="equipamento_id", referencedColumnName="id")
     * })
     * @Assert\NotBlank(message="Deve ser informado um equipamento")
     */
    private $equipamento;



    /**
     * Set numeroChamado
     *
     * @param string $numeroChamado
     * @return ItensMovimentacao
     */
    public function setNumeroChamado($numeroChamado)
    {
        $this->numeroChamado = $numeroChamado;

        return $this;
    }

    /**
     * Get numeroChamado
     *
     * @return string 
     */
    public function getNumeroChamado()
    {
        return $this->numeroChamado;
    }

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set movimentacao
     *
     * @param \MRS\InventarioBundle\Entity\Movimentacao $movimentacao
     * @return ItensMovimentacao
     */
    public function setMovimentacao(\MRS\InventarioBundle\Entity\Movimentacao $movimentacao = null)
    {
        $this->movimentacao = $movimentacao;

        return $this;
    }

    /**
     * Get movimentacao
     *
     * @return \MRS\InventarioBundle\Entity\Movimentacao 
     */
    public function getMovimentacao()
    {
        return $this->movimentacao;
    }

    /**
     * Set equipamento
     *
     * @param \MRS\InventarioBundle\Entity\Equipamento $equipamento
     * @return ItensMovimentacao
     */
    public function setEquipamento(\MRS\InventarioBundle\Entity\Equipamento $equipamento = null)
    {
        $this->equipamento = $equipamento;

        return $this;
    }

    /**
     * Get equipamento
     *
     * @return \MRS\InventarioBundle\Entity\Equipamento 
     */
    public function getEquipamento()
    {
        return $this->equipamento;
    }
}
