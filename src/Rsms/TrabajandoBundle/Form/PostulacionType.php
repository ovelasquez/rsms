<?php

namespace Rsms\TrabajandoBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class PostulacionType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('mensaje')
            ->add('status')
            ->add('fechaCarga')
            ->add('fono')
            ->add('mensajeRepuesta')
            ->add('fechaRepuesta')
            ->add('statusRepuesta')
            ->add('idEnvio')
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Rsms\TrabajandoBundle\Entity\Postulacion'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'rsms_trabajandobundle_postulacion';
    }
}
