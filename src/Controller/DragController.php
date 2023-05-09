<?php

namespace App\Controller;

use App\Repository\TacheRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class DragController extends AbstractController
{
    #[Route('/drag', name: 'app_drag', methods: ['POST', 'GET'])]
    public function index(Request $request, TacheRepository $tr): JsonResponse
    {
        //je recupere l'id de la tache
        $id = $request->get('tacheId');
        $statut = $request->get('statut');

        // je recupere la tache associé à l'id 
        $task = $tr->find($id);

        //je modifie ma tache
        $task->setTacheStatut($statut);
        
        //j'enregistre les modif
        $tr->save($task, true);
        
        return new JsonResponse(['data' => 'ok']);
    }
}
