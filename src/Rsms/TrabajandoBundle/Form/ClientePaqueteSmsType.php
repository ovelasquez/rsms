<?php

namespace Rsms\TrabajandoBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ClientePaqueteSmsType extends AbstractType {

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
//                ->add('cliente')
//                ->add('paqueteSms',null,array('label' => 'Paquete-SMS ','label_attr'=>array('class'=>'col-sm-2 control-label'),'attr'=>array('class'=>'form-control')))
//                ->add('fecha')
                
                ->add('paqueteSms',null,array('required' => true,'label' => 'Paquete-SMS ','attr'=>array('class'=>'form-control')))
        ;
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver) {
        $resolver->setDefaults(array(
            'data_class' => 'Rsms\TrabajandoBundle\Entity\ClientePaqueteSms',
            'cascade_validation' => true,
        ));
    }

    /**
     * @return string
     */
    public function getName() {
        return 'rsms_trabajandobundle_clientepaquetesms';
    }

}
