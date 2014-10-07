<?php

namespace Rsms\TrabajandoBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Rsms\TrabajandoBundle\Entity\PaqueteSms;
use Rsms\TrabajandoBundle\Entity\ClientePaqueteSms;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Clientes
 *
 * @ORM\Table(name="clientes")
 * @ORM\Entity
 */
class Clientes {

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="SEQUENCE")
     * @ORM\SequenceGenerator(sequenceName="clientes_id_seq", allocationSize=1, initialValue=1)
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
     * @ORM\Column(name="cantidad_sms_usados", type="integer", nullable=false)
     */
    private $cantidadSmsUsados = 0;

    

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId() {
        return $this->id;
    }

    /**
     * Set nombre
     *
     * @param string $nombre
     * @return Clientes
     */
    public function setNombre($nombre) {
        $this->nombre = $nombre;

        return $this;
    }

    /**
     * Get nombre
     *
     * @return string 
     */
    public function getNombre() {
        return $this->nombre;
    }

    /**
     * Set cantidadSmsUsados
     *
     * @param integer $cantidadSmsUsados
     * @return Clientes
     */
    public function setCantidadSmsUsados($cantidadSmsUsados) {
        $this->cantidadSmsUsados = $cantidadSmsUsados;

        return $this;
    }

    /**
     * Get cantidadSmsUsados
     *
     * @return integer 
     */
    public function getCantidadSmsUsados() {
        return $this->cantidadSmsUsados;
    }

    public function __toString() {
        return $this->getNombre();
    }

}
