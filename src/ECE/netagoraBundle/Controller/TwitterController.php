<?php

namespace ECE\netagoraBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use ECE\netagoraBundle\Entity\Twitter;
use ECE\netagoraBundle\Form\TwitterType;

/**
 * Twitter controller.
 *
 */
class TwitterController extends Controller
{
    /**
     * Lists all Twitter entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entities = $em->getRepository('netagoraBundle:Twitter')->findAll();

        return $this->render('netagoraBundle:Twitter:index.html.twig', array(
            'entities' => $entities
        ));
    }

    /**
     * Finds and displays a Twitter entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('netagoraBundle:Twitter')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Twitter entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('netagoraBundle:Twitter:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),

        ));
    }

    /**
     * Displays a form to create a new Twitter entity.
     *
     */
    public function newAction()
    {
        $entity = new Twitter();
        $form   = $this->createForm(new TwitterType(), $entity);

        return $this->render('netagoraBundle:Twitter:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView()
        ));
    }

    /**
     * Creates a new Twitter entity.
     *
     */
    public function createAction()
    {
        $entity  = new Twitter();
        $request = $this->getRequest();
        $form    = $this->createForm(new TwitterType(), $entity);
        $form->bindRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getEntityManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('twitter_show', array('id' => $entity->getId())));
            
        }

        return $this->render('netagoraBundle:Twitter:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView()
        ));
    }

    /**
     * Displays a form to edit an existing Twitter entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('netagoraBundle:Twitter')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Twitter entity.');
        }

        $editForm = $this->createForm(new TwitterType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('netagoraBundle:Twitter:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Edits an existing Twitter entity.
     *
     */
    public function updateAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('netagoraBundle:Twitter')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Twitter entity.');
        }

        $editForm   = $this->createForm(new TwitterType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        $request = $this->getRequest();

        $editForm->bindRequest($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('twitter_edit', array('id' => $id)));
        }

        return $this->render('netagoraBundle:Twitter:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Twitter entity.
     *
     */
    public function deleteAction($id)
    {
        $form = $this->createDeleteForm($id);
        $request = $this->getRequest();

        $form->bindRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getEntityManager();
            $entity = $em->getRepository('netagoraBundle:Twitter')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Twitter entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('twitter'));
    }

    private function createDeleteForm($id)
    {
        return $this->createFormBuilder(array('id' => $id))
            ->add('id', 'hidden')
            ->getForm()
        ;
    }
}
