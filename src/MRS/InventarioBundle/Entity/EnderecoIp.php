<?php

namespace MRS\InventarioBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * EnderecoIp
 *
 * @ORM\Table(name="endereco_ip", indexes={@ORM\Index(name="categoria_ip_fk_idx", columns={"categoria_id"}), @ORM\Index(name="tipo_acesso_ip_fk_idx", columns={"tipo_acesso_ip_id"})})
 * @ORM\Entity
 */
class EnderecoIp
{
    /**
     * @var string
     *
     * @ORM\Column(name="endereco_ip", type="string", length=45, nullable=false)
     */
    private $enderecoIp;

    /**
     * @var string
     *
     * @ORM\Column(name="nome", type="string", length=45, nullable=true)
     */
    private $nome;

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
     * @var \MRS\InventarioBundle\Entity\TipoAcessoIp
     *
     * @ORM\ManyToOne(targetEntity="MRS\InventarioBundle\Entity\TipoAcessoIp")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="tipo_acesso_ip_id", referencedColumnName="id")
     * })
     */
    private $tipoAcessoIp;

    /**
     * @var \MRS\InventarioBundle\Entity\CategoriaIp
     *
     * @ORM\ManyToOne(targetEntity="MRS\InventarioBundle\Entity\CategoriaIp")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="categoria_id", referencedColumnName="id")
     * })
     */
    private $categoria;



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
     * @param \MRS\InventarioBundle\Entity\CategoriaIp $categoria
     *
     * @return EnderecoIp
     */
    public function setCategoria(\MRS\InventarioBundle\Entity\CategoriaIp $categoria)
    {
        $this->categoria = $categoria;

        return $this;
    }

    /**
     * Get categoria
     *
     * @return \MRS\InventarioBundle\Entity\CategoriaIp
     */
    public function getCategoria()
    {
        return $this->categoria;
    }
}
