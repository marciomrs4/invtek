<?php

namespace MRS\InventarioBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Tipoequipamento
 *
 * @ORM\Table(name="tipoEquipamento")
 * @ORM\Entity
 */
class Tipoequipamento
{

    /**
     * @var string
     *
     * @ORM\Column(name="icone", type="string", length=45, nullable=false)
     */
    private $icone;

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
     * @return string
     */
    public function getIcone()
    {
        return $this->icone;
    }

    /**
     * @param string $icone
     * @return Tipoequipamento
     */
    public function setIcone($icone)
    {
        $this->icone = $icone;
        return $this;
    }



    /**
     * Set descricao
     *
     * @param string $descricao
     * @return Tipoequipamento
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

    public function __toString()
    {
        return $this->getDescricao();
    }
}
