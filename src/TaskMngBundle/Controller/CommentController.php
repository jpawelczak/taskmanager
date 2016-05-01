<?php

namespace TaskMngBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Response;
use TaskMngBundle\Entity\Comment;
use TaskMngBundle\Form\CommentType;

/**
 * Comment controller.
 *
 * @Route("/comment")
 */
class CommentController extends Controller
{

    /**
     * Lists all Comments.
     *
     * @Route("/", name="comment")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $comments = $em->getRepository('TaskMngBundle:Comment')->findAll();

        return array(
            'comments' => $comments,
        );
    }

    /**
     * Displays a form to create a new Comment.
     *
     * @Route("/new/{id}", name="comment_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction($id)
    {
        $task = $this->getDoctrine()->getRepository('TaskMngBundle:Task')->find($id);

        $newComment = new Comment();
        $form = $this->createForm(new CommentType(), $newComment, array(
            'action' => $this->generateUrl('comment_create', ['id' => $task->getId()]),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array(
            'label' => 'Create',
            'attr' => array('class' => 'btn btn-sm btn-success')));

        return array(
            'comment' => $newComment,
            'task' => $task,
            'form'   => $form->createView(),
        );
    }

    /**
     * Creates a new Comment.
     *
     * @Route("/{id}", name="comment_create")
     * @Method("POST")
     * @Template("TaskMngBundle:Comment:new.html.twig")
     */
    public function createAction(Request $request, $id)
    {
        //load Task with $id
        $task = $this->getDoctrine()->getRepository('TaskMngBundle:Task')->find($id);

        $user = $this->getUser();

        $newComment = new Comment();
        $form = $this->createForm(new CommentType(), $newComment, array(
            'action' => '',
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array(
            'label' => 'Create',
            'attr' => array('class' => 'btn btn-sm btn-success')));

        //adding Task details to Comment
        $newComment->setTask($task);

        //adding User details to Comment
        $newComment->setUser($user);

        //add Comment to Task
        $task->addComment($newComment);

        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($newComment);
            $em->flush();

            return $this->redirect($this->generateUrl('task_show', ['id' => $task->getId()]));
        }

        return array(
            'comment' => $newComment,
            'user'   => $user,
            'form'   => $form->createView(),
        );
    }

    /**
     * Creates a form to create a Comment.
     *
     * @param Comment $newComment The comment
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Comment $newComment)
    {
        $form = $this->createForm(new CommentType(), $newComment, array(
            'action' => $this->generateUrl('comment_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array(
            'label' => 'Create',
            'attr' => array('class' => 'btn btn-sm btn-success')));

        return $form;
    }

    /**
     * Finds and displays a Comment.
     *
     * @Route("/{id}", name="comment_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $comment = $em->getRepository('TaskMngBundle:Comment')->find($id);

        if (!$comment) {
            throw $this->createNotFoundException('Unable to find Comment.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'comment'      => $comment,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Comment.
     *
     * @Route("/{id}/edit", name="comment_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $comment = $em->getRepository('TaskMngBundle:Comment')->find($id);

        if (!$comment) {
            throw $this->createNotFoundException('Unable to find Comment.');
        }

        $editForm = $this->createEditForm($comment);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'comment'      => $comment,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
    * Creates a form to edit a Comment.
    *
    * @param Comment $comment The comment
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Comment $comment)
    {
        $form = $this->createForm(new CommentType(), $comment, array(
            'action' => $this->generateUrl('comment_update', array('id' => $comment->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array(
            'label' => 'Create',
            'attr' => array('class' => 'btn btn-sm btn-success')));

        return $form;
    }

    /**
     * Edits an existing Comment.
     *
     * @Route("/{id}", name="comment_update")
     * @Method("PUT")
     * @Template("TaskMngBundle:Comment:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $comment = $em->getRepository('TaskMngBundle:Comment')->find($id);

        if (!$comment) {
            throw $this->createNotFoundException('Unable to find Comment.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($comment);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('comment_edit', array('id' => $id)));
        }

        return array(
            'comment'      => $comment,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Deletes a Comment.
     *
     * @Route("/{id}", name="comment_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $comment = $em->getRepository('TaskMngBundle:Comment')->find($id);

            if (!$comment) {
                throw $this->createNotFoundException('Unable to find the Comment.');
            }

            $em->remove($comment);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('task'));
    }

    /**
     * Creates a form to delete a Comment by id.
     *
     * @param mixed $id The Comment id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('comment_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array(
                'label' => 'Delete',
                'attr' => array('class' => 'btn btn-sm btn-danger')))
            ->getForm()
        ;
    }
}
