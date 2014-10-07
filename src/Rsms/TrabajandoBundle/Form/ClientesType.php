<?php

namespace Rsms\TrabajandoBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ClientesType extends AbstractType {

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
//                ->add('nombre','text',array('label' => 'Nombre','label_attr'=>array('class'=>'col-sm-2 control-label'),'attr'=>array('class'=>'form-control','placeholder'=>'Nombre del cliente')))
//                ->add('cantidadSmsUsados','hidden')
//                ->add('ClientePaqueteSms', new ClientePaqueteSmsType(),array('label' => ' '))
//                ->add('PaqueteSms', new PaqueteSmsType(),array('label' => ' '))                
        
                
                ->add('nombre','text',array('label' => 'Nombre','attr'=>array('class'=>'form-control','placeholder'=>'Nombre del cliente')))
                ->add('cantidadSmsUsados','hidden')                
                ->add('ClientePaqueteSms', new ClientePaqueteSmsType(),array("mapped" => false,'required' => false,'label' => ' '))
               ->add('PaqueteSms', new PaqueteSmsType(),array("mapped" => false,'required' => false,'label' => ' '))         
                ->add('newcliente', 'hidden', array("mapped" => false,))
                ->add('foto', 'file', array('required' => false))
                ;
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver) {
        $resolver->setDefaults(array(
            'data_class' => 'Rsms\TrabajandoBundle\Entity\Clientes'
        ));
    }

    /**
     * @return string
     */
    public function getName() {
        return 'rsms_trabajandobundle_clientes';
    }

}
