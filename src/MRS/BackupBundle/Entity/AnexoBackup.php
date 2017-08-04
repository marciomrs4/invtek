<?php

namespace MRS\BackupBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * AnexoBackup
 *
 * @ORM\Table(name="anexo_backup", indexes={@ORM\Index(name="fk_backup_idx", columns={"backup_id"})})
 * @ORM\Entity
 * @Vich\Uploadable
 */
class AnexoBackup
{

    /**
     * @var File
     *
     * @Vich\UploadableField(mapping="mapeamento_backup", fileNameProperty="imageName")
     * @Assert\File(mimeTypes={"application/vnd.openxmlformats-officedocument.spreadsheetml.sheet"},
     *              mimeTypesMessage="Por favor envie o tipo de arquivo correto")
     */
    private $imageFile;

    /**
     * @var string
     *
     * @ORM\Column(name="imageName", type="string", length=255, nullable=true)
      */
    private $imageName;
    /**
     * @var string
     *
     * @ORM\Column(name="nome", type="string", length=255, nullable=true)
     */
    private $nome;

    /**
     * @var string
     *
     * @ORM\Column(name="datacriacao", type="datetime", nullable=true)
     */
    private $datacriacao;

    /**
     * @var string
     *
     * @ORM\Column(name="dataalteracao", type="datetime", nullable=true)
     */
    private $dataalteracao;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var \MRS\BackupBundle\Entity\RegistroBackup
     *
     * @ORM\ManyToOne(targetEntity="MRS\BackupBundle\Entity\RegistroBackup")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="backup_id", referencedColumnName="id")
     * })
     */
    private $registroBackup;

    public function __construct()
    {
        $this->datacriacao = new \DateTime('now');
    }

    /**
     * @return string
     */
    public function getDataalteracao()
    {
        return $this->dataalteracao;
    }

    /**
     * @param string $dataalteracao
     * @return AnexoBackup
     */
    public function setDataalteracao($dataalteracao)
    {
        $this->dataalteracao = $dataalteracao;
        return $this;
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
     * @return AnexoBackup
     */
    public function setImageFile(File $imageFile)
    {
        $this->imageFile = $imageFile;

        if($imageFile){
            $this->dataalteracao = new \DateTime('now');
        }

        return $this;
    }

    /**
     * @return string
     */
    public function getImageName()
    {
        return $this->imageName;
    }

    /**
     * @param string $imageName
     * @return AnexoBackup
     */
    public function setImageName($imageName)
    {
        $this->imageName = $imageName;
        return $this;
    }




    /**
     * Set nome
     *
     * @param string $nome
     * @return AnexoBackup
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
     * Set datacriacao
     *
     * @param string $datacriacao
     * @return AnexoBackup
     */
    public function setDatacriacao($datacriacao)
    {
        $this->datacriacao = $datacriacao;

        return $this;
    }

    /**
     * Get datacriacao
     *
     * @return string 
     */
    public function getDatacriacao()
    {
        return $this->datacriacao;
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
     * Set RegistroBackup
     *
     * @param \MRS\BackupBundle\Entity\RegistroBackup $registroBackup
     * @return AnexoBackup
     */
    public function setRegistroBackup(\MRS\BackupBundle\Entity\RegistroBackup $registroBackup = null)
    {
        $this->registroBackup = $registroBackup;

        return $this;
    }

    /**
     * Get RegistroBackup
     *
     * @return \MRS\BackupBundle\Entity\RegistroBackup
     */
    public function getRegistroBackup()
    {
        return $this->registroBackup;
    }
}
