<?php

namespace MRS\InventarioBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * LicencaSoftware
 *
 * @ORM\Table(name="licenca_software", indexes={@ORM\Index(name="fk_licenca_software_software_idx", columns={"software_id"})})
 * @ORM\Entity(repositoryClass="MRS\InventarioBundle\Repository\LicencaSoftwareRepository")
 */
class LicencaSoftware
{
    /**
     * @var string
     *
     * @ORM\Column(name="nota_fiscal", type="string", length=45, nullable=false)
     * @Assert\NotBlank(message="O campo Nota Fiscal não pode ser vazio")
     */
    private $nota_fiscal;

    /**
     * @var string
     *
     * @ORM\Column(name="data_emissao", type="date", nullable=false)
     * @Assert\NotBlank(message="O campo Data Emissão não pode ser vazio")
     */
    private $data_emissao;

    /**
     * @var string
     *
     * @ORM\Column(name="valor_unitario", type="decimal", precision=10, scale=2, nullable=false)
     * @Assert\NotBlank(message="O campo Valor Unitário não pode ser vazio")
     */
    private $valor_unitario;

    /**
     * @var string
     *
     * @ORM\Column(name="quantidade_total", type="integer", nullable=false)
     * @Assert\NotBlank(message="O campo Quantidade Total não pode ser vazio")
     */
    private $quantidade_total;

    /**
     * @var string
     *
     * @ORM\Column(name="anotacoes", type="text", nullable=true)
     */
    private $anotacoes;


    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var \MRS\InventarioBundle\Entity\Software
     *
     * @ORM\ManyToOne(targetEntity="MRS\InventarioBundle\Entity\Software")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="software_id", referencedColumnName="id")
     * })
     */
    private $software;





    /**
     * Set notaFiscal
     *
     * @param string $notaFiscal
     *
     * @return LicencaSoftware
     */
    public function setNotaFiscal($notaFiscal)
    {
        $this->nota_fiscal = $notaFiscal;

        return $this;
    }

    /**
     * Get notaFiscal
     *
     * @return string
     */
    public function getNotaFiscal()
    {
        return $this->nota_fiscal;
    }

    /**
     * Set dataEmissao
     *
     * @param \DateTime $dataEmissao
     *
     * @return LicencaSoftware
     */
    public function setDataEmissao($dataEmissao)
    {
        $this->data_emissao = $dataEmissao;

        return $this;
    }

    /**
     * Get dataEmissao
     *
     * @return \DateTime
     */
    public function getDataEmissao()
    {
        return $this->data_emissao;
    }

    /**
     * Set valorUnitario
     *
     * @param string $valorUnitario
     *
     * @return LicencaSoftware
     */
    public function setValorUnitario($valorUnitario)
    {
        $this->valor_unitario = $valorUnitario;

        return $this;
    }

    /**
     * Get valorUnitario
     *
     * @return string
     */
    public function getValorUnitario()
    {
        return $this->valor_unitario;
    }

    /**
     * Set quantidadeTotal
     *
     * @param integer $quantidadeTotal
     *
     * @return LicencaSoftware
     */
    public function setQuantidadeTotal($quantidadeTotal)
    {
        $this->quantidade_total = $quantidadeTotal;

        return $this;
    }

    /**
     * Get quantidadeTotal
     *
     * @return integer
     */
    public function getQuantidadeTotal()
    {
        return $this->quantidade_total;
    }

    /**
     * Set anotacoes
     *
     * @param string $anotacoes
     *
     * @return LicencaSoftware
     */
    public function setAnotacoes($anotacoes)
    {
        $this->anotacoes = $anotacoes;

        return $this;
    }

    /**
     * Get anotacoes
     *
     * @return string
     */
    public function getAnotacoes()
    {
        return $this->anotacoes;
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
     * Set software
     *
     * @param \MRS\InventarioBundle\Entity\Software $software
     *
     * @return LicencaSoftware
     */
    public function setSoftware(\MRS\InventarioBundle\Entity\Software $software = null)
    {
        $this->software = $software;

        return $this;
    }

    /**
     * Get software
     *
     * @return \MRS\InventarioBundle\Entity\Software
     */
    public function getSoftware()
    {
        return $this->software;
    }
}
