<?php

namespace Rsms\TrabajandoBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * EmpresaBolsaSms
 *
 * @ORM\Table(name="empresa_bolsa_sms", indexes={@ORM\Index(name="IDX_28956676521E1991", columns={"empresa_id"}), @ORM\Index(name="IDX_28956676BB27AB50", columns={"bolsa_sms_id"})})
 * @ORM\Entity
 */
class EmpresaBolsaSms
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="bigint", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="SEQUENCE")
     * @ORM\SequenceGenerator(sequenceName="empresa_bolsa_sms_id_seq", allocationSize=1, initialValue=1)
     */
    private $id;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fecha", type="datetime", nullable=false)
     */
    private $fecha;

    /**
     * @var \Empresas
     *
     * @ORM\ManyToOne(targetEntity="Empresas")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="empresa_id", referencedColumnName="id")
     * })
     */
    private $empresa;

    /**
     * @var \BolsaSms
     *
     * @ORM\ManyToOne(targetEntity="BolsaSms")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="bolsa_sms_id", referencedColumnName="id")
     * })
     */
    private $bolsaSms;



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
     * Set fecha
     *
     * @param \DateTime $fecha
     * @return EmpresaBolsaSms
     */
    public function setFecha($fecha)
    {
        $this->fecha = $fecha;

        return $this;
    }

    /**
     * Get fecha
     *
     * @return \DateTime 
     */
    public function getFecha()
    {
        return $this->fecha;
    }

    /**
     * Set empresa
     *
     * @param \Rsms\TrabajandoBundle\Entity\Empresas $empresa
     * @return EmpresaBolsaSms
     */
    public function setEmpresa(\Rsms\TrabajandoBundle\Entity\Empresas $empresa = null)
    {
        $this->empresa = $empresa;

        return $this;
    }

    /**
     * Get empresa
     *
     * @return \Rsms\TrabajandoBundle\Entity\Empresas 
     */
    public function getEmpresa()
    {
        return $this->empresa;
    }

    /**
     * Set bolsaSms
     *
     * @param \Rsms\TrabajandoBundle\Entity\BolsaSms $bolsaSms
     * @return EmpresaBolsaSms
     */
    public function setBolsaSms(\Rsms\TrabajandoBundle\Entity\BolsaSms $bolsaSms = null)
    {
        $this->bolsaSms = $bolsaSms;

        return $this;
    }

    /**
     * Get bolsaSms
     *
     * @return \Rsms\TrabajandoBundle\Entity\BolsaSms 
     */
    public function getBolsaSms()
    {
        return $this->bolsaSms;
    }
}
