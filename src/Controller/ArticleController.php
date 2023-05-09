<?php

namespace App\Controller;

use App\Entity\Article;
use App\Form\ArticleType;
use App\Repository\ArticleRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

class ArticleController extends AbstractController
{
    /**
     * Cette fonction sert à afficher tous les articles
     *
     * @param ArticleRepository $repository
     * @param PaginatorInterface $paginator
     * @param Request $request
     * @return Response
     * 
     * 
     */
    #[Route('/article', name: 'article.index', methods:['GET'])]
    public function index(ArticleRepository $repository, PaginatorInterface $paginator, Request $request): Response
    {
        $articles = $paginator->paginate(
            $repository->findAll(), 
            $request->query->getInt('page', 1),
            3 
        );

        return $this->render('pages/article/index.html.twig', [
            'articles' => $articles
        ]);
    }

    #[Route('/article/nouveau','article.new',methods: ['GET','POST'])]
    #[IsGranted('ROLE_ADMIN')]
    public function new(
        Request $request,
        EntityManagerInterface $manager
        ) : Response
    {
        $article = new Article;
        $form = $this->createForm(ArticleType::class, $article);

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $article = $form->getData();
            $article->setUser($this->getUser());

            $manager->persist($article);
            $manager->flush();

            $this->addFlash(
                'success',
                'Votre article a été créé avec succès'
            );

            return $this->redirectToRoute('article.index');
        }

        return $this-> render('pages/article/new.html.twig',[
            'form' => $form->createView()
        ]);
    }

    #[Route('/article/edition/{id}','article.edit', methods : ['GET','POST'])]
    public function edit(
         Article $article,
         Request $request,
         EntityManagerInterface $manager
         ) :Response
    {
        $form = $this->createForm(ArticleType::class, $article);

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $article = $form->getData();

            $manager->persist($article);
            $manager->flush();

            $this->addFlash(
                'success',
                'Votre article a été modifié avec succès'
            );
            return $this->redirectToRoute('article.index');
        }

        return $this->render('pages/article/edit.html.twig',[
            'form' =>$form->createView()
        ]);
    }

    #[Route('/article/suppression/{id}', 'article.delete' , methods:['GET'])]
    public function delete(EntityManagerInterface $manager,Article $article) : Response
    {
        if(!$article){
            $this->addFlash(
                'success',
                'L\'article en question n\'a pas été trouvé !'
            );
        }

        $manager->remove($article);
        $manager->flush();

        $this->addFlash(
            'success',
            'Votre article a été supprimé avec succès'
        );

        return $this->redirectToRoute('article.index');
    }

   
    #[Route('/show/{id}', name: 'app_article_show', methods: ['GET'])]
    public function show(Article $article): Response
    {
        return $this->render('pages/article/show.html.twig', [
            'article' => $article,
        ]);
    }
}
