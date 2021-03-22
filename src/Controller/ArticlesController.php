<?php

//je dit a symphony ou recuperer le controller
namespace App\Controller;
//je recupere le chemin des fonctions implementer dans symfony
use App\Repository\ArticleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

//je creer la class article controller qui herite lui mm de la classe abstractController qui est par default dans symfony
class ArticlesController extends AbstractController
{
//    je donne un nom et une route a ma fonction avec l'annotation @Route
    /**
     * @Route ("/", name="index")
     */
//    ma fonction public  en parametre la metode articleRepository crée par doctrine
    public function Index(ArticleRepository $articleRepository)
    {
//        je creer une requete SQL avec la metode findBY et je mes ma requetes dans une vacriable article
        $articles = $articleRepository->findBy(
//            j'affiche que les article avec 1 dans mon champ published
            ['isPublished' => 1],
//            je trie mes articles par date de creation du recent au plus ancien
            ['createAt' => 'DESC'],2
        );


//      je renvoi a ma vue mes données traiter avec la methode render qui sont dans ma variable. je la renome
//        article dans twig
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
//    je met en parametre la foncion articleRepository qui est dans doctrine
    public function DisplayArticle(ArticleRepository $articleRepository, $id)
    {
//je fais ma requete en base de donné avec find qui recupere les article trié par ID
        $articles = $articleRepository->find($id);
//methode render renvoi a ma vue les varibles que je lui mets dans un tableau
        return $this->render('article.html.twig',['article' => $articles]);

    }


    /**
     * @Route ("/search", name="search_articles")
     */
    public function Search(Request $request, ArticleRepository $articleRepository)
    {
//        je recupere les données du parametre get
        $search = $request->query->get('search');
//      je met les données du parametres get dans ma methode 'findSearch' pour les traiter avec la base de donné
        $articles = $articleRepository->findSearch($search);
//        une fois les données traité je les renvoie a ma vue
        return $this->render('articles.html.twig',
            ['articles' => $articles]
        );

    }

}

