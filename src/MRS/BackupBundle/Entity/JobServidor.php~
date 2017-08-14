<?php

namespace MRS\BackupBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * JobServidor
 *
 * @ORM\Table(name="job_servidor", indexes={@ORM\Index(name="job_id_fk_idx", columns={"job_id"}), @ORM\Index(name="equipamento_id_fk_idx", columns={"equipamento_id"})})
 * @ORM\Entity
 */
class JobServidor
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var \MRS\InventarioBundle\Entity\Equipamento
     *
     * @ORM\ManyToOne(targetEntity="MRS\InventarioBundle\Entity\Equipamento")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="equipamento_id", referencedColumnName="id")
     * })
     * @Assert\NotBlank(message="Equipamento é obrigatório")
     */
    private $equipamento;

    /**
     * @var \MRS\BackupBundle\Entity\Job
     *
     * @ORM\ManyToOne(targetEntity="MRS\BackupBundle\Entity\Job")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="job_id", referencedColumnName="id")
     * })
     * @Assert\NotBlank(message="Job é obrigatório")
     */
    private $job;



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
     * Set equipamento
     *
     * @param \MRS\InventarioBundle\Entity\Equipamento $equipamento
     *
     * @return JobServidor
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

    /**
     * Set job
     *
     * @param \MRS\BackupBundle\Entity\Job $job
     *
     * @return JobServidor
     */
    public function setJob(\MRS\BackupBundle\Entity\Job $job = null)
    {
        $this->job = $job;

        return $this;
    }

    /**
     * Get job
     *
     * @return \MRS\BackupBundle\Entity\Job
     */
    public function getJob()
    {
        return $this->job;
    }
}
