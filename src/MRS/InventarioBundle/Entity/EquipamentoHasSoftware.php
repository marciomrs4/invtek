<?php

namespace MRS\InventarioBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * EquipamentoHasSoftware
 *
 * @ORM\Table(name="equipamento_has_software", indexes={@ORM\Index(name="fk_equipamento_has_software_software1_idx", columns={"software_id"}), @ORM\Index(name="fk_equipamento_has_software_equipamento1_idx", columns={"equipamento_id"})})
 * @ORM\Entity
 */
class EquipamentoHasSoftware
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
     * @var \MRS\InventarioBundle\Entity\Software
     *
     * @ORM\ManyToOne(targetEntity="MRS\InventarioBundle\Entity\Software")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="software_id", referencedColumnName="id")
     * })
     * @Assert\NotBlank(message="O software deve ser informado")
     */
    private $software;

    /**
     * @var \MRS\InventarioBundle\Entity\Equipamento
     *
     * @ORM\ManyToOne(targetEntity="MRS\InventarioBundle\Entity\Equipamento")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="equipamento_id", referencedColumnName="id")
     * })
     */
    private $equipamento;



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
     * Set software
     *
     * @param \MRS\InventarioBundle\Entity\Software $software
     * @return EquipamentoHasSoftware
     */
    public function setSoftware(\MRS\InventarioBundle\Entity\Software $software = null)
    {
        $this->software = $software;

        return $this;
    }

    /**
     * Get software
     *
     * @return \MRS\InventarioBundle\Entity\Software 
     */
    public function getSoftware()
    {
        return $this->software;
    }

    /**
     * Set equipamento
     *
     * @param \MRS\InventarioBundle\Entity\Equipamento $equipamento
     * @return EquipamentoHasSoftware
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
