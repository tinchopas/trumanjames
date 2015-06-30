<?php

namespace Devspark\VentureJuiceBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Devspark\VentureJuiceBundle\Entity\EmailMessage;
use Devspark\VentureJuiceBundle\Form\EmailMessageType;

/**
 * EmailMessage controller.
 *
 */
class EmailMessageController extends Controller
{

    /**
     * Lists all EmailMessage entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('DevsparkVentureJuiceBundle:EmailMessage')->findAll();

        return $this->render('DevsparkVentureJuiceBundle:EmailMessage:index.html.twig', array(
            'entities' => $entities,
        ));
    }
    /**
     * Creates a new EmailMessage entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity = new EmailMessage();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('emailmessage_show', array('id' => $entity->getId())));
        }

        return $this->render('DevsparkVentureJuiceBundle:EmailMessage:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
    * Creates a form to create a EmailMessage entity.
    *
    * @param EmailMessage $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createCreateForm(EmailMessage $entity)
    {
        $form = $this->createForm(new EmailMessageType(), $entity, array(
            'action' => $this->generateUrl('emailmessage_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new EmailMessage entity.
     *
     */
    public function newAction()
    {
        $entity = new EmailMessage();
        $form   = $this->createCreateForm($entity);

        return $this->render('DevsparkVentureJuiceBundle:EmailMessage:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Finds and displays a EmailMessage entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('DevsparkVentureJuiceBundle:EmailMessage')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find EmailMessage entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('DevsparkVentureJuiceBundle:EmailMessage:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),        ));
    }

    /**
     * Displays a form to edit an existing EmailMessage entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('DevsparkVentureJuiceBundle:EmailMessage')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find EmailMessage entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('DevsparkVentureJuiceBundle:EmailMessage:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
    * Creates a form to edit a EmailMessage entity.
    *
    * @param EmailMessage $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(EmailMessage $entity)
    {
        $form = $this->createForm(new EmailMessageType(), $entity, array(
            'action' => $this->generateUrl('emailmessage_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing EmailMessage entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('DevsparkVentureJuiceBundle:EmailMessage')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find EmailMessage entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('emailmessage_edit', array('id' => $id)));
        }

        return $this->render('DevsparkVentureJuiceBundle:EmailMessage:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
    /**
     * Deletes a EmailMessage entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('DevsparkVentureJuiceBundle:EmailMessage')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find EmailMessage entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('emailmessage'));
    }

    /**
     * Creates a form to delete a EmailMessage entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('emailmessage_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
