<?php

namespace MRS\InventarioBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Movimentacao
 *
 * @ORM\Table(name="movimentacao", indexes={@ORM\Index(name="fk_movimentacao_tipoMovimentacao1_idx", columns={"tipoMovimentacao_id"}), @ORM\Index(name="fk_movimentacao_motivoMovimentacao1_idx", columns={"motivoMovimentacao_id"}), @ORM\Index(name="fk_movimentacao_usuario1_idx", columns={"usuario_id_criador"}), @ORM\Index(name="fk_movimentacao_usuario2_idx", columns={"usuario_id_origem"}), @ORM\Index(name="fk_movimentacao_usuario3_idx", columns={"usuario_id_destino"})})
 * @ORM\Entity(repositoryClass="MRS\InventarioBundle\Repository\MovimentacaoRepository")
 */
class Movimentacao
{
    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dataHora", type="datetime", nullable=false)
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
     * @var \MRS\InventarioBundle\Entity\Usuario
     *
     * @ORM\ManyToOne(targetEntity="MRS\InventarioBundle\Entity\Usuario")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="usuario_id_destino", referencedColumnName="id")
     * })
     * @Assert\NotBlank(message="Deve haver um usuário Destino")
     */
    private $usuarioDestino;

    /**
     * @var \MRS\InventarioBundle\Entity\Usuario
     *
     * @ORM\ManyToOne(targetEntity="MRS\InventarioBundle\Entity\Usuario")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="usuario_id_origem", referencedColumnName="id")
     * })
     * @Assert\NotBlank(message="Deve haver um usuário Origem")
     */
    private $usuarioOrigem;

    /**
     * @var \MRS\InventarioBundle\Entity\Usuario
     *
     * @ORM\ManyToOne(targetEntity="MRS\InventarioBundle\Entity\Usuario")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="usuario_id_criador", referencedColumnName="id")
     * })
     * @Assert\NotBlank(message="Deve haver um usuário Criador")
     */
    private $usuarioCriador;

    /**
     * @var \MRS\InventarioBundle\Entity\Motivomovimentacao
     *
     * @ORM\ManyToOne(targetEntity="MRS\InventarioBundle\Entity\Motivomovimentacao")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="motivoMovimentacao_id", referencedColumnName="id")
     * })
     * @Assert\NotBlank(message="Deve haver um motivo de movimentação")
     */
    private $motivomovimentacao;

    /**
     * @var \MRS\InventarioBundle\Entity\Tipomovimentacao
     *
     * @ORM\ManyToOne(targetEntity="MRS\InventarioBundle\Entity\Tipomovimentacao")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="tipoMovimentacao_id", referencedColumnName="id")
     * })
     * @Assert\NotBlank(message="Deve haver um tipo de movimentação")
     */
    private $tipomovimentacao;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="status", type="boolean")
     */
    private $status;

    public function __construct()
    {
        $this->datahora = new \DateTime('now');
    }



    /**
     * @return boolean
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param boolean $status
     * @return Movimentacao
     */
    public function setStatus($status)
    {
        $this->status = $status;
        return $this;
    }

    /**
     * Set datahora
     *
     * @param \DateTime $datahora
     * @return Movimentacao
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
     * Set usuarioDestino
     *
     * @param \MRS\InventarioBundle\Entity\Usuario $usuarioDestino
     * @return Movimentacao
     */
    public function setUsuarioDestino(\MRS\InventarioBundle\Entity\Usuario $usuarioDestino = null)
    {
        $this->usuarioDestino = $usuarioDestino;

        return $this;
    }

    /**
     * Get usuarioDestino
     *
     * @return \MRS\InventarioBundle\Entity\Usuario 
     */
    public function getUsuarioDestino()
    {
        return $this->usuarioDestino;
    }

    /**
     * Set usuarioOrigem
     *
     * @param \MRS\InventarioBundle\Entity\Usuario $usuarioOrigem
     * @return Movimentacao
     */
    public function setUsuarioOrigem(\MRS\InventarioBundle\Entity\Usuario $usuarioOrigem = null)
    {
        $this->usuarioOrigem = $usuarioOrigem;

        return $this;
    }

    /**
     * Get usuarioOrigem
     *
     * @return \MRS\InventarioBundle\Entity\Usuario 
     */
    public function getUsuarioOrigem()
    {
        return $this->usuarioOrigem;
    }

    /**
     * Set usuarioCriador
     *
     * @param \MRS\InventarioBundle\Entity\Usuario $usuarioCriador
     * @return Movimentacao
     */
    public function setUsuarioCriador(\MRS\InventarioBundle\Entity\Usuario $usuarioCriador = null)
    {
        $this->usuarioCriador = $usuarioCriador;

        return $this;
    }

    /**
     * Get usuarioCriador
     *
     * @return \MRS\InventarioBundle\Entity\Usuario 
     */
    public function getUsuarioCriador()
    {
        return $this->usuarioCriador;
    }

    /**
     * Set motivomovimentacao
     *
     * @param \MRS\InventarioBundle\Entity\Motivomovimentacao $motivomovimentacao
     * @return Movimentacao
     */
    public function setMotivomovimentacao(\MRS\InventarioBundle\Entity\Motivomovimentacao $motivomovimentacao = null)
    {
        $this->motivomovimentacao = $motivomovimentacao;

        return $this;
    }

    /**
     * Get motivomovimentacao
     *
     * @return \MRS\InventarioBundle\Entity\Motivomovimentacao 
     */
    public function getMotivomovimentacao()
    {
        return $this->motivomovimentacao;
    }

    /**
     * Set tipomovimentacao
     *
     * @param \MRS\InventarioBundle\Entity\Tipomovimentacao $tipomovimentacao
     * @return Movimentacao
     */
    public function setTipomovimentacao(\MRS\InventarioBundle\Entity\Tipomovimentacao $tipomovimentacao = null)
    {
        $this->tipomovimentacao = $tipomovimentacao;

        return $this;
    }

    /**
     * Get tipomovimentacao
     *
     * @return \MRS\InventarioBundle\Entity\Tipomovimentacao 
     */
    public function getTipomovimentacao()
    {
        return $this->tipomovimentacao;
    }

    public function __toString()
    {
        return (string) $this->getId() . '  | ' . $this->getDatahora()->format('d-m-Y H:i:s');
    }
}
