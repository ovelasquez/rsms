<?php

namespace Rsms\TrabajandoBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Postulacion
 *
 * @ORM\Table(name="postulacion", indexes={@ORM\Index(name="idx_17b321bd9bc276e5", columns={"id_envio"})})
 * @ORM\Entity
 */
class Postulacion
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="bigint", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="SEQUENCE")
     * @ORM\SequenceGenerator(sequenceName="postulacion_id_seq", allocationSize=1, initialValue=1)
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="mensaje", type="string", length=160, nullable=false)
     */
    private $mensaje;

    /**
     * @var integer
     *
     * @ORM\Column(name="status", type="smallint", nullable=false)
     */
    private $status;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fecha_carga", type="datetime", nullable=false)
     */
    private $fechaCarga;

    /**
     * @var string
     *
     * @ORM\Column(name="fono", type="string", length=255, nullable=false)
     */
    private $fono;

    /**
     * @var string
     *
     * @ORM\Column(name="mensaje_repuesta", type="string", length=160, nullable=true)
     */
    private $mensajeRepuesta;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fecha_repuesta", type="datetime", nullable=true)
     */
    private $fechaRepuesta;

    /**
     * @var integer
     *
     * @ORM\Column(name="status_repuesta", type="smallint", nullable=true)
     */
    private $statusRepuesta;

    /**
     * @var string
     *
     * @ORM\Column(name="id_opratel", type="string", length=160, nullable=true)
     */
    private $idOpratel;

    /**
     * @var string
     *
     * @ORM\Column(name="mensaje_repuesta_trabajando", type="string", length=255, nullable=true)
     */
    private $mensajeRepuestaTrabajando;

    /**
     * @var string
     *
     * @ORM\Column(name="status_repuesta_trabajando", type="string", length=10, nullable=true)
     */
    private $statusRepuestaTrabajando;

    /**
     * @var \Envios
     *
     * @ORM\ManyToOne(targetEntity="Envios")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_envio", referencedColumnName="id")
     * })
     */
    private $idEnvio;



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
     * Set mensaje
     *
     * @param string $mensaje
     * @return Postulacion
     */
    public function setMensaje($mensaje)
    {
        $this->mensaje = $mensaje;

        return $this;
    }

    /**
     * Get mensaje
     *
     * @return string 
     */
    public function getMensaje()
    {
        return $this->mensaje;
    }

    /**
     * Set status
     *
     * @param integer $status
     * @return Postulacion
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status
     *
     * @return integer 
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set fechaCarga
     *
     * @param \DateTime $fechaCarga
     * @return Postulacion
     */
    public function setFechaCarga($fechaCarga)
    {
        $this->fechaCarga = $fechaCarga;

        return $this;
    }

    /**
     * Get fechaCarga
     *
     * @return \DateTime 
     */
    public function getFechaCarga()
    {
        return $this->fechaCarga;
    }

    /**
     * Set fono
     *
     * @param string $fono
     * @return Postulacion
     */
    public function setFono($fono)
    {
        $this->fono = $fono;

        return $this;
    }

    /**
     * Get fono
     *
     * @return string 
     */
    public function getFono()
    {
        return $this->fono;
    }

    /**
     * Set mensajeRepuesta
     *
     * @param string $mensajeRepuesta
     * @return Postulacion
     */
    public function setMensajeRepuesta($mensajeRepuesta)
    {
        $this->mensajeRepuesta = $mensajeRepuesta;

        return $this;
    }

    /**
     * Get mensajeRepuesta
     *
     * @return string 
     */
    public function getMensajeRepuesta()
    {
        return $this->mensajeRepuesta;
    }

    /**
     * Set fechaRepuesta
     *
     * @param \DateTime $fechaRepuesta
     * @return Postulacion
     */
    public function setFechaRepuesta($fechaRepuesta)
    {
        $this->fechaRepuesta = $fechaRepuesta;

        return $this;
    }

    /**
     * Get fechaRepuesta
     *
     * @return \DateTime 
     */
    public function getFechaRepuesta()
    {
        return $this->fechaRepuesta;
    }

    /**
     * Set statusRepuesta
     *
     * @param integer $statusRepuesta
     * @return Postulacion
     */
    public function setStatusRepuesta($statusRepuesta)
    {
        $this->statusRepuesta = $statusRepuesta;

        return $this;
    }

    /**
     * Get statusRepuesta
     *
     * @return integer 
     */
    public function getStatusRepuesta()
    {
        return $this->statusRepuesta;
    }

    /**
     * Set idOpratel
     *
     * @param string $idOpratel
     * @return Postulacion
     */
    public function setIdOpratel($idOpratel)
    {
        $this->idOpratel = $idOpratel;

        return $this;
    }

    /**
     * Get idOpratel
     *
     * @return string 
     */
    public function getIdOpratel()
    {
        return $this->idOpratel;
    }

    /**
     * Set mensajeRepuestaTrabajando
     *
     * @param string $mensajeRepuestaTrabajando
     * @return Postulacion
     */
    public function setMensajeRepuestaTrabajando($mensajeRepuestaTrabajando)
    {
        $this->mensajeRepuestaTrabajando = $mensajeRepuestaTrabajando;

        return $this;
    }

    /**
     * Get mensajeRepuestaTrabajando
     *
     * @return string 
     */
    public function getMensajeRepuestaTrabajando()
    {
        return $this->mensajeRepuestaTrabajando;
    }

    /**
     * Set statusRepuestaTrabajando
     *
     * @param string $statusRepuestaTrabajando
     * @return Postulacion
     */
    public function setStatusRepuestaTrabajando($statusRepuestaTrabajando)
    {
        $this->statusRepuestaTrabajando = $statusRepuestaTrabajando;

        return $this;
    }

    /**
     * Get statusRepuestaTrabajando
     *
     * @return string 
     */
    public function getStatusRepuestaTrabajando()
    {
        return $this->statusRepuestaTrabajando;
    }

    /**
     * Set idEnvio
     *
     * @param \Rsms\TrabajandoBundle\Entity\Envios $idEnvio
     * @return Postulacion
     */
    public function setIdEnvio(\Rsms\TrabajandoBundle\Entity\Envios $idEnvio = null)
    {
        $this->idEnvio = $idEnvio;

        return $this;
    }

    /**
     * Get idEnvio
     *
     * @return \Rsms\TrabajandoBundle\Entity\Envios 
     */
    public function getIdEnvio()
    {
        return $this->idEnvio;
    }
}
