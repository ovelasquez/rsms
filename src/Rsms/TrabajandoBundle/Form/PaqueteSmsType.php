<?php

namespace Rsms\TrabajandoBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class PaqueteSmsType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nombre', 'text', array('required' => false,'label' => 'Paquete-SMS ','attr'=>array('class'=>'form-control','placeholder'=>'Nombre del nuevo Paquete')))
            ->add('cantidadSms', null, array('required' => false,'label' => 'Cantidad-SMS ','attr'=>array('class'=>'form-control','placeholder'=>'Cantidad de SMS')))
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Rsms\TrabajandoBundle\Entity\PaqueteSms',
             'cascade_validation' => true,
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'rsms_trabajandobundle_paquetesms';
    }
}
