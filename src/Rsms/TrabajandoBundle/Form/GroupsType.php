<?php

namespace Rsms\TrabajandoBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class GroupsType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            
                ->add('name', 'text', array(
                    'label' => '* Nombre',
                    'required' => true,
                    'attr' => array(
                        'class' => 'form-control',
                        'placeholder' => 'Indique el nombre del rol'),
                    'label_attr' => array('class' => 'control-label')
                ))
                 ->add('role', 'text', array(
                    'label' => '* Rol',
                    'required' => true,
                    'attr' => array(
                        'class' => 'form-control',
                        'placeholder' => 'Indique el tipo de rol'),
                    'label_attr' => array('class' => 'control-label')
                ))
            
            //->add('usuarios')
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Rsms\TrabajandoBundle\Entity\Groups'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'rsms_trabajandobundle_groups';
    }
}
