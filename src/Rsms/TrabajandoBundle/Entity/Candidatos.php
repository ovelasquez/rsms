<?php

namespace Rsms\TrabajandoBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Candidatos
 *
 * @ORM\Table(name="candidatos")
 * @ORM\Entity
 */
class Candidatos
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     * @ORM\SequenceGenerator(sequenceName="candidatos_id_seq", allocationSize=1, initialValue=1)
     */
    private $id;

    /**
     * @var integer
     *
     * @ORM\Column(name="trabajandoid", type="bigint", nullable=false)
     */
    private $trabajandoid;

    /**
     * @var string
     *
     * @ORM\Column(name="nombre", type="string", length=255, nullable=false)
     */
    private $nombre;

    /**
     * @var string
     *
     * @ORM\Column(name="apellido", type="string", length=255, nullable=false)
     */
    private $apellido;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fecha", type="datetime", nullable=false)
     */
    private $fecha;
    
     /**
     * @var \Clientes
     *
     * @ORM\ManyToOne(targetEntity="Clientes")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="cliente_id", referencedColumnName="id")
     * })
     */
    private $cliente;
    
      /**
     * @var boolean
     *
     * @ORM\Column(name="is_enrolado", type="boolean", nullable=false)
     */
    private $isEnrolado;



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
     * Set trabajandoid
     *
     * @param integer $trabajandoid
     * @return Candidatos
     */
    public function setTrabajandoid($trabajandoid)
    {
        $this->trabajandoid = $trabajandoid;

        return $this;
    }

    /**
     * Get trabajandoid
     *
     * @return integer 
     */
    public function getTrabajandoid()
    {
        return $this->trabajandoid;
    }

    /**
     * Set nombre
     *
     * @param string $nombre
     * @return Candidatos
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
     * @return Candidatos
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
     * Set fecha
     *
     * @param \DateTime $fecha
     * @return Candidatos
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
     * Set cliente
     *
     * @param \Rsms\TrabajandoBundle\Entity\Clientes $cliente
     * @return Candidatos
     */
    public function setCliente(\Rsms\TrabajandoBundle\Entity\Clientes $cliente = null)
    {
        $this->cliente = $cliente;
    
        return $this;
    }

    /**
     * Get cliente
     *
     * @return \Rsms\TrabajandoBundle\Entity\Clientes 
     */
    public function getCliente()
    {
        return $this->cliente;
    }

    /**
     * Set isEnrolado
     *
     * @param boolean $isEnrolado
     * @return Candidatos
     */
    public function setIsEnrolado($isEnrolado)
    {
        $this->isEnrolado = $isEnrolado;
    
        return $this;
    }

    /**
     * Get isEnrolado
     *
     * @return boolean 
     */
    public function getIsEnrolado()
    {
        return $this->isEnrolado;
    }
}
