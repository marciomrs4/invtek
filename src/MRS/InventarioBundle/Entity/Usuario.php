<?php

namespace MRS\InventarioBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
/**
 * Usuario
 *
 * @ORM\Table(name="usuario", indexes={@ORM\Index(name="fk_usuario_departamento1_idx", columns={"departamento_id"})})
 * @ORM\Entity
 */
class Usuario
{
    /**
     * @var string
     *
     * @ORM\Column(name="nomeCompleto", type="string", length=255, nullable=false)
     */
    private $nomecompleto;

    /**
     * @var string
     *
     * @ORM\Column(name="observacao", type="text")
     */
    private $observacao;

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
     * @var \MRS\InventarioBundle\Entity\CentroMovimentacao
     *
     * @ORM\ManyToOne(targetEntity="MRS\InventarioBundle\Entity\CentroMovimentacao")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="departamento_id", referencedColumnName="id")
     * })
     */
    private $departamento;

    /**
     * @var \MRS\UserBundle\Entity\User
     *
     * @ORM\OneToOne(targetEntity="MRS\UserBundle\Entity\User", inversedBy="usuario")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     *
     */
    private $user_id;


    /**
     * @var boolean
     *
     * @ORM\Column(name="status", type="boolean")
     */
    private $status;

    public function __construct()
    {
        $this->status = true;
    }


    /**
     * @return string
     */
    public function getObservacao()
    {
        return $this->observacao;
    }

    /**
     * @param string $observacao
     * @return Usuario
     */
    public function setObservacao($observacao)
    {
        $this->observacao = $observacao;
        return $this;
    }


    /**
     * @return boolean
     */
    public function isStatus()
    {
        return $this->status;
    }

    /**
     * @param boolean $status
     * @return Usuario
     */
    public function setStatus($status)
    {
        $this->status = $status;
        return $this;
    }

    /**
     * @return \MRS\UserBundle\Entity\User
     */
    public function getUserId()
    {
        return $this->user_id;
    }

    /**
     * @param \MRS\UserBundle\Entity\User
     * @return Usuario
     */
    public function setUserId(\MRS\UserBundle\Entity\User $user_id = null)
    {
        $this->user_id = $user_id;
        return $this;
    }


    /**
     * Set nomecompleto
     *
     * @param string $nomecompleto
     * @return Usuario
     */
    public function setNomecompleto($nomecompleto)
    {
        $this->nomecompleto = $nomecompleto;

        return $this;
    }

    /**
     * Get nomecompleto
     *
     * @return string 
     */
    public function getNomecompleto()
    {
        return $this->nomecompleto;
    }



    /**
     * Set nome
     *
     * @param string $nome
     * @return Usuario
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
     * Set departamento
     *
     * @param \MRS\InventarioBundle\Entity\CentroMovimentacao $departamento
     * @return Usuario
     */
    public function setDepartamento(\MRS\InventarioBundle\Entity\CentroMovimentacao $departamento = null)
    {
        $this->departamento = $departamento;

        return $this;
    }

    /**
     * Get departamento
     *
     * @return \MRS\InventarioBundle\Entity\CentroMovimentacao 
     */
    public function getDepartamento()
    {
        return $this->departamento;
    }

    public function __toString()
    {
        return $this->getNomecompleto() . ' | ' .  $this->getDepartamento()->getNome();
    }
}
