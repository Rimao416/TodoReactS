<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\TodoRepository;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use App\Entity\Todo;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Route("api/todo",name="api_todo")
 */

class TodoController extends AbstractController
{
    private $entityManager;
    private $todoRepository;
    public function __construct(EntityManagerInterface $entityManager,TodoRepository $todoRepository)
    {
        $this->entityManager=$entityManager;
        $this->todoRepository=$todoRepository;
        
    }
    /**
     * @Route("/read", name="todo")
     */
    public function index(): Response
    {
        $todos=$this->todoRepository->findAll();
        $arrayOfTodos=[];
        foreach($todos as $todo){
            $arrayOfTodos[]=$todo->toArray();
        }
        return $this->json($arrayOfTodos);
            
    }
    /**
     * @Route("/update/{id}",name="api_todo_update",methods={"PUT"})
     * @param Request $request
     * @param Todo $todo
     * @return JsonResponse
     */
    public function update(Request $request,Todo $todo){
        $content= json_decode($request->getContent());
        $todo->setName($content->name);
        try{
            $this->entityManager->flush();
        }catch(Exception $exception){
            //error
        }
        return $this->json([
            'message'=>'Todo has been update'
        ]);
    }
    /**
     * @Route("/delete/{id}",name="api_todo_delete",methods={"DELETE"})
     * @param Request $request
     * @param Todo $todo
     * @return void
     */
    public function delete(Todo $todo){
        try{
            $this->entityManager->remove($todo);
            $this->entityManager->flush();
        }catch(Exception $exception){
            //error
        }
        return $this->json([
            'message'=>'Supprimé'
        ]);
    }

    /**
     * @Route("/create",name="api_todo_read",methods={"POST"})
     * @param Request $request
     */
    public function create(Request $request):JsonResponse{
        $content=json_decode($request->getContent());
        $todo=new Todo();
        $todo->setName($content->name);
        try{
            $this->entityManager->persist($todo);
            $this->entityManager->flush();
            return $this->json([
                'todo'=>$todo->toArray()
            ]);
        }catch(Exception $exception){   
            //error
        }
    }
}
