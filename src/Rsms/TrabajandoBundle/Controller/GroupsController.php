<?php

namespace Rsms\TrabajandoBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Rsms\TrabajandoBundle\Entity\Groups;
use Rsms\TrabajandoBundle\Form\GroupsType;

/**
 * Groups controller.
 *
 * @Route("/adm/groups")
 */
class GroupsController extends Controller {

    /**
     * Lists all Groups entities.
     *
     * @Route("/", name="groups")
     * @Method("GET")
     * @Template()
     */
    public function indexAction() {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('RsmsTrabajandoBundle:Groups')->findAll();

        return array(
            'entities' => $entities,
        );
    }

    /**
     * Creates a new Groups entity.
     *
     * @Route("/", name="groups_create")
     * @Method("POST")
     * @Template("RsmsTrabajandoBundle:Groups:new.html.twig")
     */
    public function createAction(Request $request) {
        $entity = new Groups();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('groups_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form' => $form->createView(),
        );
    }

    /**
     * Creates a form to create a Groups entity.
     *
     * @param Groups $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Groups $entity) {
        $form = $this->createForm(new GroupsType(), $entity, array(
            'action' => $this->generateUrl('groups_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Crear'));

        return $form;
    }

    /**
     * Displays a form to create a new Groups entity.
     *
     * @Route("/new", name="groups_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction() {
        $entity = new Groups();
        $form = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form' => $form->createView(),
        );
    }

    /**
     * Finds and displays a Groups entity.
     *
     * @Route("/{id}", name="groups_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id) {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('RsmsTrabajandoBundle:Groups')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Groups entity.');
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
     * Displays a form to edit an existing Groups entity.
     *
     * @Route("/{id}/edit", name="groups_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id) {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('RsmsTrabajandoBundle:Groups')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Groups entity.');
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
     * Creates a form to edit a Groups entity.
     *
     * @param Groups $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createEditForm(Groups $entity) {
        $form = $this->createForm(new GroupsType(), $entity, array(
            'action' => $this->generateUrl('groups_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Actualizar'));

        return $form;
    }

    /**
     * Edits an existing Groups entity.
     *
     * @Route("/{id}", name="groups_update")
     * @Method("PUT")
     * @Template("RsmsTrabajandoBundle:Groups:edit.html.twig")
     */
    public function updateAction(Request $request, $id) {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('RsmsTrabajandoBundle:Groups')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Groups entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('groups_show', array('id' => $id)));
        }

        return array(
            'entity' => $entity,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Deletes a Groups entity.
     *
     * @Route("/{id}", name="groups_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id) {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('RsmsTrabajandoBundle:Groups')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Groups entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('groups'));
    }

    /**
     * Creates a form to delete a Groups entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id) {
        return $this->createFormBuilder()
                        ->setAction($this->generateUrl('groups_delete', array('id' => $id)))
                        ->setMethod('DELETE')
                        ->add('submit', 'submit', array('label' => 'Eliminar'))
                        ->getForm()
        ;
    }

}
