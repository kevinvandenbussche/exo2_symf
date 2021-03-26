<?php


namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\CategoryRepository;

class CategoryController extends AbstractController
{
    /**
     * @Route("/category", name="list_category")
     * @param CategoryRepository $categoryRepository
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function listCategory(CategoryRepository $categoryRepository)
    {
//        j'effectue une requete avec doctrine qui me permet de selectionner toutes les category
//        je mets le resultat de ma requete dans une variable
        $category = $categoryRepository->findAll();
//je renvoie le resultat de la requete dans un fichier twig et je range mes donées dans un tableau
        return $this->render('category.html.twig',[
//            je mets le resultat de ma requete dans une variables twig
            'categories'=>$category
        ]);
    }
}