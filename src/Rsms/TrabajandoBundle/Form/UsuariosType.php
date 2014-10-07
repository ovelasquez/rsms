<?php

namespace Rsms\TrabajandoBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class UsuariosType extends AbstractType {

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
                ->add('nombre', 'text', array(
                    'label' => '* Nombre(s)',
                    'required' => true,
                    'attr' => array(
                        'class' => 'form-control',
                        'placeholder' => 'Indique el o los Nombre(s)'),
                    'label_attr' => array('class' => 'control-label')
                ))
                ->add('apellido', 'text', array(
                    'label' => '* Apellido(s)',
                    'required' => true,
                    'attr' => array(
                        'class' => 'form-control',
                        'placeholder' => 'Indique el o los Apellido(s)'),
                    'label_attr' => array(
                        'class' => 'control-label')
                ))
                ->add('username', 'text', array(
                    'label' => '* Usuario',
                    'required' => true,
                    'attr' => array(
                        'class' => 'form-control',
                        'placeholder' => 'Nombre de Usuario'
                    ),
                    'label_attr' => array(
                        'class' => 'control-label')
                ))
                ->add('salt', 'hidden')
                
                
                ->add('password', 'password', array(
                    'label' => '* Password',
                    'required' => false,
                    'attr' => array(
                        'class' => 'form-control',
                        'placeholder' => 'Contraseña de acceso'
                    ),
                    'label_attr' => array(
                        'class' => 'control-label')
                ))
                
                
                
                
                
                ->add('email', 'email', array(
                    'label' => '* Correo Electrónico',
                    'required' => true,
                    'attr' => array(
                        'class' => 'form-control',
                        'placeholder' => 'Correo'),
                    'label_attr' => array(
                        'class' => 'control-label')
                ))
                ->add('group', null, array(
                    'label' => '* Roles',
                    'label_attr' => array(
                        'class' => 'control-label'
                    ),
                    'multiple' => true,
                    'expanded' => true,
                    'attr' => array('class' => ''),
                ))
                ->add('cliente', null, array('label' => 'Cliente', 'attr' => array('class' => 'form-control', 'placeholder' => 'Nombre de la empresa')))
                ->add('isActive', 'checkbox', array('required' => false, 'label' => 'Activo',))
        ;
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver) {
        $resolver->setDefaults(array(
            'data_class' => 'Rsms\TrabajandoBundle\Entity\Usuarios'
        ));
    }

    /**
     * @return string
     */
    public function getName() {
        return 'rsms_trabajandobundle_usuarios';
    }

}
