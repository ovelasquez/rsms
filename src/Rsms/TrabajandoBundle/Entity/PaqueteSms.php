<?php

namespace Rsms\TrabajandoBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * PaqueteSms
 *
 * @ORM\Table(name="paquete_sms")
 * @ORM\Entity
 */
class PaqueteSms
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="bigint", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="SEQUENCE")
     * @ORM\SequenceGenerator(sequenceName="paquete_sms_id_seq", allocationSize=1, initialValue=1)
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="nombre", type="string", length=255, nullable=false)
     */
    private $nombre;

    /**
     * @var integer
     *
     * @ORM\Column(name="cantidad_sms", type="integer", nullable=false)
     */
    private $cantidadSms;



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
     * Set nombre
     *
     * @param string $nombre
     * @return PaqueteSms
     */
    public function setNombre($nombre)
    {
        $this->nombre = $nombre;

        return $this;
    }

    /**
     * Get nombre
     *
     * @return string 
     */
    public function getNombre()
    {
        return $this->nombre;
    }

    /**
     * Set cantidadSms
     *
     * @param integer $cantidadSms
     * @return PaqueteSms
     */
    public function setCantidadSms($cantidadSms)
    {
        $this->cantidadSms = $cantidadSms;

        return $this;
    }

    /**
     * Get cantidadSms
     *
     * @return integer 
     */
    public function getCantidadSms()
    {
        return $this->cantidadSms;
    }
    
     public function __toString() {
        return $this->getNombre();
    }
}
