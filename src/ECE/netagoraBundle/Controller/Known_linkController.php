<?php

namespace ECE\netagoraBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use ECE\netagoraBundle\Entity\Known_link;
use ECE\netagoraBundle\Form\Known_linkType;

/**
 * Known_link controller.
 *
 */
class Known_linkController extends Controller
{
    /**
     * Lists all Known_link entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entities = $em->getRepository('netagoraBundle:Known_link')->findAll();

        return $this->render('netagoraBundle:Known_link:index.html.twig', array(
            'entities' => $entities
        ));
    }

    /**
     * Finds and displays a Known_link entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('netagoraBundle:Known_link')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Known_link entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('netagoraBundle:Known_link:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),

        ));
    }

    /**
     * Displays a form to create a new Known_link entity.
     *
     */
    public function newAction()
    {
        $entity = new Known_link();
        $form   = $this->createForm(new Known_linkType(), $entity);

        return $this->render('netagoraBundle:Known_link:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView()
        ));
    }

    /**
     * Creates a new Known_link entity.
     *
     */
    public function createAction()
    {
        $entity  = new Known_link();
        $request = $this->getRequest();
        $form    = $this->createForm(new Known_linkType(), $entity);
        $form->bindRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getEntityManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('known_link_show', array('id' => $entity->getId())));
            
        }

        return $this->render('netagoraBundle:Known_link:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView()
        ));
    }

    /**
     * Displays a form to edit an existing Known_link entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('netagoraBundle:Known_link')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Known_link entity.');
        }

        $editForm = $this->createForm(new Known_linkType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('netagoraBundle:Known_link:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Edits an existing Known_link entity.
     *
     */
    public function updateAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('netagoraBundle:Known_link')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Known_link entity.');
        }

        $editForm   = $this->createForm(new Known_linkType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        $request = $this->getRequest();

        $editForm->bindRequest($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('known_link_edit', array('id' => $id)));
        }

        return $this->render('netagoraBundle:Known_link:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Known_link entity.
     *
     */
    public function deleteAction($id)
    {
        $form = $this->createDeleteForm($id);
        $request = $this->getRequest();

        $form->bindRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getEntityManager();
            $entity = $em->getRepository('netagoraBundle:Known_link')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Known_link entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('known_link'));
    }

    private function createDeleteForm($id)
    {
        return $this->createFormBuilder(array('id' => $id))
            ->add('id', 'hidden')
            ->getForm()
        ;
    }
}
