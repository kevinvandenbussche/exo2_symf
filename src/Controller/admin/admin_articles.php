<?php


namespace App\Controller\admin;

use App\Entity\Article;
use App\Repository\ArticleRepository;
use Doctrine\ORM\EntityManager;
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
//je cree une nouvelle route et un nm pour ma fonction
    /**
     * @Route ("admin/update/articles/{id}", name="update_article")
     */
//    je fait heriter a ma fonction des methodes des class articlerepository et entitymanager que j'instencie dans des variables
//j'utilise une wild card qui me permet d'utiliser la donnée qui est dans l'URL (id de ma donnée)
    public function updateArticle(ArticleRepository $articleRepository, EntityManagerInterface $entityManager, $id)
    {
//je met dans une variable ma requete de doctrine, j'utilise la méthode find
        $article= $articleRepository->find($id);
//je modifie que le champs content de ma donné
        $article->setContent('nouveau text');
//je pres sauvegarde ma donnée(mais cela n'est pas necessaire car elle deja passé par doctrine lors du find
        $entityManager->persist($article);
//j'envoi ma donnée modifié
        $entityManager->flush($article);
//je renvoie mon utilisateur vers une page
        return $this->render('admin.article.update.html.twig',[
            'article'=>$article
        ]);
    }
}