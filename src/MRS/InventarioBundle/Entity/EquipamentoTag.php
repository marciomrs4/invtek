<?php

namespace MRS\InventarioBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * EquipamentoTag
 *
 * @ORM\Table(name="equipamento_tag", indexes={@ORM\Index(name="fk_equipamento_tag_equipamento1_idx", columns={"equipamento_id"})})
 * @ORM\Entity
 */
class EquipamentoTag
{
    /**
     * @var string
     *
     * @ORM\Column(name="descricao", type="string", length=45, nullable=false)
     * @Assert\NotBlank(message="Este campo não deve ser vazio")
     */
    private $descricao;

    /**
     * @var string
     *
     * @ORM\Column(name="nome", type="string", length=45, nullable=false)
     * @Assert\NotBlank(message="Este campo não deve ser vazio")
     */
    private $nome;

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



    /**
     * Set descricao
     *
     * @param string $descricao
     * @return EquipamentoTag
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
     * Set nome
     *
     * @param string $nome
     * @return EquipamentoTag
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
     * @return EquipamentoTag
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
