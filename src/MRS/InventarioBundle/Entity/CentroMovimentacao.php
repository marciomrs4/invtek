<?php

namespace MRS\InventarioBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * CentroMovimentacao
 *
 * @ORM\Table(name="centro_movimentacao", indexes={@ORM\Index(name="fk_departamento_unidade1_idx", columns={"unidade_id"})})
 * @ORM\Entity
 */
class CentroMovimentacao
{
    /**
     * @var string
     *
     * @ORM\Column(name="nome", type="string", length=45, nullable=false)
     */
    private $nome;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var \MRS\InventarioBundle\Entity\Unidade
     *
     * @ORM\ManyToOne(targetEntity="MRS\InventarioBundle\Entity\Unidade")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="unidade_id", referencedColumnName="id")
     * })
     */
    private $unidade;



    /**
     * Set nome
     *
     * @param string $nome
     * @return CentroMovimentacao
     */
    public function setNome($nome)
    {
        $this->nome = $nome;

        return $this;
    }

    /**
     * Get nome
     *
     * @return string 
     */
    public function getNome()
    {
        return $this->nome;
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
     * Set unidade
     *
     * @param \MRS\InventarioBundle\Entity\Unidade $unidade
     * @return CentroMovimentacao
     */
    public function setUnidade(\MRS\InventarioBundle\Entity\Unidade $unidade = null)
    {
        $this->unidade = $unidade;

        return $this;
    }

    /**
     * Get unidade
     *
     * @return \MRS\InventarioBundle\Entity\Unidade 
     */
    public function getUnidade()
    {
        return $this->unidade;
    }

    public function __toString()
    {
        return $this->getNome();
    }
}
