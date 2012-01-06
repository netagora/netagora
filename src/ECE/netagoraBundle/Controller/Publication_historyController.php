<?php

namespace ECE\netagoraBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use ECE\netagoraBundle\Entity\Publication_history;
use ECE\netagoraBundle\Form\Publication_historyType;

/**
 * Publication_history controller.
 *
 */
class Publication_historyController extends Controller
{
    /**
     * Lists all Publication_history entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entities = $em->getRepository('netagoraBundle:Publication_history')->findAll();

        return $this->render('netagoraBundle:Publication_history:index.html.twig', array(
            'entities' => $entities
        ));
    }

    /**
     * Finds and displays a Publication_history entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('netagoraBundle:Publication_history')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Publication_history entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('netagoraBundle:Publication_history:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),

        ));
    }

    /**
     * Displays a form to create a new Publication_history entity.
     *
     */
    public function newAction()
    {
        $entity = new Publication_history();
        $form   = $this->createForm(new Publication_historyType(), $entity);

        return $this->render('netagoraBundle:Publication_history:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView()
        ));
    }

    /**
     * Creates a new Publication_history entity.
     *
     */
    public function createAction()
    {
        $entity  = new Publication_history();
        $request = $this->getRequest();
        $form    = $this->createForm(new Publication_historyType(), $entity);
        $form->bindRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getEntityManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('publication_history_show', array('id' => $entity->getId())));
            
        }

        return $this->render('netagoraBundle:Publication_history:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView()
        ));
    }

    /**
     * Displays a form to edit an existing Publication_history entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('netagoraBundle:Publication_history')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Publication_history entity.');
        }

        $editForm = $this->createForm(new Publication_historyType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('netagoraBundle:Publication_history:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Edits an existing Publication_history entity.
     *
     */
    public function updateAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('netagoraBundle:Publication_history')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Publication_history entity.');
        }

        $editForm   = $this->createForm(new Publication_historyType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        $request = $this->getRequest();

        $editForm->bindRequest($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('publication_history_edit', array('id' => $id)));
        }

        return $this->render('netagoraBundle:Publication_history:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Publication_history entity.
     *
     */
    public function deleteAction($id)
    {
        $form = $this->createDeleteForm($id);
        $request = $this->getRequest();

        $form->bindRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getEntityManager();
            $entity = $em->getRepository('netagoraBundle:Publication_history')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Publication_history entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('publication_history'));
    }

    private function createDeleteForm($id)
    {
        return $this->createFormBuilder(array('id' => $id))
            ->add('id', 'hidden')
            ->getForm()
        ;
    }
}
