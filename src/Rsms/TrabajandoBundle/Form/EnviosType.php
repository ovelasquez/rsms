<?php

namespace Rsms\TrabajandoBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class EnviosType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('rut')
            ->add('nombre')
            ->add('apellido')
            ->add('fono')
            ->add('oferta')
            ->add('avisoid')
            ->add('dominioid')
            ->add('empresa')
            ->add('status')
            ->add('fecha')
            ->add('codigo')
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Rsms\TrabajandoBundle\Entity\Envios'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'rsms_trabajandobundle_envios';
    }
}
