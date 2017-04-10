<?php

namespace MRS\BackupBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * RegistroBackup
 *
 * @ORM\Table(name="registro_backup", indexes={@ORM\Index(name="registro_backup_job_fk_idx", columns={"job_id"}), @ORM\Index(name="registro_backup_status_fk_idx", columns={"status_id"})})
 * @ORM\Entity(repositoryClass="MRS\BackupBundle\Repository\RegistroBackupRepository")
 * @Vich\Uploadable
 * @Gedmo\Loggable()
 */
class RegistroBackup
{
    /**
     * @var \DateTime
     *
     * @ORM\Column(name="data", type="date", nullable=false)
     * @Gedmo\Versioned()
     * @Assert\NotBlank(message="O campo data é obrigatório")
     */
    private $data;

    /**
     * @var string
     *
     * @ORM\Column(name="observacao", type="text", length=65535, nullable=true)
     * @Gedmo\Versioned()
     */
    private $observacao;

    /**
     * @var string
     *
     * @ORM\Column(name="user", type="string", length=255, nullable=false)
     * @Assert\NotBlank(message="O usuário é obrigatório")
     */
    private $user;

    /**
     * @var File
     *
     * @Vich\UploadableField(mapping="mapeamento_backup", fileNameProperty="fileName")
     */
    private $imageFile;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="data_alter_file", type="date", nullable=true)
     * @Gedmo\Versioned()
     */
    private $dataAlterFile;

    /**
     * @var string
     *
     * @ORM\Column(name="file_name", type="string", length=255, nullable=true)
     * @Gedmo\Versioned()
     */
    private $fileName;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var \MRS\BackupBundle\Entity\Job
     *
     * @ORM\ManyToOne(targetEntity="MRS\BackupBundle\Entity\Job")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="job_id", referencedColumnName="id")
     * })
     * @Gedmo\Versioned()
     * @Assert\NotBlank(message="O Job é obrigatório")
     */
    private $job;

    /**
     * @var \MRS\BackupBundle\Entity\Status
     *
     * @ORM\ManyToOne(targetEntity="MRS\BackupBundle\Entity\Status")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="status_id", referencedColumnName="id")
     * })
     * @Gedmo\Versioned()
     * @Assert\NotBlank(message="O status é obrigatório")
     */
    private $status;

    /**
     * @var string
     *
     * @ORM\Column(name="job_name", type="string", length=255, nullable=true)
     * @Gedmo\Versioned()
     */
    private $jobName;


    /**
     * @var string
     *
     * @ORM\Column(name="tipo_job", type="string", length=255, nullable=true)
     * @Gedmo\Versioned()
     */
    private $tipoJob;


    public function __construct()
    {
        $this->setData(new \DateTime('now'));
    }

    /**
     * Set data
     *
     * @param \DateTime $data
     *
     * @return RegistroBackup
     */
    public function setData($data)
    {
        $this->data = $data;

        return $this;
    }



    /**
     * Get data
     *
     * @return \DateTime
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * Set observacao
     *
     * @param string $observacao
     *
     * @return RegistroBackup
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
     * Set fileName
     *
     * @param string $fileName
     *
     * @return RegistroBackup
     */
    public function setFileName($fileName)
    {
        $this->fileName = $fileName;

        return $this;
    }

    /**
     * Get fileName
     *
     * @return string
     */
    public function getFileName()
    {
        return $this->fileName;
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
     * Set job
     *
     * @param \MRS\BackupBundle\Entity\Job $job
     *
     * @return RegistroBackup
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

    /**
     * Set status
     *
     * @param \MRS\BackupBundle\Entity\Status $status
     *
     * @return RegistroBackup
     */
    public function setStatus(\MRS\BackupBundle\Entity\Status $status = null)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status
     *
     * @return \MRS\BackupBundle\Entity\Status
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set dataAlterFile
     *
     * @param \DateTime $dataAlterFile
     *
     * @return RegistroBackup
     */
    public function setDataAlterFile($dataAlterFile)
    {
        $this->dataAlterFile = $dataAlterFile;

        return $this;
    }

    /**
     * Get dataAlterFile
     *
     * @return \DateTime
     */
    public function getDataAlterFile()
    {
        return $this->dataAlterFile;
    }

    /**
     * @return File
     */
    public function getImageFile()
    {
        return $this->imageFile;
    }

    /**
     * @param File $imageFile
     * @return RegistroBackup
     */
    public function setImageFile($imageFile)
    {
        $this->imageFile = $imageFile;

        if($imageFile){
            $this->dataAlterFile = new \DateTime('now');
        }

        return $this;
    }

    /**
     * Set user
     *
     * @param string $user
     *
     * @return RegistroBackup
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

    /**
     * Set jobName
     *
     * @param string $jobName
     *
     * @return RegistroBackup
     */
    public function setJobName($jobName)
    {
        $this->jobName = $jobName;

        return $this;
    }

    /**
     * Get jobName
     *
     * @return string
     */
    public function getJobName()
    {
        return $this->jobName;
    }

    /**
     * Set tipoJob
     *
     * @param string $tipoJob
     *
     * @return RegistroBackup
     */
    public function setTipoJob($tipoJob)
    {
        $this->tipoJob = $tipoJob;

        return $this;
    }

    /**
     * Get tipoJob
     *
     * @return string
     */
    public function getTipoJob()
    {
        return $this->tipoJob;
    }
}
