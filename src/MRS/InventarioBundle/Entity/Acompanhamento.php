<?php

namespace MRS\InventarioBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Acompanhamento
 *
 * @ORM\Table(name="acompanhamento", indexes={@ORM\Index(name="fk_companhamento_equipamento1_idx", columns={"equipamento_id"}), @ORM\Index(name="fk_acompanhamento_tipoAcompanhamento1_idx", columns={"tipoAcompanhamento_id"})})
 * @ORM\Entity(repositoryClass="MRS\InventarioBundle\Repository\AcompanhamentoRepository")
 */
class Acompanhamento
{
    /**
     * @var string
     *
     * @ORM\Column(name="descricao", type="text", length=65535, nullable=false)
     */
    private $descricao;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dataHora", type="datetime", nullable=true)
     */
    private $datahora;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var \MRS\InventarioBundle\Entity\Tipoacompanhamento
     *
     * @ORM\ManyToOne(targetEntity="MRS\InventarioBundle\Entity\Tipoacompanhamento")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="tipoAcompanhamento_id", referencedColumnName="id")
     * })
     */
    private $tipoacompanhamento;

    /**
     * @var \MRS\InventarioBundle\Entity\Equipamento
     *
     * @ORM\ManyToOne(targetEntity="MRS\InventarioBundle\Entity\Equipamento")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="equipamento_id", referencedColumnName="id")
     * })
     */
    private $equipamento;


    public function __construct()
    {
        $this->datahora = new \DateTime('now');
    }


    /**
     * Set descricao
     *
     * @param string $descricao
     * @return Acompanhamento
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
     * Set datahora
     *
     * @param \DateTime $datahora
     * @return Acompanhamento
     */
    public function setDatahora($datahora)
    {
        $this->datahora = $datahora;

        return $this;
    }

    /**
     * Get datahora
     *
     * @return \DateTime 
     */
    public function getDatahora()
    {
        return $this->datahora;
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
     * Set tipoacompanhamento
     *
     * @param \MRS\InventarioBundle\Entity\Tipoacompanhamento $tipoacompanhamento
     * @return Acompanhamento
     */
    public function setTipoacompanhamento(\MRS\InventarioBundle\Entity\Tipoacompanhamento $tipoacompanhamento = null)
    {
        $this->tipoacompanhamento = $tipoacompanhamento;

        return $this;
    }

    /**
     * Get tipoacompanhamento
     *
     * @return \MRS\InventarioBundle\Entity\Tipoacompanhamento 
     */
    public function getTipoacompanhamento()
    {
        return $this->tipoacompanhamento;
    }

    /**
     * Set equipamento
     *
     * @param \MRS\InventarioBundle\Entity\Equipamento $equipamento
     * @return Acompanhamento
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
