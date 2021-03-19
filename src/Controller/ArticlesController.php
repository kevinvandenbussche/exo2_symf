<?php

//je dit a symphony ou recuperer le controller
namespace App\Controller;
//je recupere le chemin des fonctions implementer dans symfony
use App\Repository\ArticleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

//je creer la class article controller qui herite lui mm de la classe abstractController qui est par default dans symfony
class ArticlesController extends AbstractController
{
    /**
     * @Route ("/", name="index")
     */
    public function Index(ArticleRepository $articleRepository)
    {
        $articles = $articleRepository->findBy(
            ['isPublished' => 1],
            ['createAt' => 'DESC'],2
        );



        return $this->render('index.html.twig', ['articles' => $articles]);

    }
//    je creer une route et un nom pour ma fonction
    /**
     * @Route("/articles", name="display_articles")
     */
//je creer une methode qui va traiter mes données
    public function DisplayArticles(ArticleRepository $articleRepository)
    {
        $articles = $articleRepository->findall();
        // methode render ( d'abstract controller ) renvoi un ma vue ( défini en premiere argument )
        // les variable que je lui passe dans le tableau en deuxieme argument
        return $this->render('articles.html.twig',[
            'articles' => $articles
        ]);

    }
//        je creer une route avec /article et lui donne le nom display_article et j'utilise une wild card pour
//        recuperer les id de ma base de donné
    /**
     * @Route("/article/{id}", name="display_article")
     */
    public function DisplayArticle(ArticleRepository $articleRepository, $id)
    {

        $articles = $articleRepository->find($id);

        return $this->render('article.html.twig',['article' => $articles]);

    }
}