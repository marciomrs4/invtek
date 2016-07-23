<?php

namespace MRS\InventarioBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Componente
 *
 * @ORM\Table(name="componente", indexes={@ORM\Index(name="fk_componente_tipoComponente_idx", columns={"tipoComponente_id"})})
 * @ORM\Entity
 */
class Componente
{
    /**
     * @var string
     *
     * @ORM\Column(name="descricao", type="string", length=255, nullable=false)
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
     * @var \MRS\InventarioBundle\Entity\Tipocomponente
     *
     * @ORM\ManyToOne(targetEntity="MRS\InventarioBundle\Entity\Tipocomponente")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="tipoComponente_id", referencedColumnName="id")
     * })
     */
    private $tipocomponente;



    /**
     * Set descricao
     *
     * @param string $descricao
     * @return Componente
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
     * Set tipocomponente
     *
     * @param \MRS\InventarioBundle\Entity\Tipocomponente $tipocomponente
     * @return Componente
     */
    public function setTipocomponente(\MRS\InventarioBundle\Entity\Tipocomponente $tipocomponente = null)
    {
        $this->tipocomponente = $tipocomponente;

        return $this;
    }

    /**
     * Get tipocomponente
     *
     * @return \MRS\InventarioBundle\Entity\Tipocomponente 
     */
    public function getTipocomponente()
    {
        return $this->tipocomponente;
    }

    public function __toString()
    {
        return $this->getDescricao();
    }

}
