<?php

namespace Rsms\TrabajandoBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Rsms\TrabajandoBundle\Entity\Empresas;
use Rsms\TrabajandoBundle\Form\EmpresasType;
use Rsms\TrabajandoBundle\Form\EmpresasActType;
use Rsms\TrabajandoBundle\Entity\EmpresaBolsaSms;
use Rsms\TrabajandoBundle\Entity\BolsaSms;
use Rsms\TrabajandoBundle\Entity\Clientes;
use Rsms\TrabajandoBundle\Entity\ClientePaqueteSms;

/**
 * Empresas controller.
 *
 * @Route("/adm/empresas")
 */
class EmpresasController extends Controller {

    /**
     * Lists all Empresas entities.
     *
     * @Route("/", name="empresas")
     * @Method("GET")
     * @Template()
     */
    public function indexAction() {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('RsmsTrabajandoBundle:Empresas')->findAll();

        return array(
            'entities' => $entities,
        );
    }

    /**
     * Creates a new Empresas entity.
     *
     * @Route("/", name="empresas_create")
     * @Method("POST")
     * @Template("RsmsTrabajandoBundle:Empresas:new.html.twig")
     */
    public function createAction(Request $request) {
        $var = $request->request->get('rsms_trabajandobundle_empresas');
        $entity = new Empresas();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $entity->subirFoto($this->container->getParameter('rsms.directorio.imagenes'));
            $em = $this->getDoctrine()->getManager();
            $entity->setFecha(new \DateTime());
            

            /*
             * Oscar Velasquez
             * Creamos el cliente si elCliente==0
             * 
             */


            if (isset($var["laEmpresa"]) && $var["laEmpresa"] != '') {
                //Buscamos la empresa                              
                $entity = $em->getRepository('RsmsTrabajandoBundle:Empresas')->find($var["laEmpresa"]);
            }

            $empresaBolsaSms = new EmpresaBolsaSms();
            $empresaBolsaSms->setEmpresa($entity);
            $empresaBolsaSms->setFecha(new \DateTime());


            $bolsaSms = new BolsaSms();

            // Existe la bolsa
            if (isset($var["EmpresaBolsaSms"]["bolsaSms"]) && $var["EmpresaBolsaSms"]["bolsaSms"] != '') {
                $bolsaSms = $em->getRepository('RsmsTrabajandoBundle:BolsaSms')->find($var["EmpresaBolsaSms"]["bolsaSms"]);
                $empresaBolsaSms->setBolsaSms($bolsaSms);
            } else {
                //Creamos la BolsaSms

                $bolsaSms->setNombre($var["BolsaSms"]["nombre"]);
                $bolsaSms->setCantidadSms($var["BolsaSms"]["cantidadSms"]);
                $em->persist($bolsaSms);
                $empresaBolsaSms->setBolsaSms($bolsaSms);
            }

            if (isset($var["elCliente"]) && $var["elCliente"] != '') {

                $cliente = $em->getRepository('RsmsTrabajandoBundle:Clientes')->find($var["elCliente"]);

                //$clientePaqueteSms = new ClientePaqueteSms();
                $clientePaqueteSms = $em->getRepository('RsmsTrabajandoBundle:ClientePaqueteSms')->findByCliente($cliente->getId());
                $cantidadSmsAdquiridos = 0;
                foreach ($clientePaqueteSms as $c) {
                    $cantidadSmsAdquiridos = $cantidadSmsAdquiridos + $c->getPaqueteSms()->getCantidadSms();
                }

                $cantidadSmsAdquiridos = ($cantidadSmsAdquiridos - $cliente->getCantidadSmsUsados());
                $error = '';

                if ($bolsaSms->getCantidadSms() <= $cantidadSmsAdquiridos) {
                    //Incrementamos la cantidad de SMS usados al cliente
                    $cliente->setCantidadSmsUsados($cliente->getCantidadSmsUsados() + $bolsaSms->getCantidadSms());
                    $entity->setCliente($cliente);

                    $em->persist($entity);
                    $em->persist($empresaBolsaSms);
                    $em->persist($cliente);
                    $em->flush();
                } else {

                    $error = 1;
                    $errors = $form->getErrors();
                }
            }

            if (isset($var["cliente"]) && $var["cliente"] == '') {
                return $this->redirect($this->generateUrl('clientes_show', array('id' => $var["elCliente"], 'error' => $error)));
            } else {
                return $this->redirect($this->generateUrl('empresas_show', array('id' => $var["laEmpresa"], 'error' => $error)));
            }
        }

