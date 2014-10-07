<?php

namespace Rsms\TrabajandoBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Envios
 *
 * @ORM\Table(name="envios")
 * @ORM\Entity
 */
class Envios
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="bigint", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="SEQUENCE")
     * @ORM\SequenceGenerator(sequenceName="envios_id_seq", allocationSize=1, initialValue=1)
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="rut", type="string", length=60, nullable=false)
     */
    private $rut;

    /**
     * @var string
     *
     * @ORM\Column(name="nombre", type="string", length=60, nullable=false)
     */
    private $nombre;

    /**
     * @var string
     *
     * @ORM\Column(name="apellido", type="string", length=60, nullable=false)
     */
    private $apellido;

    /**
     * @var string
     *
     * @ORM\Column(name="fono", type="string", length=20, nullable=false)
     */
    private $fono;

    /**
     * @var string
     *
     * @ORM\Column(name="oferta", type="string", length=160, nullable=false)
     */
    private $oferta;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fecha_oferta", type="datetime", nullable=false)
     */
    private $fechaOferta;

    /**
     * @var integer
     *
     * @ORM\Column(name="avisoid", type="bigint", nullable=false)
     */
    private $avisoid;

    /**
     * @var integer
     *
     * @ORM\Column(name="personaid", type="bigint", nullable=false)
     */
    private $personaid;

    /**
     * @var integer
     *
     * @ORM\Column(name="dominioid", type="bigint", nullable=false)
     */
    private $dominioid;

    /**
     * @var integer
     *
     * @ORM\Column(name="empresaid", type="bigint", nullable=false)
     */
    private $empresaid;

    /**
     * @var string
     *
     * @ORM\Column(name="empresa", type="string", length=50, nullable=true)
     */
    private $empresa;

    /**
     * @var integer
     *
     * @ORM\Column(name="status", type="smallint", nullable=false)
     */
    private $status;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fecha", type="datetime", nullable=false)
     */
    private $fecha;

    /**
     * @var integer
     *
     * @ORM\Column(name="status_enrolamiento", type="smallint", nullable=false)
     */
    private $statusEnrolamiento;

    /**
     * @var string
     *
     * @ORM\Column(name="codigo", type="string", length=10, nullable=false)
     */
    private $codigo;

    /**
     * @var string
     *
     * @ORM\Column(name="id_opratel", type="string", length=16, nullable=true)
     */
    private $idOpratel;

    /**
     * @var string
     *
     * @ORM\Column(name="repuesta_opratel", type="string", length=255, nullable=true)
     */
    private $repuestaOpratel;

    /**
     * @var integer
     *
     * @ORM\Column(name="por_envio", type="smallint", nullable=false)
     */
    private $porEnvio;



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
     * Set rut
     *
     * @param string $rut
     * @return Envios
     */
    public function setRut($rut)
    {
        $this->rut = $rut;

        return $this;
    }

    /**
     * Get rut
     *
     * @return string 
     */
    public function getRut()
    {
        return $this->rut;
    }

    /**
     * Set nombre
     *
     * @param string $nombre
     * @return Envios
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
     * Set apellido
     *
     * @param string $apellido
     * @return Envios
     */
    public function setApellido($apellido)
    {
        $this->apellido = $apellido;

        return $this;
    }

    /**
     * Get apellido
     *
     * @return string 
     */
    public function getApellido()
    {
        return $this->apellido;
    }

    /**
     * Set fono
     *
     * @param string $fono
     * @return Envios
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
     * Set oferta
     *
     * @param string $oferta
     * @return Envios
     */
    public function setOferta($oferta)
    {
        $this->oferta = $oferta;

        return $this;
    }

    /**
     * Get oferta
     *
     * @return string 
     */
    public function getOferta()
    {
        return $this->oferta;
    }

    /**
     * Set fechaOferta
     *
     * @param \DateTime $fechaOferta
     * @return Envios
     */
    public function setFechaOferta($fechaOferta)
    {
        $this->fechaOferta = $fechaOferta;

        return $this;
    }

    /**
     * Get fechaOferta
     *
     * @return \DateTime 
     */
    public function getFechaOferta()
    {
        return $this->fechaOferta;
    }

    /**
     * Set avisoid
     *
     * @param integer $avisoid
     * @return Envios
     */
    public function setAvisoid($avisoid)
    {
        $this->avisoid = $avisoid;

        return $this;
    }

    /**
     * Get avisoid
     *
     * @return integer 
     */
    public function getAvisoid()
    {
        return $this->avisoid;
    }

    /**
     * Set personaid
     *
     * @param integer $personaid
     * @return Envios
     */
    public function setPersonaid($personaid)
    {
        $this->personaid = $personaid;

        return $this;
    }

    /**
     * Get personaid
     *
     * @return integer 
     */
    public function getPersonaid()
    {
        return $this->personaid;
    }

    /**
     * Set dominioid
     *
     * @param integer $dominioid
     * @return Envios
     */
    public function setDominioid($dominioid)
    {
        $this->dominioid = $dominioid;

        return $this;
    }

    /**
     * Get dominioid
     *
     * @return integer 
     */
    public function getDominioid()
    {
        return $this->dominioid;
    }

    /**
     * Set empresaid
     *
     * @param integer $empresaid
     * @return Envios
     */
    public function setEmpresaid($empresaid)
    {
        $this->empresaid = $empresaid;

        return $this;
    }

    /**
     * Get empresaid
     *
     * @return integer 
     */
    public function getEmpresaid()
    {
        return $this->empresaid;
    }

    /**
     * Set empresa
     *
     * @param string $empresa
     * @return Envios
     */
    public function setEmpresa($empresa)
    {
        $this->empresa = $empresa;

        return $this;
    }

    /**
     * Get empresa
     *
     * @return string 
     */
    public function getEmpresa()
    {
        return $this->empresa;
    }

    /**
     * Set status
     *
     * @param integer $status
     * @return Envios
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
     * Set fecha
     *
     * @param \DateTime $fecha
     * @return Envios
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
     * Set statusEnrolamiento
     *
     * @param integer $statusEnrolamiento
     * @return Envios
     */
    public function setStatusEnrolamiento($statusEnrolamiento)
    {
        $this->statusEnrolamiento = $statusEnrolamiento;

        return $this;
    }

    /**
     * Get statusEnrolamiento
     *
     * @return integer 
     */
    public function getStatusEnrolamiento()
    {
        return $this->statusEnrolamiento;
    }

    /**
     * Set codigo
     *
     * @param string $codigo
     * @return Envios
     */
    public function setCodigo($codigo)
    {
        $this->codigo = $codigo;

        return $this;
    }

    /**
     * Get codigo
     *
     * @return string 
     */
    public function getCodigo()
    {
        return $this->codigo;
    }

    /**
     * Set idOpratel
     *
     * @param string $idOpratel
     * @return Envios
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
     * Set repuestaOpratel
     *
     * @param string $repuestaOpratel
     * @return Envios
     */
    public function setRepuestaOpratel($repuestaOpratel)
    {
        $this->repuestaOpratel = $repuestaOpratel;

        return $this;
    }

    /**
     * Get repuestaOpratel
     *
     * @return string 
     */
    public function getRepuestaOpratel()
    {
        return $this->repuestaOpratel;
    }

    /**
     * Set porEnvio
     *
     * @param integer $porEnvio
     * @return Envios
     */
    public function setPorEnvio($porEnvio)
    {
        $this->porEnvio = $porEnvio;

        return $this;
    }

    /**
     * Get porEnvio
     *
     * @return integer 
     */
    public function getPorEnvio()
    {
        return $this->porEnvio;
    }
}
