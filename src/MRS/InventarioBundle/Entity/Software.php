<?php

namespace MRS\InventarioBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Software
 *
 * @ORM\Table(name="software", indexes={@ORM\Index(name="fk_software_tipoSoftware1_idx", columns={"tipoSoftware_id"})})
 * @ORM\Entity(repositoryClass="MRS\InventarioBundle\Repository\SoftwareRepository")
 */
class Software
{
    /**
     * @var string
     *
     * @ORM\Column(name="descricao", type="string", length=45, nullable=false)
     */
    private $descricao;

    /**
     * @var string
     *
     * @ORM\Column(name="numerolicensa", type="integer", nullable=true)
     */
    private $numerolicensa;

    /**
     * @var string
     *
     * @ORM\Column(name="numeroreserva", type="integer", nullable=true)
     */
    private $numeroreserva;

    /**
     * @var string
     *
     * @ORM\Column(name="versao", type="string", length=45, nullable=true)
     */
    private $versao;

    /**
     * @var string
     *
     * @ORM\Column(name="serial", type="string", length=45, nullable=true)
     */
    private $serial;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var \MRS\InventarioBundle\Entity\Tiposoftware
     *
     * @ORM\ManyToOne(targetEntity="MRS\InventarioBundle\Entity\Tiposoftware")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="tipoSoftware_id", referencedColumnName="id")
     * })
     */
    private $tiposoftware;


    /**
     * @var \MRS\InventarioBundle\Entity\FornecedorSoftware
     *
     * @ORM\ManyToOne(targetEntity="MRS\InventarioBundle\Entity\FornecedorSoftware")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="fornecedor_software_id", referencedColumnName="id")
     * })
     * @Assert\NotBlank(message="Fornecedor é obrigatório")
     */
    private $fornecedor;



    /**
     * Set descricao
     *
     * @param string $descricao
     * @return Software
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
     * Set numerolicensa
     *
     * @param string $numerolicensa
     * @return Software
     */
    public function setNumerolicensa($numerolicensa)
    {
        $this->numerolicensa = $numerolicensa;

        return $this;
    }

    /**
     * Get numerolicensa
     *
     * @return string
     */
    public function getNumerolicensa()
    {
        return $this->numerolicensa;
    }

    /**
     * Set numeroreserva
     *
     * @param string $numeroreserva
     * @return Software
     */
    public function setNumeroReserva($numeroreserva)
    {
        $this->numeroreserva = $numeroreserva;

        return $this;
    }

    /**
     * Get numeroreserva
     *
     * @return string
     */
    public function getNumeroReserva()
    {
        return $this->numeroreserva;
    }

    /**
     * Set versao
     *
     * @param string $versao
     * @return Software
     */
    public function setVersao($versao)
    {
        $this->versao = $versao;

        return $this;
    }

    /**
     * Get versao
     *
     * @return string 
     */
    public function getVersao()
    {
        return $this->versao;
    }

    /**
     * Set serial
     *
     * @param string $serial
     * @return Software
     */
    public function setSerial($serial)
    {
        $this->serial = $serial;

        return $this;
    }

    /**
     * Get serial
     *
     * @return string 
     */
    public function getSerial()
    {
        return $this->serial;
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
     * Set tiposoftware
     *
     * @param \MRS\InventarioBundle\Entity\Tiposoftware $tiposoftware
     * @return Software
     */
    public function setTiposoftware(\MRS\InventarioBundle\Entity\Tiposoftware $tiposoftware = null)
    {
        $this->tiposoftware = $tiposoftware;

        return $this;
    }

    /**
     * Get tiposoftware
     *
     * @return \MRS\InventarioBundle\Entity\Tiposoftware 
     */
    public function getTiposoftware()
    {
        return $this->tiposoftware;
    }

    public function __toString()
    {
        return $this->getDescricao();
    }

    /**
     * Set fornecedor
     *
     * @param \MRS\InventarioBundle\Entity\FornecedorSoftware $fornecedor
     *
     * @return Software
     */
    public function setFornecedor(\MRS\InventarioBundle\Entity\FornecedorSoftware $fornecedor = null)
    {
        $this->fornecedor = $fornecedor;

        return $this;
    }

    /**
     * Get fornecedor
     *
     * @return \MRS\InventarioBundle\Entity\FornecedorSoftware
     */
    public function getFornecedor()
    {
        return $this->fornecedor;
    }
}
