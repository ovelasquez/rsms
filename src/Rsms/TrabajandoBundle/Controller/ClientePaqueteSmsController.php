<?php

namespace Rsms\TrabajandoBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Rsms\TrabajandoBundle\Entity\ClientePaqueteSms;
use Rsms\TrabajandoBundle\Form\ClientePaqueteSmsType;

/**
 * ClientePaqueteSms controller.
 *
 * @Route("/adm/clientepaquetesms")
 */
class ClientePaqueteSmsController extends Controller
{

    /**
     * Lists all ClientePaqueteSms entities.
     *
     * @Route("/", name="clientepaquetesms")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('RsmsTrabajandoBundle:ClientePaqueteSms')->findAll();

        return array(
            'entities' => $entities,
        );
    }
    /**
     * Creates a new ClientePaqueteSms entity.
     *
     * @Route("/", name="clientepaquetesms_create")
     * @Method("POST")
     * @Template("RsmsTrabajandoBundle:ClientePaqueteSms:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new ClientePaqueteSms();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity->setFecha(new \DateTime());            
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('clientepaquetesms_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
    * Creates a form to create a ClientePaqueteSms entity.
    *
    * @param ClientePaqueteSms $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createCreateForm(ClientePaqueteSms $entity)
    {
        $form = $this->createForm(new ClientePaqueteSmsType(), $entity, array(
            'action' => $this->generateUrl('clientepaquetesms_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new ClientePaqueteSms entity.
     *
     * @Route("/new", name="clientepaquetesms_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new ClientePaqueteSms();
        $form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a ClientePaqueteSms entity.
     *
     * @Route("/{id}", name="clientepaquetesms_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('RsmsTrabajandoBundle:ClientePaqueteSms')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find ClientePaqueteSms entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing ClientePaqueteSms entity.
     *
     * @Route("/{id}/edit", name="clientepaquetesms_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('RsmsTrabajandoBundle:ClientePaqueteSms')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find ClientePaqueteSms entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
    * Creates a form to edit a ClientePaqueteSms entity.
    *
    * @param ClientePaqueteSms $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(ClientePaqueteSms $entity)
    {
        $form = $this->createForm(new ClientePaqueteSmsType(), $entity, array(
            'action' => $this->generateUrl('clientepaquetesms_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing ClientePaqueteSms entity.
     *
     * @Route("/{id}", name="clientepaquetesms_update")
     * @Method("PUT")
     * @Template("RsmsTrabajandoBundle:ClientePaqueteSms:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('RsmsTrabajandoBundle:ClientePaqueteSms')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find ClientePaqueteSms entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('clientepaquetesms_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a ClientePaqueteSms entity.
     *
     * @Route("/{id}", name="clientepaquetesms_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('RsmsTrabajandoBundle:ClientePaqueteSms')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find ClientePaqueteSms entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('clientepaquetesms'));
    }

    /**
     * Creates a form to delete a ClientePaqueteSms entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('clientepaquetesms_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
