<?php

namespace Rsms\TrabajandoBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * Empresas
 *
 * @ORM\Table(name="empresas", indexes={@ORM\Index(name="IDX_70DD49A5DE734E51", columns={"cliente_id"})})
 * @ORM\Entity
 */
class Empresas
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     * @ORM\SequenceGenerator(sequenceName="empresas_id_seq", allocationSize=1, initialValue=1)
     */
    private $id;

    /**
     * @var integer
     *
     * @ORM\Column(name="trabajandoid", type="integer", nullable=false)
     */
    private $trabajandoid;

    /**
     * @var string
     *
     * @ORM\Column(name="nombre", type="string", length=255, nullable=false)
     */
    private $nombre;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fecha", type="datetime", nullable=false)
     */
    private $fecha;

    /**
     * @var integer
     *
     * @ORM\Column(name="cantidad_sms_usados", type="integer", nullable=false)
     */
    private $cantidadSmsUsados=0;
    
         /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $rutaFoto;

    /**
     * @Assert\Image(maxSize = "500k")
     */
    private $foto;

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
     * Set trabajandoid
     *
     * @param integer $trabajandoid
     * @return Empresas
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
     * @return Empresas
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
     * Set fecha
     *
     * @param \DateTime $fecha
     * @return Empresas
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
     * Set cantidadSmsUsados
     *
     * @param integer $cantidadSmsUsados
     * @return Empresas
     */
    public function setCantidadSmsUsados($cantidadSmsUsados)
    {
        $this->cantidadSmsUsados = $cantidadSmsUsados;

        return $this;
    }

    /**
     * Get cantidadSmsUsados
     *
     * @return integer 
     */
    public function getCantidadSmsUsados()
    {
        return $this->cantidadSmsUsados;
    }

    /**
     * Set cliente
     *
     * @param \Rsms\TrabajandoBundle\Entity\Clientes $cliente
     * @return Empresas
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
    
    public function __toString() {
        return $this->getNombre();
    }

    /**
     * Set rutaFoto
     *
     * @param string $rutaFoto
     * @return Empresas
     */
    public function setRutaFoto($rutaFoto)
    {
        $this->rutaFoto = $rutaFoto;

        return $this;
    }

    /**
     * Get rutaFoto
     *
     * @return string 
     */
    public function getRutaFoto()
    {
        return $this->rutaFoto;
    }
    
    /**
     * Set foto.
     *
     * @param UploadedFile $foto
     */
    public function setFoto(UploadedFile $foto = null)
    {
        $this->foto = $foto;
    }

    /**
     * Get foto.
     *
     * @return UploadedFile
     */
    public function getFoto()
    {
        return $this->foto;
    }
    
    /**
     * Sube la foto de la oferta copiándola en el directorio que se indica y
     * guardando en la entidad la ruta hasta la foto
     *
     * @param string $directorioDestino Ruta completa del directorio al que se sube la foto
     */
    public function subirFoto($directorioDestino)
    {
        if (null === $this->getFoto()) {
            return;
        }

        $nombreArchivoFoto = uniqid('rsms-').'-1.'.$this->getFoto()->guessExtension();

        $this->getFoto()->move($directorioDestino, $nombreArchivoFoto);

        $this->setRutaFoto($nombreArchivoFoto);
    }
}
