<?php

namespace ECE\netagoraBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use ECE\netagoraBundle\Entity\Publications;
use ECE\netagoraBundle\Form\PublicationsType;

/**
 * Publications controller.
 *
 */
class PublicationsController extends Controller
{
    /**
     * Lists all Publications entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entities = $em->getRepository('netagoraBundle:Publications')->findAll();

        return $this->render('netagoraBundle:Publications:index.html.twig', array(
            'entities' => $entities
        ));
    }

    /**
     * Finds and displays a Publications entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('netagoraBundle:Publications')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Publications entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('netagoraBundle:Publications:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),

        ));
    }

    /**
     * Displays a form to create a new Publications entity.
     *
     */
    public function newAction()
    {
        $entity = new Publications();
        $form   = $this->createForm(new PublicationsType(), $entity);

        return $this->render('netagoraBundle:Publications:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView()
        ));
    }

    /**
     * Creates a new Publications entity.
     *
     */
    public function createAction()
    {
        $entity  = new Publications();
        $request = $this->getRequest();
        $form    = $this->createForm(new PublicationsType(), $entity);
        $form->bindRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getEntityManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('publications_show', array('id' => $entity->getId())));
            
        }

        return $this->render('netagoraBundle:Publications:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView()
        ));
    }

    /**
     * Displays a form to edit an existing Publications entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('netagoraBundle:Publications')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Publications entity.');
        }

        $editForm = $this->createForm(new PublicationsType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('netagoraBundle:Publications:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Edits an existing Publications entity.
     *
     */
    public function updateAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('netagoraBundle:Publications')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Publications entity.');
        }

        $editForm   = $this->createForm(new PublicationsType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        $request = $this->getRequest();

        $editForm->bindRequest($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('publications_edit', array('id' => $id)));
        }

        return $this->render('netagoraBundle:Publications:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Publications entity.
     *
     */
    public function deleteAction($id)
    {
        $form = $this->createDeleteForm($id);
        $request = $this->getRequest();

        $form->bindRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getEntityManager();
            $entity = $em->getRepository('netagoraBundle:Publications')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Publications entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('publications'));
    }

    private function createDeleteForm($id)
    {
        return $this->createFormBuilder(array('id' => $id))
            ->add('id', 'hidden')
            ->getForm()
        ;
    }
}
