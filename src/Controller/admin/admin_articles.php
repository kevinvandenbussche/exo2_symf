<?php


namespace App\Controller\admin;

use App\Entity\Article;
use Doctrine \ ORM \ EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class admin_articles extends AbstractController
{
    /**
     * @Route("/admin/insert/articles", name="insert_article")
     */
    public function insertArticle(EntityManagerInterface $entityManagerInterface)
    {
        $article = new Article();
        $article->setTitle('article');
        $article->setContent('blblablabla');
        $article->setCreateAt( new \DateTime('NOW'));
        $article->setImage('coucou');
        $article->setIsPublished('true');


        $entityManagerInterface->persist($article);
        $entityManagerInterface->flush($article);

        return $this->render('admin.article.html.twig');
    }
}