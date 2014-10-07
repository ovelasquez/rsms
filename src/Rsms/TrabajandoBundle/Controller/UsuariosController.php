<?php

namespace Rsms\TrabajandoBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Rsms\TrabajandoBundle\Entity\Usuarios;
use Rsms\TrabajandoBundle\Form\UsuariosType;

/**
 * Usuarios controller.
 *
 * @Route("/adm/usuarios")
 */
class UsuariosController extends Controller {

    /**
     * Lists all Usuarios entities.
     *
     * @Route("/", name="usuarios")
     * @Method("GET")
     * @Template()
     */
    public function indexAction() {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('RsmsTrabajandoBundle:Usuarios')->findAll();

        return array(
            'entities' => $entities,
        );
    }

    /**
     * Creates a new Usuarios entity.
     *
     * @Route("/", name="usuarios_create")
     * @Method("POST")
     * @Template("RsmsTrabajandoBundle:Usuarios:new.html.twig")
     */
    public function createAction(Request $request) {
        $entity = new Usuarios();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $this->setSecurePassword($entity);
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('usuarios_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form' => $form->createView(),
        );
    }

    /**
     * Creates a form to create a Usuarios entity.
     *
     * @param Usuarios $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Usuarios $entity) {
        $form = $this->createForm(new UsuariosType(), $entity, array(
            'action' => $this->generateUrl('usuarios_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Usuarios entity.
     *
     * @Route("/new", name="usuarios_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction() {
        $entity = new Usuarios();
        $form = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form' => $form->createView(),
        );
    }

    /**
     * Finds and displays a Usuarios entity.
     *
     * @Route("/ver/{id}", name="usuarios_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id) {
        
        // Id usuario logueado
        $mi_id=$this->get('security.context')->getToken()->getUser()->getId();
        
       
        if ($mi_id == $id || (true === $this->get('security.context')->isGranted('ROLE_SUPER_ADMIN')) ) {
            $em = $this->getDoctrine()->getManager();

            $entity = $em->getRepository('RsmsTrabajandoBundle:Usuarios')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Usuarios entity.');
            }

            $deleteForm = $this->createDeleteForm($id);
            $editForm = $this->createEditForm($entity);

            return array(
                'entity' => $entity,
                'delete_form' => $deleteForm->createView(),
                'edit_form' => $editForm->createView(),
            );
        } return $this->redirect($this->generateUrl('usuarios_show', array('id' => $mi_id)));
    }

    /**
     * Displays a form to edit an existing Usuarios entity.
     *
     * @Route("/editar/{id}", name="usuarios_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id) {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('RsmsTrabajandoBundle:Usuarios')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Usuarios entity.');
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
     * Creates a form to edit a Usuarios entity.
     *
     * @param Usuarios $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createEditForm(Usuarios $entity) {
        $form = $this->createForm(new UsuariosType(), $entity, array(
            'action' => $this->generateUrl('usuarios_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Actualizar'));

        return $form;
    }

    /**
     * Edits an existing Usuarios entity.
     *
     * @Route("/actualizar/{id}", name="usuarios_update")
     * @Method("PUT")
     * @Template("RsmsTrabajandoBundle:Usuarios:edit.html.twig")
     */
    public function updateAction(Request $request, $id) {
        $em = $this->getDoctrine()->getManager();
        $entity = new Usuarios();
        $entity = $em->getRepository('RsmsTrabajandoBundle:Usuarios')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Usuarios entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);

        //obtiene la contraseña actual -----------------------
        $current_pass = $entity->getPassword();

        $editForm->handleRequest($request);



        if ($editForm->isValid()) {

            if ("" != $entity->getPassword()) {
                //evalua si la contraseña fue modificada: ------------------------
                if ($current_pass != $entity->getPassword()) {
                    $this->setSecurePassword($entity);
                }
            } else {
                $entity->setPassword($current_pass);
            }

            $em->flush();

            return $this->redirect($this->generateUrl('usuarios_show', array('id' => $id)));
        }

        return array(
            'entity' => $entity,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Deletes a Usuarios entity.
     *
     * @Route("/eliminar/{id}", name="usuarios_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id) {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('RsmsTrabajandoBundle:Usuarios')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Usuarios entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('usuarios'));
    }

    /**
     * Creates a form to delete a Usuarios entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id) {
        return $this->createFormBuilder()
                        ->setAction($this->generateUrl('usuarios_delete', array('id' => $id)))
                        ->setMethod('DELETE')
                        ->add('submit', 'submit', array('label' => 'Eliminar'))
                        ->getForm()
        ;
    }

    private function setSecurePassword(&$entity) {
        $encoder = new \Symfony\Component\Security\Core\Encoder\MessageDigestPasswordEncoder('sha512', true, 10);
        $password = $encoder->encodePassword($entity->getPassword(), $entity->getSalt());
        $entity->setPassword($password);
    }

}
