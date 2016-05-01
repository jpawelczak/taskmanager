<?php

namespace TaskMngBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use TaskMngBundle\Entity\Category;
use TaskMngBundle\Form\CategoryType;

/**
 * Category controller.
 *
 * @Route("/category")
 */
class CategoryController extends Controller
{

    /**
     * Lists all Categories.
     *
     * @Route("/", name="category")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $categories = $em->getRepository('TaskMngBundle:Category')->findAll();

        return array(
            'categories' => $categories,
        );
    }
    /**
     * Creates a new Category.
     *
     * @Route("/", name="category_create")
     * @Method("POST")
     * @Template("TaskMngBundle:Category:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $newCategory = new Category();

        $form = $this->createCreateForm($newCategory);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($newCategory);
            $em->flush();

            return $this->redirect($this->generateUrl('category_show', array('id' => $newCategory->getId())));
        }

        return array(
            'category' => $newCategory,
            'form'   => $form->createView(),
        );
    }

    /**
     * Creates a form to create a Category.
     *
     * @param Category $newCategory The new category
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Category $newCategory)
    {
        $form = $this->createForm(new CategoryType(), $newCategory, array(
            'action' => $this->generateUrl('category_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array(
            'label' => 'Create',
            'attr' => array('class' => 'btn btn-sm btn-success')));

        return $form;
    }

    /**
     * Displays a form to create a new Category.
     *
     * @Route("/new", name="category_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $newCategory = new Category();
        $form   = $this->createCreateForm($newCategory);

        return array(
            'category' => $newCategory,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a Category.
     *
     * @Route("/{id}", name="category_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $category = $em->getRepository('TaskMngBundle:Category')->find($id);

        if (!$category) {
            throw $this->createNotFoundException('Unable to find Category.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'category'      => $category,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Category.
     *
     * @Route("/{id}/edit", name="category_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $category = $em->getRepository('TaskMngBundle:Category')->find($id);

        if (!$category) {
            throw $this->createNotFoundException('Unable to find Category.');
        }

        $editForm = $this->createEditForm($category);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'category'    => $category,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
    * Creates a form to edit a Category.
    *
    * @param Category $category The category
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Category $category)
    {
        $form = $this->createForm(new CategoryType(), $category, array(
            'action' => $this->generateUrl('category_update', array('id' => $category->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array(
            'label' => 'Update',
            'attr' => array('class' => 'btn btn-sm btn-success')));

        return $form;
    }
    /**
     * Edits an existing Category.
     *
     * @Route("/{id}", name="category_update")
     * @Method("PUT")
     * @Template("TaskMngBundle:Category:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $category = $em->getRepository('TaskMngBundle:Category')->find($id);

        if (!$category) {
            throw $this->createNotFoundException('Unable to find Category.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($category);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('category_edit', array('id' => $id)));
        }

        return array(
            'category'    => $category,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a Category.
     *
     * @Route("/{id}", name="category_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $category = $em->getRepository('TaskMngBundle:Category')->find($id);

            if (!$category) {
                throw $this->createNotFoundException('Unable to find Category.');
            }

            $em->remove($category);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('category'));
    }

    /**
     * Creates a form to delete a Category by id.
     *
     * @param mixed $id The Category id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('category_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array(
                'label' => 'Delete',
                'attr' => array('class' => 'btn btn-sm btn-danger')))
            ->getForm()
        ;
    }
}
