<?php

namespace MRS\InventarioBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Equipamento
 *
 * @ORM\Table(name="equipamento", indexes={@ORM\Index(name="fk_equipamento_tipoEquipamento1_idx", columns={"tipoEquipamento_id"}), @ORM\Index(name="fk_equipamento_forcedor1_idx", columns={"fornecedor_id"}), @ORM\Index(name="fk_equipamento_marca1_idx", columns={"marca_id"}), @ORM\Index(name="fk_equipamento_centro_movimentacao1_idx", columns={"centro_movimentacao_id"})})
 * @ORM\Entity(repositoryClass="MRS\InventarioBundle\Repository\EquipamentoRepository")
 */
class Equipamento
{
    /**
     * @var string
     *
     * @ORM\Column(name="nome", type="string", length=255, nullable=false)
     * @Assert\NotBlank(message="O nome do equipamento é obrigatório.")
     */
    private $nome;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="validade", type="date", nullable=false)
     */
    private $validade;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="data_compra", type="date", nullable=true)
     */
    private $dataCompra;


    /**
     * @var string
     *
     * @ORM\Column(name="numeroSerie", type="string", length=255, nullable=false)
     */
    private $numeroserie;

    /**
     * @var boolean
     *
     * @ORM\Column(name="status", type="boolean", nullable=false)
     */
    private $status;

    /**
     * @var string
     *
     * @ORM\Column(name="patrimonio", type="string", length=255, nullable=true)
     */
    private $patrimonio;

    /**
     * @var string
     *
     * @ORM\Column(name="descricao", type="string", length=255, nullable=true)
     */
    private $descricao;

    /**
     * @var string
     *
     * @ORM\Column(name="observacao", type="text", length=65535, nullable=true)
     */
    private $observacao;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var \MRS\InventarioBundle\Entity\CentroMovimentacao
     *
     * @ORM\ManyToOne(targetEntity="MRS\InventarioBundle\Entity\CentroMovimentacao")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="centro_movimentacao_id", referencedColumnName="id")
     * })
     * @Assert\NotBlank(message="O centro de movimentação do equipamento é obrigatório.")
     */
    private $centroMovimentacao;

    /**
     * @var \MRS\InventarioBundle\Entity\Marca
     *
     * @ORM\ManyToOne(targetEntity="MRS\InventarioBundle\Entity\Marca")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="marca_id", referencedColumnName="id")
     * })
     * @Assert\NotBlank(message="A marca do equipamento é obrigatório.")
     */
    private $marca;

    /**
     * @var \MRS\InventarioBundle\Entity\Fornecedor
     *
     * @ORM\ManyToOne(targetEntity="MRS\InventarioBundle\Entity\Fornecedor")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="fornecedor_id", referencedColumnName="id")
     * })
     * @Assert\NotBlank(message="O fornecedor do equipamento é obrigatório.")
     */
    private $fornecedor;

    /**
     * @var \MRS\InventarioBundle\Entity\Tipoequipamento
     *
     * @ORM\ManyToOne(targetEntity="MRS\InventarioBundle\Entity\Tipoequipamento")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="tipoEquipamento_id", referencedColumnName="id")
     * })
     * @Assert\NotBlank(message="O tipo de equipamento do equipamento é obrigatório.")
     */
    private $tipoequipamento;


    public function __construct()
    {
        $this->status = true;

        $date = new \DateTime('now');

        $this->validade = $date;

        $this->dataCompra = $date;
    }


    /**
     * Set nome
     *
     * @param string $nome
     * @return Equipamento
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
     * Set validade
     *
     * @param \DateTime $validade
     * @return Equipamento
     */
    public function setValidade($validade)
    {
        $this->validade = $validade;

        return $this;
    }

    /**
     * Get validade
     *
     * @return \DateTime
     */
    public function getValidade()
    {
        return $this->validade;
    }

    /**
     * @return \DateTime
     */
    public function getDataCompra()
    {
        return $this->dataCompra;
    }

    /**
     * @param \DateTime $dataCompra
     * @return Equipamento
     */
    public function setDataCompra($dataCompra)
    {
        $this->dataCompra = $dataCompra;
        return $this;
    }


    /**
     * Set numeroserie
     *
     * @param string $numeroserie
     * @return Equipamento
     */
    public function setNumeroserie($numeroserie)
    {
        $this->numeroserie = $numeroserie;

        return $this;
    }

    /**
     * Get numeroserie
     *
     * @return string
     */
    public function getNumeroserie()
    {
        return $this->numeroserie;
    }

    /**
     * Set status
     *
     * @param boolean $status
     * @return Equipamento
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status
     *
     * @return boolean
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set patrimonio
     *
     * @param string $patrimonio
     * @return Equipamento
     */
    public function setPatrimonio($patrimonio)
    {
        $this->patrimonio = $patrimonio;

        return $this;
    }

    /**
     * Get patrimonio
     *
     * @return string
     */
    public function getPatrimonio()
    {
        return $this->patrimonio;
    }

    /**
     * Set descricao
     *
     * @param string $descricao
     * @return Equipamento
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
     * Set observacao
     *
     * @param string $observacao
     * @return Equipamento
     */
    public function setObservacao($observacao)
    {
        $this->observacao = $observacao;

        return $this;
    }

    /**
     * Get observacao
     *
     * @return string
     */
    public function getObservacao()
    {
        return $this->observacao;
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
     * Set centroMovimentacao
     *
     * @param \MRS\InventarioBundle\Entity\CentroMovimentacao $centroMovimentacao
     * @return Equipamento
     */
    public function setCentroMovimentacao(\MRS\InventarioBundle\Entity\CentroMovimentacao $centroMovimentacao = null)
    {
        $this->centroMovimentacao = $centroMovimentacao;

        return $this;
    }

    /**
     * Get centroMovimentacao
     *
     * @return \MRS\InventarioBundle\Entity\CentroMovimentacao
     */
    public function getCentroMovimentacao()
    {
        return $this->centroMovimentacao;
    }

    /**
     * Set marca
     *
     * @param \MRS\InventarioBundle\Entity\Marca $marca
     * @return Equipamento
     */
    public function setMarca(\MRS\InventarioBundle\Entity\Marca $marca = null)
    {
        $this->marca = $marca;

        return $this;
    }

    /**
     * Get marca
     *
     * @return \MRS\InventarioBundle\Entity\Marca
     */
    public function getMarca()
    {
        return $this->marca;
    }

    /**
     * Set fornecedor
     *
     * @param \MRS\InventarioBundle\Entity\Fornecedor $fornecedor
     * @return Equipamento
     */
    public function setFornecedor(\MRS\InventarioBundle\Entity\Fornecedor $fornecedor = null)
    {
        $this->fornecedor = $fornecedor;

        return $this;
    }

    /**
     * Get fornecedor
     *
     * @return \MRS\InventarioBundle\Entity\Fornecedor
     */
    public function getFornecedor()
    {
        return $this->fornecedor;
    }

    /**
     * Set tipoequipamento
     *
     * @param \MRS\InventarioBundle\Entity\Tipoequipamento $tipoequipamento
     * @return Equipamento
     */
    public function setTipoequipamento(\MRS\InventarioBundle\Entity\Tipoequipamento $tipoequipamento = null)
    {
        $this->tipoequipamento = $tipoequipamento;

        return $this;
    }

    /**
     * Get tipoequipamento
     *
     * @return \MRS\InventarioBundle\Entity\Tipoequipamento
     */
    public function getTipoequipamento()
    {
        return $this->tipoequipamento;
    }

    public function __toString()
    {
        return $this->getNome();
    }
}
