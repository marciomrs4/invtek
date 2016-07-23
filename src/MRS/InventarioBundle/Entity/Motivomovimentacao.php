<?php

namespace MRS\InventarioBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Motivomovimentacao
 *
 * @ORM\Table(name="motivoMovimentacao", indexes={@ORM\Index(name="fk_motivoMovimentacao_tipoMovimentacao1_idx", columns={"tipoMovimentacao_id"})})
 * @ORM\Entity
 */
class Motivomovimentacao
{
    /**
     * @var string
     *
     * @ORM\Column(name="descricao", type="string", length=45, nullable=false)
     */
    private $descricao;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var \MRS\InventarioBundle\Entity\Tipomovimentacao
     *
     * @ORM\ManyToOne(targetEntity="MRS\InventarioBundle\Entity\Tipomovimentacao")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="tipoMovimentacao_id", referencedColumnName="id")
     * })
     */
    private $tipomovimentacao;



    /**
     * Set descricao
     *
     * @param string $descricao
     * @return Motivomovimentacao
     */
    public function setDescricao($descricao)
    {
        $this->descricao = $descricao;

        return $this;
    }

    /**
     * Get descricao
     *
     * @return string 
     */
    public function getDescricao()
    {
        return $this->descricao;
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
     * Set tipomovimentacao
     *
     * @param \MRS\InventarioBundle\Entity\Tipomovimentacao $tipomovimentacao
     * @return Motivomovimentacao
     */
    public function setTipomovimentacao(\MRS\InventarioBundle\Entity\Tipomovimentacao $tipomovimentacao = null)
    {
        $this->tipomovimentacao = $tipomovimentacao;

        return $this;
    }

    /**
     * Get tipomovimentacao
     *
     * @return \MRS\InventarioBundle\Entity\Tipomovimentacao 
     */
    public function getTipomovimentacao()
    {
        return $this->tipomovimentacao;
    }

    public function __toString()
    {
        return $this->getDescricao() . ' | ' . $this->getTipomovimentacao()->getNome();
    }
}
