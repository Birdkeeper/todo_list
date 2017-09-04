<?php

namespace TestTask\TodoListBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use TestTask\TodoListBundle\Form\ListsType;
use TestTask\TodoListBundle\Entity\Lists;
use TestTask\TodoListBundle\Entity\Tasks;

class TodoListController extends Controller
{
    /**
     * @param Request $request
     * @return Response
     */
    public function showAction(Request $request)
    {
        $list = new Lists();
        $form = $this->createForm(ListsType::class, $list);

        $em = $this->getDoctrine()
            ->getManager();
        $lists = $em->getRepository('TestTaskTodoListBundle:Lists')
            ->getPublicLists();

        if ($request->isMethod($request::METHOD_POST)) {
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $em->getRepository('TestTaskTodoListBundle:Lists')
                    ->createList($list);
                return $this->redirect($this->generateUrl('test_task_todo_list_homepage', [
                    'lists' => $lists,
                ]));
            }
        }

        return $this->render('TestTaskTodoListBundle::layout.html.twig', [
            'lists' => $lists,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @return Response
     */
    public function showArchiveAction()
    {
        $em = $this->getDoctrine()
            ->getManager();

        $lists = $em->getRepository('TestTaskTodoListBundle:Lists')
            ->getArchiveLists();

        return $this->render('TestTaskTodoListBundle:Page:archive.html.twig', [
            'lists' => $lists,
        ]);
    }

    /**
     * @param $list_id
     * @return RedirectResponse
     */
    public function deleteListAction($list_id)
    {
        $em = $this->getDoctrine()
            ->getManager();

        $list = $em->getRepository('TestTaskTodoListBundle:Lists')
            ->find($list_id);
        $em->getRepository('TestTaskTodoListBundle:Lists')
            ->deleteList($list);

        return $this->redirect($this->generateUrl('test_task_todo_list_homepage'));

    }

    /**
     * @param $list_id
     * @return RedirectResponse
     */
    public function reestablishListAction($list_id)
    {
        $em = $this->getDoctrine()
            ->getManager();

        $list = $em->getRepository('TestTaskTodoListBundle:Lists')
            ->find($list_id);
        $em->getRepository('TestTaskTodoListBundle:Lists')
            ->reestablishList($list);

        return $this->redirect($this->generateUrl('test_task_todo_list_archive'));
    }

    /**
     * @param $task_id
     * @return RedirectResponse
     */
    public function deleteTaskAction($task_id){
        $em = $this->getDoctrine()
            ->getManager();

        $task = $em->getRepository('TestTaskTodoListBundle:Tasks')
            ->find($task_id);
        /** @var Tasks $task */
        $task->setIsDone(true);
        $em->getRepository('TestTaskTodoListBundle:Tasks')
            ->saveTask($task);

        return $this->redirect($this->generateUrl('test_task_todo_list_homepage'));
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function addTaskAction(Request $request)
    {
        $list_id = $request->get('list_id');
        $content = $request->get('content');
        $em = $this->getDoctrine()
            ->getManager();

        $list = $em->getRepository('TestTaskTodoListBundle:Lists')
            ->find($list_id);

        $task = new Tasks();
        $task->setList($list);
        $task->setContent($content);
        $em->getRepository('TestTaskTodoListBundle:Tasks')
            ->saveTask($task);

        return new JsonResponse(['status' => 'ok']);
    }
}