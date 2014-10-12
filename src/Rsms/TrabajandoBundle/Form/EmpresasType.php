<?php

namespace Rsms\TrabajandoBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class EmpresasType extends AbstractType {

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
                ->add('cliente', null, array('label' => 'Cliente', 'attr' => array('class' => 'form-control', 'placeholder' => 'Nombre de la empresa')))
                ->add('nombre', 'text', array('label' => 'Nombre', 'attr' => array('class' => 'form-control', 'placeholder' => 'Nombre de la empresa')))
                ->add('trabajandoid', null, array('label' => 'Trabajando', 'attr' => array('class' => 'form-control', 'placeholder' => 'Id de Trabajando')))
                ->add('cantidadSmsUsados', 'hidden')
                ->add('elCliente', 'hidden', array("mapped" => false,))
                ->add('laEmpresa', 'hidden', array("mapped" => false,))
                ->add('EmpresaBolsaSms', new EmpresaBolsaSmsType(), array("mapped" => false, 'required' => false, 'label' => ' '))
                ->add('BolsaSms', new BolsaSmsType(), array("mapped" => false, 'required' => false, 'label' => ' '))
                ->add('foto', 'file', array('label' => 'Logo','required' => false))
                 

        ;
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver) {
        $resolver->setDefaults(array(
            'data_class' => 'Rsms\TrabajandoBundle\Entity\Empresas'
        ));
    }

    /**
     * @return string
     */
    public function getName() {
        return 'rsms_trabajandobundle_empresas';
    }

}
