<?php

namespace Rsms\TrabajandoBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class EmpresaBolsaSmsType extends AbstractType {

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
                //->add('empresa')
                
                ->add('bolsaSms',null,array('required' => true,'label' => 'Bolsa SMS ','attr'=>array('class'=>'form-control')))
                //->add('fecha')
        ;
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver) {
        $resolver->setDefaults(array(
            'data_class' => 'Rsms\TrabajandoBundle\Entity\EmpresaBolsaSms'
        ));
    }

    /**
     * @return string
     */
    public function getName() {
        return 'rsms_trabajandobundle_empresabolsasms';
    }

}
