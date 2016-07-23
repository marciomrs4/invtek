<?php

namespace MRS\InventarioBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * Anexo
 *
 * @ORM\Table(name="anexo", indexes={@ORM\Index(name="fk_anexo_equipamento1_idx", columns={"equipamento_id"})})
 * @ORM\Entity
 * @Vich\Uploadable
 */
class Anexo
{

    /**
     * @var File
     *
     * @Vich\UploadableField(mapping="mapeamento_equipamento", fileNameProperty="imageName")
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
     * @var \MRS\InventarioBundle\Entity\Equipamento
     *
     * @ORM\ManyToOne(targetEntity="MRS\InventarioBundle\Entity\Equipamento")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="equipamento_id", referencedColumnName="id")
     * })
     */
    private $equipamento;

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
     * @return Anexo
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
     * @return Anexo
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
     * @return Anexo
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
     * @return Anexo
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
     * @return Anexo
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
     * Set equipamento
     *
     * @param \MRS\InventarioBundle\Entity\Equipamento $equipamento
     * @return Anexo
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
}
