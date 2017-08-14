<?php

namespace MRS\BackupBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * RegistroAnexoBackup
 *
 * @ORM\Table(name="registro_anexo_backup", indexes={@ORM\Index(name="fk_registro_backup_idx", columns={"registro_backup_id"}), @ORM\Index(name="fk_registro_anexo_compartilhado_idx", columns={"anexo_compartilhado_id"})})
 * @ORM\Entity
 */
class RegistroAnexoBackup
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
     * @var \MRS\BackupBundle\Entity\AnexoCompartilhado
     *
     * @ORM\ManyToOne(targetEntity="MRS\BackupBundle\Entity\AnexoCompartilhado")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="anexo_compartilhado_id", referencedColumnName="id")
     * })
     */
    private $anexoCompartilhado;

    /**
     * @var \MRS\BackupBundle\Entity\RegistroBackup
     *
     * @ORM\ManyToOne(targetEntity="MRS\BackupBundle\Entity\RegistroBackup")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="registro_backup_id", referencedColumnName="id")
     * })
     */
    private $registroBackup;



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
     * Set anexoCompartilhado
     *
     * @param \MRS\BackupBundle\Entity\AnexoCompartilhado $anexoCompartilhado
     *
     * @return RegistroAnexoBackup
     */
    public function setAnexoCompartilhado(\MRS\BackupBundle\Entity\AnexoCompartilhado $anexoCompartilhado = null)
    {
        $this->anexoCompartilhado = $anexoCompartilhado;

        return $this;
    }

    /**
     * Get anexoCompartilhado
     *
     * @return \MRS\BackupBundle\Entity\AnexoCompartilhado
     */
    public function getAnexoCompartilhado()
    {
        return $this->anexoCompartilhado;
    }

    /**
     * Set registroBackup
     *
     * @param \MRS\BackupBundle\Entity\RegistroBackup $registroBackup
     *
     * @return RegistroAnexoBackup
     */
    public function setRegistroBackup(\MRS\BackupBundle\Entity\RegistroBackup $registroBackup = null)
    {
        $this->registroBackup = $registroBackup;

        return $this;
    }

    /**
     * Get registroBackup
     *
     * @return \MRS\BackupBundle\Entity\RegistroBackup
     */
    public function getRegistroBackup()
    {
        return $this->registroBackup;
    }
}
