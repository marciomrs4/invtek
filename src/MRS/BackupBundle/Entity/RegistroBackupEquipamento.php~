<?php

namespace MRS\BackupBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints\DateTime;

/**
 * RegistroBackupEquipamento
 *
 * @ORM\Table(name="registro_backup_equipamento")
 * @ORM\Entity(repositoryClass="MRS\BackupBundle\Repository\RegistroBackupEquipamentoRepository")
 */
class RegistroBackupEquipamento
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     * @ORM\Column(name="equipamento", type="string", length=255, nullable=false)
     */
    private $equipamento;

    /**
     * @var DateTime
     * @ORM\Column(name="data_criacao", type="date", length=255, nullable=false)
     */
    private $dataCriacao;

    /**
     * @var string
     * @ORM\Column(name="unidade", type="string", length=255, nullable=false)
     */
    private $unidade;


    /**
     * @var \MRS\BackupBundle\Entity\RegistroBackup
     *
     * @ORM\ManyToOne(targetEntity="MRS\BackupBundle\Entity\RegistroBackup")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="registro_backup_id", referencedColumnName="id")
     * })
     */
    private $registroBackupId;


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set equipamento
     *
     * @param string $equipamento
     *
     * @return RegistroBackupEquipamento
     */
    public function setEquipamento($equipamento)
    {
        $this->equipamento = $equipamento;

        return $this;
    }

    /**
     * Get equipamento
     *
     * @return string
     */
    public function getEquipamento()
    {
        return $this->equipamento;
    }

    /**
     * Set dataCriacao
     *
     * @param \DateTime $dataCriacao
     *
     * @return RegistroBackupEquipamento
     */
    public function setDataCriacao($dataCriacao)
    {
        $this->dataCriacao = $dataCriacao;

        return $this;
    }

    /**
     * Get dataCriacao
     *
     * @return \DateTime
     */
    public function getDataCriacao()
    {
        return $this->dataCriacao;
    }

    /**
     * Set unidade
     *
     * @param string $unidade
     *
     * @return RegistroBackupEquipamento
     */
    public function setUnidade($unidade)
    {
        $this->unidade = $unidade;

        return $this;
    }

    /**
     * Get unidade
     *
     * @return string
     */
    public function getUnidade()
    {
        return $this->unidade;
    }

    /**
     * Set registroBackupId
     *
     * @param \MRS\BackupBundle\Entity\RegistroBackup $registroBackupId
     *
     * @return RegistroBackupEquipamento
     */
    public function setRegistroBackupId(\MRS\BackupBundle\Entity\RegistroBackup $registroBackupId = null)
    {
        $this->registroBackupId = $registroBackupId;

        return $this;
    }

    /**
     * Get registroBackupId
     *
     * @return \MRS\BackupBundle\Entity\RegistroBackup
     */
    public function getRegistroBackupId()
    {
        return $this->registroBackupId;
    }
}
