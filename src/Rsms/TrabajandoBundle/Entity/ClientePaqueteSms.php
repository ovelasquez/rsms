<?php

namespace Rsms\TrabajandoBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ClientePaqueteSms
 *
 * @ORM\Table(name="cliente_paquete_sms", indexes={@ORM\Index(name="IDX_BE1077FC3A24FDC", columns={"paquete_sms_id"}), @ORM\Index(name="IDX_BE1077FCDE734E51", columns={"cliente_id"})})
 * @ORM\Entity
 */
class ClientePaqueteSms
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="bigint", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="SEQUENCE")
     * @ORM\SequenceGenerator(sequenceName="cliente_paquete_sms_id_seq", allocationSize=1, initialValue=1)
     */
    private $id;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fecha", type="datetime", nullable=false)
     */
    private $fecha;

    /**
     * @var \PaqueteSms
     *
     * @ORM\ManyToOne(targetEntity="PaqueteSms")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="paquete_sms_id", referencedColumnName="id")
     * })
     */
    private $paqueteSms;

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
     * @return ClientePaqueteSms
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
     * Set paqueteSms
     *
     * @param \Rsms\TrabajandoBundle\Entity\PaqueteSms $paqueteSms
     * @return ClientePaqueteSms
     */
    public function setPaqueteSms(\Rsms\TrabajandoBundle\Entity\PaqueteSms $paqueteSms = null)
    {
        $this->paqueteSms = $paqueteSms;

        return $this;
    }

    /**
     * Get paqueteSms
     *
     * @return \Rsms\TrabajandoBundle\Entity\PaqueteSms 
     */
    public function getPaqueteSms()
    {
        return $this->paqueteSms;
    }

    /**
     * Set cliente
     *
     * @param \Rsms\TrabajandoBundle\Entity\Clientes $cliente
     * @return ClientePaqueteSms
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
}
