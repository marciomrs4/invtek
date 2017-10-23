<?php

namespace MRS\BackupBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * Fita
 *
 * @ORM\Table(name="fita", uniqueConstraints={@ORM\UniqueConstraint(name="bar_code_UNIQUE", columns={"bar_code"})})
 * @ORM\Entity(repositoryClass="MRS\BackupBundle\Repository\FitaRepository")
 * @UniqueEntity(fields={"barCode"},ignoreNull=false,message="Já existe um registro com este código")
 * @Gedmo\Loggable()
 */
class Fita
{
    /**
     * @var string
     *
     * @ORM\Column(name="bar_code", type="string", length=45, nullable=false)
     * @Gedmo\Versioned()
     * @Assert\NotBlank(message="O BarCode é obrigatório")
     */
    private $barCode;

    /**
     * @var string
     *
     * @ORM\Column(name="ciclo", type="string", length=45, nullable=false)
     * @Gedmo\Versioned()
     * @Assert\NotBlank(message="O campo é obrigatório")
     */
    private $ciclo;

    /**
     * @var string
     *
     * @ORM\Column(name="jogo", type="string", length=45, nullable=false)
     * @Gedmo\Versioned()
     * @Assert\NotBlank(message="O campo é obrigatório")
     */
    private $jogo;

    /**
     * @var string
     *
     * @ORM\Column(name="descricao", type="string", length=255, nullable=false)
     * @Gedmo\Versioned()
     * @Assert\NotBlank(message="O campo é obrigatório")
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
     * @var \MRS\InventarioBundle\Entity\Unidade
     *
     * @ORM\ManyToOne(targetEntity="MRS\InventarioBundle\Entity\Unidade")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="unidade_id", referencedColumnName="id")
     * })
     * @Gedmo\Versioned()
     * @Assert\NotBlank(message="O Campo Unidade é obrigatório")
     */
    private $unidade;

    /**
     * @var \MRS\BackupBundle\Entity\TipoMidia
     *
     * @ORM\ManyToOne(targetEntity="MRS\BackupBundle\Entity\TipoMidia")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="midia_id", referencedColumnName="id")
     * })
     * @Gedmo\Versioned()
     * @Assert\NotBlank(message="O Campo midia é obrigatório")
     */
    private $midia;

    /**
     * Set barCode
     *
     * @param string $barCode
     *
     * @return Fita
     */
    public function setBarCode($barCode)
    {
        $this->barCode = $barCode;

        return $this;
    }

    /**
     * Get barCode
     *
     * @return string
     */
    public function getBarCode()
    {
        return $this->barCode;
    }

    /**
     * Set ciclo
     *
     * @param string $ciclo
     *
     * @return Fita
     */
    public function setCiclo($ciclo)
    {
        $this->ciclo = $ciclo;

        return $this;
    }

    /**
     * Get ciclo
     *
     * @return string
     */
    public function getCiclo()
    {
        return $this->ciclo;
    }

    /**
     * Set jogo
     *
     * @param string $jogo
     *
     * @return Fita
     */
    public function setJogo($jogo)
    {
        $this->jogo = $jogo;

        return $this;
    }

    /**
     * Get jogo
     *
     * @return string
     */
    public function getJogo()
    {
        return $this->jogo;
    }

    /**
     * Set descricao
     *
     * @param string $descricao
     *
     * @return Fita
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
        return $this->getDescricao() . ' | ' . $this->getBarCode();
    }

    /**
     * Set unidade
     *
     * @param \MRS\InventarioBundle\Entity\Unidade $unidade
     *
     * @return Fita
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
     * Set midia
     *
     * @param \MRS\BackupBundle\Entity\TipoMidia $midia
     *
     * @return Fita
     */
    public function setMidia(\MRS\BackupBundle\Entity\TipoMidia $midia = null)
    {
        $this->midia = $midia;

        return $this;
    }

    /**
     * Get midia
     *
     * @return \MRS\BackupBundle\Entity\TipoMidia
     */
    public function getMidia()
    {
        return $this->midia;
    }
}
