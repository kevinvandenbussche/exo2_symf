<?php


namespace App\Controller\admin;

use App\Entity\Article;
use Doctrine \ ORM \ EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

//je creer une entité avec pour parent abstract controller
class admin_articles extends AbstractController
{
//    je creer la route et le nom de ma methode
    /**
     * @Route("/admin/insert/articles", name="insert_article")
     */
//    je creer un fonction qui va gerer l'insertion en bdd et j'instancie la methode 'entitymangerInterface' de la
//class abstractController
    public function insertArticle(EntityManagerInterface $entityManagerInterface)
    {
//        je creer une class new Article que je mets dans une variable
        $article = new Article();
//        j'insere le titre
        $article->setTitle('article');
//        j'insere le contenu
        $article->setContent('blblablabla');
//        j'inser la date de creation
        $article->setCreateAt( new \DateTime('NOW'));
//        j'insre un image
        $article->setImage('coucou');
//        j'insere le fait qu'il soit publier ou pas
        $article->setIsPublished('true');

//je dit a doctrine de memorise le nouvelle objet
        $entityManagerInterface->persist($article);
//        doctine envoi l'objet en base de donné
        $entityManagerInterface->flush($article);
//si les donnée sont bien envoyé j'envoi l'utilisateur sur une nouvelle page
        return $this->render('admin.article.html.twig');
    }
}