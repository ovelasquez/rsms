<?php

namespace Rsms\TrabajandoBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * BolsaSms
 *
 * @ORM\Table(name="bolsa_sms")
 * @ORM\Entity
 */
class BolsaSms
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="SEQUENCE")
     * @ORM\SequenceGenerator(sequenceName="bolsa_sms_id_seq", allocationSize=1, initialValue=1)
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
     * @return BolsaSms
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
     * @return BolsaSms
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
