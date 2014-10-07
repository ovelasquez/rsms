<?php

namespace Rsms\TrabajandoBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Telefonos
 *
 * @ORM\Table(name="telefonos", indexes={@ORM\Index(name="idx_5984c60ffe0067e5", columns={"candidato_id"})})
 * @ORM\Entity
 */
class Telefonos
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="SEQUENCE")
     * @ORM\SequenceGenerator(sequenceName="telefonos_id_seq", allocationSize=1, initialValue=1)
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="numero", type="string", length=255, nullable=false)
     */
    private $numero;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fecha", type="datetime", nullable=false)
     */
    private $fecha;

    /**
     * @var \Candidatos
     *
     * @ORM\ManyToOne(targetEntity="Candidatos")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="candidato_id", referencedColumnName="id")
     * })
     */
    private $candidato;



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
     * Set numero
     *
     * @param string $numero
     * @return Telefonos
     */
    public function setNumero($numero)
    {
        $this->numero = $numero;

        return $this;
    }

    /**
     * Get numero
     *
     * @return string 
     */
    public function getNumero()
    {
        return $this->numero;
    }

    /**
     * Set fecha
     *
     * @param \DateTime $fecha
     * @return Telefonos
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
     * Set candidato
     *
     * @param \Rsms\TrabajandoBundle\Entity\Candidatos $candidato
     * @return Telefonos
     */
    public function setCandidato(\Rsms\TrabajandoBundle\Entity\Candidatos $candidato = null)
    {
        $this->candidato = $candidato;

        return $this;
    }

    /**
     * Get candidato
     *
     * @return \Rsms\TrabajandoBundle\Entity\Candidatos 
     */
    public function getCandidato()
    {
        return $this->candidato;
    }
}
