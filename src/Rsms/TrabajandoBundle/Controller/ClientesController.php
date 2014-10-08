<?php

namespace Rsms\TrabajandoBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Rsms\TrabajandoBundle\Entity\Clientes;
use Rsms\TrabajandoBundle\Form\ClientesType;
use Rsms\TrabajandoBundle\Form\ClientesActType;
use Rsms\TrabajandoBundle\Entity\PaqueteSms;
use Rsms\TrabajandoBundle\Entity\ClientePaqueteSms;
use Rsms\TrabajandoBundle\Form\ClientesPaqueteSmsType;
use Rsms\TrabajandoBundle\Entity\Empresas;
use Rsms\TrabajandoBundle\Form\EmpresasType;
use Symfony\Component\Filesystem\Filesystem;

/**
 * Clientes controller.
 *
 * @Route("/adm/clientes")
 */
class ClientesController extends Controller {

    /**
     * Lists all Clientes entities.
     *
     * @Route("/", name="clientes")
     * @Method("GET")
     * @Template()
     */
    public function indexAction() {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('RsmsTrabajandoBundle:Clientes')->findAll();

        return array(
            'entities' => $entities,
        );
    }

    /**
     * Creates a new Clientes entity.
     *
     * @Route("/", name="clientes_create")
     * @Method("POST")
     * @Template("RsmsTrabajandoBundle:Clientes:new.html.twig")
     */
    public function createAction(Request $request) {

        $var = $request->request->get('rsms_trabajandobundle_clientes');

//        echo ("<pre>");
//        debug_zval_dump($var);
//        echo ("</pre>");

        $entity = new Clientes();

        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $entity->subirFoto($this->container->getParameter('rsms.directorio.imagenes'));
            $paqueteNuevo = false;

            /*
             * Oscar Velasquez
             * Si se elije crear un paquete nuevo, entonces obtenemos los valores
             * y la creamos en la BD, para luego enviarla a entidad Clientes para haga la
             * relacion Cliente PaqueteSMS
             */
            if ($var['PaqueteSms']['nombre'] != "") {
                $paqueteNuevo = true;
                $paquete = new PaqueteSms();
                $paquete->setNombre($var['PaqueteSms']['nombre']);
                $paquete->setCantidadSms($var['PaqueteSms']['cantidadSms']);
                $em = $this->getDoctrine()->getManager();
                $em->persist($paquete);
                $em->flush();
            }

            /*
             * Oscar Velasquez
             * Creamos el cliente
             * 
             */
            $em = $this->getDoctrine()->getManager();
            if ($var["newcliente"] == 0) {
                $em->persist($entity);
                $em->flush();
            } else {
                $entity = $em->getRepository('RsmsTrabajandoBundle:Clientes')->find($var["newcliente"]);
            }

            /*
             * Programador: Oscar Daniel Velasquez
             * 
             * Si hay un paquete seleccionado entonces 
             *      se debe crear primero el cliente y despues la relacion ClientePaqueteSms,
             * sino
             *      hay que crear primero el paquete y lugo crear el cliente y despues ClientepaqueteSms
             *
             */
            $clientePaqueteSms = new ClientePaqueteSms();
            $clientePaqueteSms->setCliente($entity);
            $clientePaqueteSms->setFecha(new \DateTime());
            if (!$paqueteNuevo) {
                $paquete = $em->getRepository('RsmsTrabajandoBundle:PaqueteSms')->find($var['ClientePaqueteSms']['paqueteSms']);
                $clientePaqueteSms->setPaqueteSms($paquete);
            } else {
                $clientePaqueteSms->setPaqueteSms($paquete);
            }
            $em->persist($clientePaqueteSms);
            $em->flush();

            return $this->redirect($this->generateUrl('clientes_show', array('id' => $entity->getId())));
        }
        //echo ":("; die;

