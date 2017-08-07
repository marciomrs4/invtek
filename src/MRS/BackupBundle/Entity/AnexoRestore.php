<?php

namespace MRS\BackupBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\Validator\Constraints as Assert;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * AnexoRestore
 *
 * @ORM\Table(name="anexo_restore", indexes={@ORM\Index(name="fk_restore_idx", columns={"restore_id"})})
 * @ORM\Entity
 * @Vich\Uploadable
 * @Gedmo\Loggable()
 */
class AnexoRestore
{

    /**
     * @var File
     *
     * @Vich\UploadableField(mapping="mapeamento_restore", fileNameProperty="imageName")
     * @Assert\File(mimeTypes={"application/vnd.openxmlformats-officedocument.spreadsheetml.sheet",
     *     "application/msword",
     *     "application/vnd.openxmlformats-officedocument.wordprocessingml.document",
     *     "text/plain",
     *     "application/vnd.ms-excel",
     *     "application/vnd.ms-office",
     *     "application/pdf",
     *     "text/html"},
     *     mimeTypesMessage="Por favor envie o tipo de arquivo correto! tipo enviado {{ type }}
     *                       Os tipos suportados são ({{ types }})")
     * @Gedmo\Versioned()
     */
    private $imageFile;

    /**
     * @var string
     *
     * @ORM\Column(name="imageName", type="string", length=255, nullable=true)
     * @Gedmo\Versioned()
     */
    private $imageName;
    /**
     * @var string
     *
     * @ORM\Column(name="nome", type="string", length=255, nullable=true)
     * @Gedmo\Versioned()
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
     * @Gedmo\Versioned()
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
     * @var \MRS\BackupBundle\Entity\RegistroRestore
     *
     * @ORM\ManyToOne(targetEntity="MRS\BackupBundle\Entity\RegistroRestore")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="restore_id", referencedColumnName="id")
     * })
     * @Gedmo\Versioned()
     */
    private $registroRestore;

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
     * @return AnexoRestore
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
     * @return AnexoRestore
     */
    public function setImageFile(File $imageFile)
    {
        $this->imageFile = $imageFile;

        if($imageFile){
            $this->dataalteracao = new \DateTime('now');
            $this->imageName = $this->getImageName();
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
     * @return AnexoRestore
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
     * @return AnexoRestore
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
     * @return AnexoRestore
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
     * Set RegistroRestore
     *
     * @param \MRS\BackupBundle\Entity\RegistroRestore $registroRestore
     * @return AnexoRestore
     */
    public function setRegistroRestore(\MRS\BackupBundle\Entity\RegistroRestore $registroRestore = null)
    {
        $this->registroRestore = $registroRestore;

        return $this;
    }

    /**
     * Get RegistroRestore
     *
     * @return \MRS\BackupBundle\Entity\RegistroRestore
     */
    public function getRegistroRestore()
    {
        return $this->registroRestore;
    }
}
