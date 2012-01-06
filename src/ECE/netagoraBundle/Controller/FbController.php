<?php

namespace ECE\netagoraBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use ECE\netagoraBundle\Entity\Fb;
use ECE\netagoraBundle\Form\FbType;

/**
 * Fb controller.
 *
 */
class FbController extends Controller
{
    /**
     * Lists all Fb entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entities = $em->getRepository('netagoraBundle:Fb')->findAll();

        return $this->render('netagoraBundle:Fb:index.html.twig', array(
            'entities' => $entities
        ));
    }

    /**
     * Finds and displays a Fb entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('netagoraBundle:Fb')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Fb entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('netagoraBundle:Fb:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),

        ));
    }

    /**
     * Displays a form to create a new Fb entity.
     *
     */
    public function newAction()
    {
        $entity = new Fb();
        $form   = $this->createForm(new FbType(), $entity);

        return $this->render('netagoraBundle:Fb:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView()
        ));
    }

    /**
     * Creates a new Fb entity.
     *
     */
    public function createAction()
    {
        $entity  = new Fb();
        $request = $this->getRequest();
        $form    = $this->createForm(new FbType(), $entity);
        $form->bindRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getEntityManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('fb_show', array('id' => $entity->getId())));
            
        }

        return $this->render('netagoraBundle:Fb:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView()
        ));
    }

    /**
     * Displays a form to edit an existing Fb entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('netagoraBundle:Fb')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Fb entity.');
        }

        $editForm = $this->createForm(new FbType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('netagoraBundle:Fb:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Edits an existing Fb entity.
     *
     */
    public function updateAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('netagoraBundle:Fb')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Fb entity.');
        }

        $editForm   = $this->createForm(new FbType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        $request = $this->getRequest();

        $editForm->bindRequest($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('fb_edit', array('id' => $id)));
        }

        return $this->render('netagoraBundle:Fb:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Fb entity.
     *
     */
    public function deleteAction($id)
    {
        $form = $this->createDeleteForm($id);
        $request = $this->getRequest();

        $form->bindRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getEntityManager();
            $entity = $em->getRepository('netagoraBundle:Fb')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Fb entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('fb'));
    }

    private function createDeleteForm($id)
    {
        return $this->createFormBuilder(array('id' => $id))
            ->add('id', 'hidden')
            ->getForm()
        ;
    }
}