        return array(
            'entity' => $entity,
            'form' => $form->createView(),
        );
    }

    /**
     * Creates a form to create a Clientes entity.
     *
     * @param Clientes $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Clientes $entity) {
        $form = $this->createForm(new ClientesType(), $entity, array(
            'action' => $this->generateUrl('clientes_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Crear', 'attr' => array('class' => 'btn btn-primary')));

        return $form;
    }

    /**
     * Displays a form to create a new Clientes entity.
     *
     * @Route("/new", name="clientes_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction() {
        $entity = new Clientes();
        $form = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form' => $form->createView(),
        );
    }

    /**
     * Finds and displays a Clientes entity.
     *
     * @Route("/ver/{id}/{error}", name="clientes_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id, $error = null) {

        // Id del cliente asociado del usuaio logueado
        $cliente = $this->get('security.context')->getToken()->getUser()->getCliente()->getId();

        if ($cliente == $id || (true === $this->get('security.context')->isGranted('ROLE_SUPER_ADMIN'))) {


            $em = $this->getDoctrine()->getManager();

            $entity = $em->getRepository('RsmsTrabajandoBundle:Clientes')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Empresas entity.');
            }
            /*
             * Oscar Velasquez
             * Buscamos todos los paquetesSms asociados al cliente
             */
            $paquetes = new ClientePaqueteSms();
            $paquetes = $em->getRepository('RsmsTrabajandoBundle:ClientePaqueteSms')->findByCliente($id);

            $contadorSmsAdquiridos = 0;

            foreach ($paquetes as $sms) {
                $contadorSmsAdquiridos = $contadorSmsAdquiridos + $sms->getPaqueteSms()->getCantidadSms();
            }

            $nuevoPaquetes = new ClientePaqueteSms();
            $form = $this->createForm(new ClientesPaqueteSmsType(), $entity, array(
                'action' => $this->generateUrl('clientes_create'),
                'method' => 'POST',
            ));

            $form->add('submit', 'submit', array('label' => 'Comprar'));

            /*
             * Oscar Velasquez
             * Buscamos todos las empresas asociadas al cliente
             */
            $nuevoempresas = new Empresas();
            $empresaForm = $this->createForm(new EmpresasType(), $nuevoempresas, array(
                'action' => $this->generateUrl('empresas_create'),
                'method' => 'POST',
            ));
            $empresaForm->add('submit', 'submit', array('label' => 'Crear'));
            $empresas = $em->getRepository('RsmsTrabajandoBundle:Empresas')->findByCliente($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Clientes entity.');
            }

            $editForm = $this->createEditForm($entity);
            $deleteForm = $this->createDeleteForm($id);

            if ($error == 1) {
                $error = "Cantidad de SMS insuficiente";
            } else {
                $error = '';
            }

            return array(
                'entity' => $entity,
                'paquetes' => $paquetes,
                'empresas' => $empresas,
                'delete_form' => $deleteForm->createView(),
                'edit_form' => $editForm->createView(),
                '_form' => $form->createView(),
                'empresaForm' => $empresaForm->createView(),
                'contadorSmsAdquiridos' => $contadorSmsAdquiridos,
                'error' => $error,
            );
        }
        return $this->redirect($this->generateUrl('clientes_show', array('id' => $cliente)));
    }

    /**
     * Displays a form to edit an existing Clientes entity.
     *
     * @Route("/editar/{id}/", name="clientes_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id) {

        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('RsmsTrabajandoBundle:Clientes')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Clientes entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity' => $entity,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Creates a form to edit a Clientes entity.
     *
     * @param Clientes $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createEditForm(Clientes $entity) {
        $form = $this->createForm(new ClientesActType(), $entity, array(
            'action' => $this->generateUrl('clientes_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Actualizar', 'attr' => array('class' => 'btn btn-success')));



        return $form;
    }

    /**
     * Edits an existing Clientes entity.
     *
     * @Route("/actualizar/{id}", name="clientes_update")
     * @Method("PUT")
     * @Template("RsmsTrabajandoBundle:Clientes:edit.html.twig")
     */
    public function updateAction(Request $request, $id) {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('RsmsTrabajandoBundle:Clientes')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Clientes entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        
        // Guardar la ruta de la foto original de la oferta
        $rutaFotoOriginal = $editForm->getData()->getRutaFoto();
        
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            if (null == $entity->getFoto()) {
                // el usuario no ha modificado la foto original
                $entity->setRutaFoto($rutaFotoOriginal);
            } else {
                // el usuario ha modificado la foto: copiar la foto subida y
                // guardar la nueva ruta
                $entity->subirFoto($this->container->getParameter('rsms.directorio.imagenes'));

                // borrar la foto anterior
                if (!empty($rutaFotoOriginal)) {
                    $fs = new Filesystem();
                    $fs->remove($this->container->getParameter('rsms.directorio.imagenes') . $rutaFotoOriginal);
                }
            }
            $em->flush();

            return $this->redirect($this->generateUrl('clientes_show', array('id' => $id)));
        }

        return array(
            'entity' => $entity,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Deletes a Clientes entity.
     *
     * @Route("/{id}", name="clientes_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id) {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('RsmsTrabajandoBundle:Clientes')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Clientes entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('clientes'));
    }

    /**
     * Creates a form to delete a Clientes entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id) {
        return $this->createFormBuilder()
                        ->setAction($this->generateUrl('clientes_delete', array('id' => $id)))
                        ->setMethod('DELETE')
                        ->add('submit', 'submit', array('label' => 'Delete'))
                        ->getForm()
        ;
    }

}
