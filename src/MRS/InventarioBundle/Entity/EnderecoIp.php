<?php

namespace MRS\InventarioBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * EnderecoIp
 *
 * @ORM\Table(name="endereco_ip", indexes={@ORM\Index(name="categoria_ip_fk_idx", columns={"status_id"}), @ORM\Index(name="tipo_acesso_ip_fk_idx", columns={"tipo_acesso_ip_id"})})
 * @ORM\Entity
 * @UniqueEntity(fields={"enderecoIp"},ignoreNull=true,message="Já existe um registro como este IP")
 * @Gedmo\Loggable()
 */
class EnderecoIp
{
    /**
     * @var string
     *
     * @ORM\Column(name="endereco_ip", type="string", length=45, nullable=false)
     * @Assert\NotBlank(message="Campo Obrigatório")
     * @Assert\Ip(message="Deve ser um IP valido")
     * @Gedmo\Versioned()
     */
    private $enderecoIp;

    /**
     * @var string
     *
     * @ORM\Column(name="nome", type="string", length=45, nullable=true)
     * @Assert\NotBlank(message="Campo Obrigatório")
     * @Gedmo\Versioned()
     */
    private $nome;

    /**
     * @var string
     *
     * @ORM\Column(name="observacao", type="text", length=65535, nullable=true)
     * @Gedmo\Versioned()
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
     * @var \MRS\InventarioBundle\Entity\TipoAcessoIp
     *
     * @ORM\ManyToOne(targetEntity="MRS\InventarioBundle\Entity\TipoAcessoIp")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="tipo_acesso_ip_id", referencedColumnName="id")
     * })
     * @Assert\NotBlank(message="Campo Obrigatório")
     * @Gedmo\Versioned()
     */
    private $tipoAcessoIp;

    /**
     * @var \MRS\InventarioBundle\Entity\StatusIp
     *
     * @ORM\ManyToOne(targetEntity="MRS\InventarioBundle\Entity\StatusIp")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="status_id", referencedColumnName="id")
     * })
     * @Assert\NotBlank(message="Campo Obrigatório")
     * @Gedmo\Versioned()
     */
    private $status;

    /**
     * @var \MRS\InventarioBundle\Entity\Unidade
     *
     * @ORM\ManyToOne(targetEntity="MRS\InventarioBundle\Entity\Unidade")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="unidade_id", referencedColumnName="id")
     * })
     * @Assert\NotBlank(message="Campo Obrigatório")
     * @Gedmo\Versioned()
     */
    private $unidade;

    /**
     * @var boolean
     * @ORM\Column(name="do_ping", type="boolean", nullable=true)
     * @Gedmo\Versioned()
     */
    private $doPing;

    /**
     * Set enderecoIp
     *
     * @param string $enderecoIp
     *
     * @return EnderecoIp
     */
    public function setEnderecoIp($enderecoIp)
    {
        $this->enderecoIp = $enderecoIp;

        return $this;
    }


    /**
     * Get enderecoIp
     *
     * @return string
     */
    public function getEnderecoIp()
    {
        return $this->enderecoIp;
    }

    /**
     * Set nome
     *
     * @param string $nome
     *
     * @return EnderecoIp
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
     * Set observacao
     *
     * @param string $observacao
     *
     * @return EnderecoIp
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
     * Set tipoAcessoIp
     *
     * @param \MRS\InventarioBundle\Entity\TipoAcessoIp $tipoAcessoIp
     *
     * @return EnderecoIp
     */
    public function setTipoAcessoIp(\MRS\InventarioBundle\Entity\TipoAcessoIp $tipoAcessoIp)
    {
        $this->tipoAcessoIp = $tipoAcessoIp;

        return $this;
    }

    /**
     * Get tipoAcessoIp
     *
     * @return \MRS\InventarioBundle\Entity\TipoAcessoIp
     */
    public function getTipoAcessoIp()
    {
        return $this->tipoAcessoIp;
    }

    /**
     * Set categoria
     *
     * @param \MRS\InventarioBundle\Entity\StatusIp $status
     *
     * @return EnderecoIp
     */
    public function setStatus(\MRS\InventarioBundle\Entity\StatusIp $status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status
     *
     * @return \MRS\InventarioBundle\Entity\StatusIp
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set unidade
     *
     * @param \MRS\InventarioBundle\Entity\Unidade $unidade
     *
     * @return EnderecoIp
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

    /**
     * @return boolean
     */
    public function isDoPing()
    {
        return $this->doPing;
    }

    /**
     * @param boolean $doPing
     * @return EnderecoIp
     */
    public function setDoPing($doPing)
    {
        $this->doPing = $doPing;
        return $this;
    }
}
