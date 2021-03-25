<?php


namespace App\Controller\admin;

use App\Entity\Article;
use App\Form\ArticleType;
use App\Repository\ArticleRepository;
use Doctrine \ ORM \ EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

//je creer une entité avec pour parent abstract controller
class admin_articles extends AbstractController
{
//    je creer la route et le nom de ma methode
    /**
     * @Route("/admin/insert/article", name="insert_article")
     */
//    je creer un fonction qui va gerer l'insertion en bdd et j'instancie la methode 'entitymangerInterface' de la
//class abstractController
    public function insertArticle(EntityManagerInterface $entityManagerInterface, Request $request)
    {
//         je creer un nouvel objet article
        $article = new Article();
//  j'utilise la méthode createFrom je met le name space de class auquel je rajoute en parametre la class objet
        $form = $this->createForm(ArticleType::class, $article);
//je recupere le POST de mon formulaire
        $form->handleRequest($request);
//      symfony verifie si les champs de mon form correspond au champ de ma bdd
        if($form->isSubmitted() && $form->isValid()){
//            getData recupere les donnée du form
            $article = $form->getData();
//            persist mets toute mes données dans une boite
            $entityManagerInterface->persist($article);
//            j'envoi les données en bdd
            $entityManagerInterface->flush();

        }

//je renvoi le tout a la vue
        return $this->render('admin.article.html.twig',[
//            je transfrome mon objet form avec la methode createView
            'articleView'=>$form->createView()
        ]);


    }
//je cree une nouvelle route et un nm pour ma fonction
    /**
     * @Route ("admin/update/article/{id}", name="update_article")
     */
//    je fait heriter a ma fonction des methodes des class articlerepository et entitymanager que j'instencie dans des variables
//j'utilise une wild card qui me permet d'utiliser la donnée qui est dans l'URL (id de ma donnée)
    public function updateArticle(ArticleRepository $articleRepository, EntityManagerInterface $entityManager, $id, Request $request)
    {
//je met dans une variable ma requete de doctrine, j'utilise la méthode find
        $article = $articleRepository->find($id);

        //  j'utilise la méthode createFrom je met le name space de class auquel je rajoute en parametre la class objet
        $form = $this->createForm(ArticleType::class, $article);
        //      je recupere le POST de mon formulaire
        $form->handleRequest($request);
//      symfony verifie si les champs de mon form correspond au champ de ma bdd
        if($form->isSubmitted() && $form->isValid()){
//            getData recupere les donnée du form
            $article = $form->getData();
//            persist mets toute mes données dans une boite
            $entityManager->persist($article);
//            j'envoi les données en bdd
            $entityManager->flush();

        }
        //je renvoi le tout a la vue
        return $this->render('admin.article.html.twig',[
        //            je transfrome mon objet form avec la methode createView
        'articleView'=>$form->createView()
        ]);
    }
//    je creer une route et je donne un nom a ma methode et je rajoute une wild card pour pouvoir recupere en get
        /**
         * @Route("/admin/delete/article/{id}", name="delete_article")
         */
//        je fais heriter a ma methode, 'articleRepository' et 'entityManagerInterface' et je lai fait instancier par symfony
//    autowire
    public function deleteArticle($id,ArticleRepository $articleRepository, EntityManagerInterface $entityManager)
    {
//        je recupere ma data par l'id que j'ai en url et je le met dans une variable
       $article=$articleRepository->find($id);
//jutilise une d'entity manager qui me permet de supprimer une data
       $entityManager->remove($article);
//       jenvoi ma requete en base de donné
       $entityManager->flush();
//j'utilise une methode qui me permet d'afficher un message
        $this->addFlash(
            'success',
            'L\'article a été supprimé'
        );

        return $this->redirectToRoute("display_articles");
    }

//je creer une route et je donne un nom a ma methode
    /**
     * @Route ("admin/display/articles", name="display_articles")
     */
//    ma fonction herite de la methode articlerepository que j'instancie et que je mets dans une variable
    public function displayArticle(ArticleRepository $articleRepository)
    {
//je creer une requete symfony qui me prend toute les data de ma bdd
        $articles=$articleRepository->findAll();
//je renvoie a la vue avec un fichier twig toutes mes data
        return $this->render('admin.display.html.twig',[
            'articles'=>$articles
            ]);
    }



}