        return array(
            'entity' => $entity,
            'form' => $form->createView(),
        );
    }

    /**
     * Creates a form to create a Empresas entity.
     *
     * @param Empresas $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Empresas $entity) {
        $form = $this->createForm(new EmpresasType(), $entity, array(
            'action' => $this->generateUrl('empresas_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Crear', 'attr' => array('class' => 'btn btn-primary')));

        return $form;
    }

    /**
     * Displays a form to create a new Empresas entity.
     *
     * @Route("/new", name="empresas_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction() {
        $entity = new Empresas();
        $form = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form' => $form->createView(),
        );
    }

    /**
     * Finds and displays a Empresas entity.
     *
     * @Route("/{id}/{error}", name="empresas_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id, $error = null) {

        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('RsmsTrabajandoBundle:Empresas')->find($id);



        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Empresas entity.');
        }

        $empresaBolsaSms = new EmpresaBolsaSms();
        $empresaBolsaSms = $em->getRepository('RsmsTrabajandoBundle:EmpresaBolsaSms')->findByEmpresa($entity->getId());
        $contadorSmsAdquiridos = 0;

        foreach ($empresaBolsaSms as $sms) {
            $contadorSmsAdquiridos = $contadorSmsAdquiridos + $sms->getBolsaSms()->getCantidadSms();
        }


        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);
        $crearFormEmpresa = $this->createCreateForm($entity);

        if ($error == 1) {
            $error = "Cantidad de SMS insuficiente";
        } else {
            $error = '';
        }

        return array(
            'entity' => $entity,
            'delete_form' => $deleteForm->createView(),
            'empresaBolsaSms' => $empresaBolsaSms,
            'contadorSmsAdquiridos' => $contadorSmsAdquiridos,
            'crearFormEmpresa' => $crearFormEmpresa->createView(),
            'edit_form' => $editForm->createView(),
            'error' => $error,
        );
    }

    /**
     * Displays a form to edit an existing Empresas entity.
     *
     * @Route("/{id}/edit", name="empresas_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id) {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('RsmsTrabajandoBundle:Empresas')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Empresas entity.');
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
     * Creates a form to edit a Empresas entity.
     *
     * @param Empresas $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createEditForm(Empresas $entity) {
        $form = $this->createForm(new EmpresasActType(), $entity, array(
            'action' => $this->generateUrl('empresas_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Actualizar', 'attr' => array('class' => 'btn btn-success')));

        return $form;
    }

    /**
     * Edits an existing Empresas entity.
     *
     * @Route("/{id}", name="empresas_update")
     * @Method("PUT")
     * @Template("RsmsTrabajandoBundle:Empresas:edit.html.twig")
     */
    public function updateAction(Request $request, $id) {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('RsmsTrabajandoBundle:Empresas')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Empresas entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
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

            return $this->redirect($this->generateUrl('empresas_show', array('id' => $id)));
        }

        return array(
            'entity' => $entity,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Deletes a Empresas entity.
     *
     * @Route("/{id}", name="empresas_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id) {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('RsmsTrabajandoBundle:Empresas')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Empresas entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('empresas'));
    }

    /**
     * Creates a form to delete a Empresas entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id) {
        return $this->createFormBuilder()
                        ->setAction($this->generateUrl('empresas_delete', array('id' => $id)))
                        ->setMethod('DELETE')
                        ->add('submit', 'submit', array('label' => 'Delete'))
                        ->getForm()
        ;
    }

}
