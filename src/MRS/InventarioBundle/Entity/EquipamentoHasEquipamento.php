<?php

namespace MRS\InventarioBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * EquipamentoHasEquipamento
 *
 * @ORM\Table(name="equipamento_has_equipamento", indexes={@ORM\Index(name="fk_equipamento_has_equipamento_equipamento2_idx", columns={"equipamento_filho_id"}), @ORM\Index(name="fk_equipamento_has_equipamento_equipamento1_idx", columns={"equipamento_pai_id"})})
 * @ORM\Entity
 */
class EquipamentoHasEquipamento
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var \MRS\InventarioBundle\Entity\Equipamento
     *
     * @ORM\ManyToOne(targetEntity="MRS\InventarioBundle\Entity\Equipamento")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="equipamento_filho_id", referencedColumnName="id")
     * })
     * @Assert\NotBlank(message="É necessario informar um equipamento")
     */
    private $equipamentoFilho;

    /**
     * @var \MRS\InventarioBundle\Entity\Equipamento
     *
     * @ORM\ManyToOne(targetEntity="MRS\InventarioBundle\Entity\Equipamento")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="equipamento_pai_id", referencedColumnName="id")
     * })
     */
    private $equipamentoPai;



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
     * Set equipamentoFilho
     *
     * @param \MRS\InventarioBundle\Entity\Equipamento $equipamentoFilho
     * @return EquipamentoHasEquipamento
     */
    public function setEquipamentoFilho(\MRS\InventarioBundle\Entity\Equipamento $equipamentoFilho = null)
    {
        $this->equipamentoFilho = $equipamentoFilho;

        return $this;
    }

    /**
     * Get equipamentoFilho
     *
     * @return \MRS\InventarioBundle\Entity\Equipamento 
     */
    public function getEquipamentoFilho()
    {
        return $this->equipamentoFilho;
    }

    /**
     * Set equipamentoPai
     *
     * @param \MRS\InventarioBundle\Entity\Equipamento $equipamentoPai
     * @return EquipamentoHasEquipamento
     */
    public function setEquipamentoPai(\MRS\InventarioBundle\Entity\Equipamento $equipamentoPai = null)
    {
        $this->equipamentoPai = $equipamentoPai;

        return $this;
    }

    /**
     * Get equipamentoPai
     *
     * @return \MRS\InventarioBundle\Entity\Equipamento 
     */
    public function getEquipamentoPai()
    {
        return $this->equipamentoPai;
    }
}
