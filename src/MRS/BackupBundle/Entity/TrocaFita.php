<?php

namespace MRS\BackupBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * TrocaFita
 *
 * @ORM\Table(name="troca_fita", indexes={@ORM\Index(name="fita_id_fk_idx", columns={"fita_id"})})
 * @ORM\Entity(repositoryClass="MRS\BackupBundle\Repository\TrocaFitaRepository")
 * @Gedmo\Loggable()
 */
class TrocaFita
{
    /**
     * @var \DateTime
     *
     * @ORM\Column(name="data_criacao", type="date", nullable=false)
     * @Gedmo\Versioned()
     * @Assert\NotBlank(message="A Data é obrigatória")
     */
    private $dataCriacao;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var \MRS\BackupBundle\Entity\Fita
     *
     * @ORM\ManyToOne(targetEntity="MRS\BackupBundle\Entity\Fita")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="fita_id", referencedColumnName="id")
     * })
     * @Gedmo\Versioned()
     * @Assert\NotBlank(message="A Fita é obrigatória")
     */
    private $fita;

    /**
     * @var string
     * @ORM\Column(name="usuario",type="string",nullable=false)
     * @Assert\NotBlank(message="O usuário é obrigatório")
     */
    private $user;

    public function __construct()
    {
        $data = new \DateTime('now');
        $this->dataCriacao = $data->modify('-1day');
    }


    /**
     * Set dataCriacao
     *
     * @param \DateTime $dataCriacao
     *
     * @return TrocaFita
     */
    public function setDataCriacao($dataCriacao)
    {
        $this->dataCriacao = $dataCriacao;

        return $this;
    }

    /**
     * Get dataCriacao
     *
     * @return \DateTime
     */
    public function getDataCriacao()
    {
        return $this->dataCriacao;
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
     * Set fita
     *
     * @param \MRS\BackupBundle\Entity\Fita $fita
     *
     * @return TrocaFita
     */
    public function setFita(\MRS\BackupBundle\Entity\Fita $fita = null)
    {
        $this->fita = $fita;

        return $this;
    }

    /**
     * Get fita
     *
     * @return \MRS\BackupBundle\Entity\Fita
     */
    public function getFita()
    {
        return $this->fita;
    }

    /**
     * Set user
     *
     * @param string $user
     *
     * @return TrocaFita
     */
    public function setUser($user)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return string
     */
    public function getUser()
    {
        return $this->user;
    }
}
