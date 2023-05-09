<?php

namespace App\Controller;

use App\Entity\Tache;
use App\Form\TacheType;
use App\Repository\TacheRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/tache')]
class TacheController extends AbstractController
{
    #[Route('/', name: 'app_tache_index', methods: ['GET'])]
    public function index(TacheRepository $tacheRepository): Response
    {
        return $this->render('pages/tache/index.html.twig', [
            'taches' => $tacheRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_tache_new', methods: ['GET', 'POST'])]
    public function new(Request $request, TacheRepository $tacheRepository): Response
{
    $tache = new Tache();
    $form = $this->createForm(TacheType::class, $tache);
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
        // Set the user to the task
        $tache->setUser($this->getUser());

        // Save the task to the database
        $tacheRepository->save($tache, true);

        return $this->redirectToRoute('app_tache_index', [], Response::HTTP_SEE_OTHER);
    }

    return $this->renderForm('pages/tache/new.html.twig', [
        'tache' => $tache,
        'form' => $form,
    ]);
}

    // #[Route('/{id}', name: 'app_tache_show', methods: ['GET'])]
    // public function show(Tache $tache): Response
    // {
    //     return $this->render('pages/tache/show.html.twig', [
    //         'tache' => $tache,
    //     ]);
    // }

    #[Route('/{id}/edit', name: 'app_tache_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Tache $tache, TacheRepository $tacheRepository): Response
    {
        $form = $this->createForm(TacheType::class, $tache);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $tacheRepository->save($tache, true);

            return $this->redirectToRoute('app_tache_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('pages/tache/edit.html.twig', [
            'tache' => $tache,
            'form' => $form,
        ]);
    }

   

    #[Route('/article/suppression/{id}', 'app_tache_delete' , methods:['GET'])]
    public function delete(EntityManagerInterface $manager,Tache $tache) : Response
    {
        // if(!$tache){
        //     $this->addFlash(
        //         'success',
        //         'L\'article en question n\'a pas été trouvé !'
        //     );
        // }

        $manager->remove($tache);
        $manager->flush();

        // $this->addFlash(
        //     'success',
        //     'Votre article a été supprimé avec succès'
        // );

        return $this->redirectToRoute('app_tache_index');
    }

    
}
