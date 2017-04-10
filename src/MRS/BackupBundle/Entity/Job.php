<?php

namespace MRS\BackupBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * Job
 *
 * @ORM\Table(name="job", indexes={@ORM\Index(name="tipo_job_fk_idx", columns={"tipo_job_id"})})
 * @ORM\Entity
 * @Gedmo\Loggable()
 */
class Job
{
    /**
     * @var string
     *
     * @ORM\Column(name="descricao", type="string", length=45, nullable=false)
     * @Gedmo\Versioned()
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
     * @var \MRS\BackupBundle\Entity\TipoJob
     *
     * @ORM\ManyToOne(targetEntity="MRS\BackupBundle\Entity\TipoJob")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="tipo_job_id", referencedColumnName="id")
     * })
     * @Gedmo\Versioned()
     */
    private $tipoJob;

    /**
     * @var \MRS\InventarioBundle\Entity\Unidade
     *
     * @ORM\ManyToOne(targetEntity="MRS\InventarioBundle\Entity\Unidade")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="unidade_id", referencedColumnName="id")
     * })
     * @Gedmo\Versioned()
     */
    private $unidade;



    /**
     * Set descricao
     *
     * @param string $descricao
     *
     * @return Job
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

    /**
     * Set tipoJob
     *
     * @param \MRS\BackupBundle\Entity\TipoJob $tipoJob
     *
     * @return Job
     */
    public function setTipoJob(\MRS\BackupBundle\Entity\TipoJob $tipoJob = null)
    {
        $this->tipoJob = $tipoJob;

        return $this;
    }

    /**
     * Get tipoJob
     *
     * @return \MRS\BackupBundle\Entity\TipoJob
     */
    public function getTipoJob()
    {
        return $this->tipoJob;
    }

    public function __toString()
    {
        return $this->getDescricao();
    }

    /**
     * Set unidade
     *
     * @param \MRS\InventarioBundle\Entity\Unidade $unidade
     *
     * @return Job
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
}
