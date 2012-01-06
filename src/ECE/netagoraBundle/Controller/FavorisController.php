<?php

namespace ECE\netagoraBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use ECE\netagoraBundle\Entity\Favoris;
use ECE\netagoraBundle\Form\FavorisType;

/**
 * Favoris controller.
 *
 */
class FavorisController extends Controller
{
    /**
     * Lists all Favoris entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entities = $em->getRepository('netagoraBundle:Favoris')->findAll();

        return $this->render('netagoraBundle:Favoris:index.html.twig', array(
            'entities' => $entities
        ));
    }

    /**
     * Finds and displays a Favoris entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('netagoraBundle:Favoris')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Favoris entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('netagoraBundle:Favoris:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),

        ));
    }

    /**
     * Displays a form to create a new Favoris entity.
     *
     */
    public function newAction()
    {
        $entity = new Favoris();
        $form   = $this->createForm(new FavorisType(), $entity);

        return $this->render('netagoraBundle:Favoris:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView()
        ));
    }

    /**
     * Creates a new Favoris entity.
     *
     */
    public function createAction()
    {
        $entity  = new Favoris();
        $request = $this->getRequest();
        $form    = $this->createForm(new FavorisType(), $entity);
        $form->bindRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getEntityManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('favoris_show', array('id' => $entity->getId())));
            
        }

        return $this->render('netagoraBundle:Favoris:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView()
        ));
    }

    /**
     * Displays a form to edit an existing Favoris entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('netagoraBundle:Favoris')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Favoris entity.');
        }

        $editForm = $this->createForm(new FavorisType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('netagoraBundle:Favoris:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Edits an existing Favoris entity.
     *
     */
    public function updateAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('netagoraBundle:Favoris')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Favoris entity.');
        }

        $editForm   = $this->createForm(new FavorisType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        $request = $this->getRequest();

        $editForm->bindRequest($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('favoris_edit', array('id' => $id)));
        }

        return $this->render('netagoraBundle:Favoris:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Favoris entity.
     *
     */
    public function deleteAction($id)
    {
        $form = $this->createDeleteForm($id);
        $request = $this->getRequest();

        $form->bindRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getEntityManager();
            $entity = $em->getRepository('netagoraBundle:Favoris')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Favoris entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('favoris'));
    }

    private function createDeleteForm($id)
    {
        return $this->createFormBuilder(array('id' => $id))
            ->add('id', 'hidden')
            ->getForm()
        ;
    }
}
