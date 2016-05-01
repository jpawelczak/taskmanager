<?php

namespace TaskMngBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use TaskMngBundle\Entity\Task;
use TaskMngBundle\Form\TaskType;
use \DateTime;

/**
 * Task controller.
 *
 * @Route("/task")
 */
class TaskController extends Controller
{

    /**
     * Lists all Tasks.
     *
     * @Route("/", name="task")
     * @Method("GET")
     * @Template()
     */
    public function indexAction(Request $request)
    {
        $user = $this->getUser();

        $em    = $this->get('doctrine.orm.entity_manager');
        $dql   = "SELECT a FROM TaskMngBundle:Task a WHERE a.user = :user";
        $query = $em->createQuery($dql)->setParameter('user', $user);

        $paginator = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $query, /* query NOT result */
            $request->query->getInt('page', 1)/*page number*/,
            10/*limit per page*/
        );

        // parameters to template
        return $this->render('TaskMngBundle:Task:index.html.twig', array('pagination' => $pagination));

    }

    /**
     * Displays a form to create a new Task.
     *
     * @Route("/new", name="task_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $newTask = new Task();
        $newTask->setDeadline(new DateTime());
        $form   = $this->createCreateForm($newTask);

        return array(
            'task' => $newTask,
            'form'   => $form->createView(),
        );
    }

    /**
     * Creates a new Task.
     *
     * @Route("/", name="task_create")
     * @Method("POST")
     * @Template("TaskMngBundle:Task:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $newTask = new Task();

        $form = $this->createCreateForm($newTask);

        $form->handleRequest($request);

        //adding User details to the Task
        $newTask->setUser($this->getUser());

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($newTask);
            $em->flush();

            return $this->redirect($this->generateUrl('task_show', array('id' => $newTask->getId())));
        }

        return array(
            'task' => $newTask,
            'form'   => $form->createView(),
        );
    }

    /**
     * Creates a form to create a Task .
     *
     * @param Task $newtask The task
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Task $newTask)
    {
        $form = $this->createForm(new TaskType(), $newTask, array(
            'action' => $this->generateUrl('task_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array(
            'label' => 'Create',
            'attr' => array('class' => 'btn btn-sm btn-success')));

        return $form;
    }

    /**
     * Finds and displays a Task.
     *
     * @Route("/{id}", name="task_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $task = $em->getRepository('TaskMngBundle:Task')->find($id);

        if (!$task) {
            throw $this->createNotFoundException('Unable to find the Task.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'task'      => $task,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Task.
     *
     * @Route("/{id}/resolved", name="task_resolved")
     * @Method("GET")
     * @Template("TaskMngBundle:Task:edit.html.twig")
     */
    public function resolvedAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $task = $em->getRepository('TaskMngBundle:Task')->find($id);

        //setting up as markedResolved with 'today' date
        $task->setMarkedResolved(true);
        //$entity->setResolvedDate(new DateTime());

        if (!$task) {
            throw $this->createNotFoundException('Unable to find the Task.');
        }

        $editForm = $this->createEditForm($task);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'task'      => $task,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Task.
     *
     * @Route("/{id}/edit", name="task_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $task = $em->getRepository('TaskMngBundle:Task')->find($id);

        //throwing 404 if entering directly /edit for the resolved Task
        if($task->getMarkedResolved() == true){
            throw $this->createNotFoundException('Unable to find the Task.');
        }

        if (!$task) {
            throw $this->createNotFoundException('Unable to find the Task.');
        }

        $editForm = $this->createEditForm($task);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'task'      => $task,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
    * Creates a form to edit a Task .
    *
    * @param Task $task The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Task $task)
    {
        $form = $this->createForm(new TaskType(), $task, array(
            'action' => $this->generateUrl('task_update', array('id' => $task->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array(
            'label' => 'Update',
            'attr' => array('class' => 'btn btn-sm btn-success')));

        return $form;
    }

    /**
     * Edits an existing Task.
     *
     * @Route("/{id}", name="task_update")
     * @Method("PUT")
     * @Template("TaskMngBundle:Task:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $task = $em->getRepository('TaskMngBundle:Task')->find($id);

        if (!$task) {
            throw $this->createNotFoundException('Unable to find the Task.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($task);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('task_show', array('id' => $id)));
        }

        return array(
            'task'      => $task,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Deletes a Task.
     *
     * @Route("/{id}", name="task_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $task = $em->getRepository('TaskMngBundle:Task')->find($id);

            if (!$task) {
                throw $this->createNotFoundException('Unable to find the Task.');
            }

            $em->remove($task);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('task'));
    }

    /**
     * Creates a form to delete a Task by id.
     *
     * @param mixed $id The Task id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('task_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array(
                'label' => 'Delete',
                'attr' => array('class' => 'btn btn-sm btn-danger')))
            ->getForm()
        ;
    }
}
