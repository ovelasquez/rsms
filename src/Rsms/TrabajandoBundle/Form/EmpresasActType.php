<?php

namespace Rsms\TrabajandoBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class EmpresasActType extends AbstractType {

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
            ->add('nombre', 'text', array('label' => 'Nombre', 'attr' => array('class' => 'form-control', 'placeholder' => 'Nombre de la empresa')))
            ->add('trabajandoid', null, array('label' => 'Trabajando', 'attr' => array('class' => 'form-control', 'placeholder' => 'Id de Trabajando')))
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
