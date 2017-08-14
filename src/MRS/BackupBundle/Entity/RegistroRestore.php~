<?php

namespace MRS\BackupBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * RegistroRestore
 *
 * @ORM\Table(name="registro_restore", indexes={@ORM\Index(name="tipo_job_fk_idx", columns={"tipo_job_id"}), @ORM\Index(name="fita_id_fk_idx", columns={"fita_id"}), @ORM\Index(name="equipamento_id_fk_idx", columns={"equipamento_id"}), @ORM\Index(name="tipo_job_restore_fk_idx", columns={"tipo_job_id"}), @ORM\Index(name="fita_id_restore_fk_idx", columns={"fita_id"}), @ORM\Index(name="equipamento_id_restore_fk_idx", columns={"equipamento_id"}), @ORM\Index(name="status_restore_fk_idx", columns={"status_id"})})
 * @ORM\Entity(repositoryClass="MRS\BackupBundle\Repository\RegistroRestoreRepository")
 * @Vich\Uploadable
 * @Gedmo\Loggable()
 */
class RegistroRestore
{
    /**
     * @var \DateTime
     *
     * @ORM\Column(name="data", type="date", nullable=false)
     * @Gedmo\Versioned()
     * @Assert\NotBlank(message="O Campo data é obrigatório")
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
     * @var File
     *
     * @Vich\UploadableField(mapping="mapeamento_restore", fileNameProperty="imageName")
     */
    private $imageFile;
    
    /**
     * @var string
     *
     * @ORM\Column(name="image_name", type="string", length=255, nullable=true)
     * @Gedmo\Versioned()
     */
    private $imageName;

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
     * @Gedmo\Versioned()
     * @Assert\NotBlank(message="O Equipamento é obrigatório")
     */
    private $equipamento;

    /**
     * @var \MRS\BackupBundle\Entity\Fita
     *
     * @ORM\ManyToOne(targetEntity="MRS\BackupBundle\Entity\Fita")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="fita_id", referencedColumnName="id")
     * })
     * @Gedmo\Versioned()
     * @Assert\NotBlank(message="O campo fita é obrigatório")
     */
    private $fita;

    /**
     * @var \MRS\BackupBundle\Entity\Status
     *
     * @ORM\ManyToOne(targetEntity="MRS\BackupBundle\Entity\Status")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="status_id", referencedColumnName="id")
     * })
     * @Gedmo\Versioned()
     * @Assert\NotBlank(message="O Status é obrigatório")
     */
    private $status;

    /**
     * @var \MRS\BackupBundle\Entity\TipoJob
     *
     * @ORM\ManyToOne(targetEntity="MRS\BackupBundle\Entity\TipoJob")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="tipo_job_id", referencedColumnName="id")
     * })
     * @Gedmo\Versioned()
     * @Assert\NotBlank(message="O Campo Tipo de Job é obrigatório")
     */
    private $tipoJob;

    /**
     * @ORM\Column(name="user", type="string", length=255, nullable=false)
     * @Assert\NotBlank(message="O Usuário é obrigatório")
     */
    private $user;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_alter_file", type="date", nullable=true)
     * @Gedmo\Versioned()
     */
    private $dateAlterFile;

    /**
     * @var string
     *
     * @ORM\Column(name="file_name", type="string", length=255, nullable=true)
     * @Gedmo\Versioned()
     */
    private $file_name;

    /**
     * @var string
     *
     * @ORM\Column(name="equipamento_name", type="string", length=255, nullable=false)
     * @Gedmo\Versioned()
     */
    private $equipamentoName;

    /**
     * @var string
     *
     * @ORM\Column(name="fita_name", type="string", length=255, nullable=false)
     * @Gedmo\Versioned()
     */
    private $fitaName;

    /**
     * @var string
     *
     * @ORM\Column(name="tipo_job_name", type="string", length=255, nullable=false)
     * @Gedmo\Versioned()
     */
    private $tipoJobName;


    public function __construct()
    {
        $this->setData(new \DateTime('now'));
    }

    /**
     * @return File
     */
    public function getImageFile()
    {
        return $this->imageFile;
    }

    /**
     * @param File|\Symfony\Component\HttpFoundation\File\UploadedFile $imageFile
     * @return RegistroRestore
     */
    public function setImageFile(File $imageFile)
    {
        $this->imageFile = $imageFile;

        if($imageFile){
            $this->dateAlterFile = new \DateTime('now');
            $this->file_name = $this->getImageName();
        }
        return $this;
    }


    /**
     * Set data
     *
     * @param \DateTime $data
     *
     * @return RegistroRestore
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
     * @return RegistroRestore
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
     * Set imageName
     *
     * @param string $imageName
     *
     * @return RegistroRestore
     */
    public function setImageName($imageFile)
    {
        $this->imageName = $imageFile;

        return $this;
    }

    /**
     * Get imageName
     *
     * @return string
     */
    public function getImageName()
    {
        return $this->imageName;
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
     * Set equipamento
     *
     * @param \MRS\InventarioBundle\Entity\Equipamento $equipamento
     *
     * @return RegistroRestore
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
     * Set fita
     *
     * @param \MRS\BackupBundle\Entity\Fita $fita
     *
     * @return RegistroRestore
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
     * Set status
     *
     * @param \MRS\BackupBundle\Entity\Status $status
     *
     * @return RegistroRestore
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
     * Set tipoJob
     *
     * @param \MRS\BackupBundle\Entity\TipoJob $tipoJob
     *
     * @return RegistroRestore
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

    /**
     * Set user
     *
     * @param string $user
     *
     * @return RegistroRestore
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
     * Set dateAlterFile
     *
     * @param \DateTime $dateAlterFile
     *
     * @return RegistroRestore
     */
    public function setDateAlterFile($dateAlterFile)
    {
        $this->dateAlterFile = $dateAlterFile;

        return $this;
    }

    /**
     * Get dateAlterFile
     *
     * @return \DateTime
     */
    public function getDateAlterFile()
    {
        return $this->dateAlterFile;
    }

    /**
     * Set fileName
     *
     * @param string $fileName
     *
     * @return RegistroRestore
     */
    public function setFileName($fileName)
    {
        $this->file_name = $fileName;

        return $this;
    }

    /**
     * Get fileName
     *
     * @return string
     */
    public function getFileName()
    {
        return $this->file_name;
    }

    /**
     * Set equipamentoName
     *
     * @param string $equipamentoName
     *
     * @return RegistroRestore
     */
    public function setEquipamentoName($equipamentoName)
    {
        $this->equipamentoName = $equipamentoName;

        return $this;
    }

    /**
     * Get equipamentoName
     *
     * @return string
     */
    public function getEquipamentoName()
    {
        return $this->equipamentoName;
    }

    /**
     * Set fitaName
     *
     * @param string $fitaName
     *
     * @return RegistroRestore
     */
    public function setFitaName($fitaName)
    {
        $this->fitaName = $fitaName;

        return $this;
    }

    /**
     * Get fitaName
     *
     * @return string
     */
    public function getFitaName()
    {
        return $this->fitaName;
    }

    /**
     * Set tipoJobName
     *
     * @param string $tipoJobName
     *
     * @return RegistroRestore
     */
    public function setTipoJobName($tipoJobName)
    {
        $this->tipoJobName = $tipoJobName;

        return $this;
    }

    /**
     * Get tipoJobName
     *
     * @return string
     */
    public function getTipoJobName()
    {
        return $this->tipoJobName;
    }
}
