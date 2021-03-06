<?php

namespace MRS\BackupBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\Validator\Constraints as Assert;
use Gedmo\Mapping\Annotation as Gedmo;
/**
 * AnexoCompartilhado
 *
 * @ORM\Table(name="anexo_compartilhado")
 * @ORM\Entity
 * @Vich\Uploadable()
 * @Gedmo\Loggable()
 */
class AnexoCompartilhado
{
    /**
     * @var File
     *
     * @Vich\UploadableField(mapping="mapeamento_backup_compartilhado", fileNameProperty="imageName")
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
     * @Assert\NotBlank(message="Arquivo é obrigatório")
     */
    private $imageFile;

    /**
     * @var string
     *
     * @ORM\Column(name="imageName", type="string", length=255, nullable=true)
     * @Gedmo\Versioned()
     */
    private $imagename;

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
     * @ORM\Column(name="data_criacao", type="datetime", nullable=true)
     * @Gedmo\Versioned()
     */
    private $dataCriacao;

    /**
     * @var string
     *
     * @ORM\Column(name="data_alteracao", type="datetime", nullable=true)
     */
    private $dataAlteracao;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    public function __construct()
    {
        $this->dataCriacao = new \DateTime('now');
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
     * Set imagename
     *
     * @param string $imagename
     *
     * @return AnexoCompartilhado
     */
    public function setImagename($imagename)
    {
        $this->imagename = $imagename;

        return $this;
    }

    /**
     * Get imagename
     *
     * @return string
     */
    public function getImagename()
    {
        return $this->imagename;
    }

    /**
     * Set nome
     *
     * @param string $nome
     *
     * @return AnexoCompartilhado
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
     * Set dataCriacao
     *
     * @param string $dataCriacao
     *
     * @return AnexoCompartilhado
     */
    public function setDataCriacao($dataCriacao)
    {
        $this->dataCriacao = $dataCriacao;

        return $this;
    }

    /**
     * Get dataCriacao
     *
     * @return string
     */
    public function getDataCriacao()
    {
        return $this->dataCriacao;
    }

    /**
     * Set dataAlteracao
     *
     * @param string $dataAlteracao
     *
     * @return AnexoCompartilhado
     */
    public function setDataAlteracao($dataAlteracao)
    {
        $this->dataAlteracao = $dataAlteracao;

        return $this;
    }

    /**
     * Get dataAlteracao
     *
     * @return string
     */
    public function getDataAlteracao()
    {
        return $this->dataAlteracao;
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
     * @return string
     */
    public function __toString()
    {
        return $this->getNome();
    }

}
