<?php


namespace App\Controller\admin;

use App\Entity\Category;
use App\Form\CategoryType;
use App\Repository\CategoryRepository;
use App\serviceFiles\UploadFiles;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\String\Slugger\SluggerInterface;

//je fais heriter mon entité de l'entité abstract controller qui est une entité de symfony
class AdminCategory extends AbstractController
{
    //je creer une annotation qui me permet d'indiquer a symfony ou aller chercher la methode de mon entité et je lui donne un nom
    /**
     * @Route ("admin/display/category", name="display_category")
     *
     */
    //je créer ma methode avec un heritage qui me permet d'aller chercher la bonne table
    public function displayCategory(CategoryRepository $categoryRepository)
    {
        //je fais appel a doctrine pour faire une requete en base de donné qui me prend tout mes donné de ma table
        $category = $categoryRepository->findAll();
        //je retourn le resultat a ma vue
        return $this->render('admin.display.html.twig', [
            //je mets le resultat de ma requete dans un variable twig
            'categories' => $category
        ]);
    }
    //je creer une annotation qui pemet a symfony ou trouver ma méthode et je lui donne un nom
    /**
     * @Route("admin/insert/category", name="insert_category")
     */
    //j'instancie ma méthode avec en parametre des méthode d'abstract controller
    public function insertCategory(Request $request, EntityManagerInterface $entityManager, UploadFiles $uploadedFile)
    {
        //je creer une nouvelle entité que je mets dans une variable
        $category = new Category();
        //je creer un formulaire avec la méthode createForm
        $form = $this->createForm(CategoryType::class, $category);
        //avec la methode handle request je mets mes données dans le champs du formulaire
        $form->handleRequest($request);
        //je verifie que les champs de mon formulaire sont rempli et valide



            // je verifei que mon formulaire soit valide
            if ($form->isSubmitted() && $form->isValid()) {
                $category = $form->getData();

                //je met mes nouvelles données dans une boite
                //je recupere la méthode get de on entity imagefilename et je le met dans une variable
                $imageFile = $form->get('imageFilename')->getData();
                $uploadedFile->renameFiles($imageFile, $category);

                $entityManager->persist($category);
                $entityManager->flush();
                $this->addFlash(
                    'success',
                    'la categorie a été creé'
                );

            // je renvoi l'utilisateur sur mon formulaire
            return $this->redirectToRoute("insert_category");

        }
        return $this->render('admin.category.html.twig', [
            //j'utilise createView pour transfomer l'objet createForm, pour que twig puisse l'afficher et je le met dans une variable twig
            'categoryView' => $form->createView()
        ]);

    }





    /**
     * @Route("admin/update/category/{id}", name="update_category")
     */

    public function updateCategory(Request $request, EntityManagerInterface $entityManager, $id, CategoryRepository $categoryRepository)
    {
        //je fais ma requete avec doctrine qui me permet de recuperer une donnée selon son article
        $category=$categoryRepository->find($id);
        //je creer un formulaire
        $form= $this->createForm(CategoryType::class, $category);
        //le met les donnée dans les bons champs du formulaire
        $form->handleRequest($request);
        //je verifie que les champs de mon formulaire soit valide
        if($form->isSubmitted() && $form->isValid()){
            //je range les données dans la méthode getData et je les relies a l'entité correspondante en base de donnée
            $category = $form->getData();
            //je met les données dans une boite avant l'envoie en base de donnée
            $entityManager->persist($category);
            //j'envoi en bdd
            $entityManager->flush();
            //j affiche un message si l'envoi a été effectué en bdd
            $this->addFlash(
                'success',
                'la categorie a été modifié'
            );


        }
        //je renvoi l'utilisateur sur la page avec le formulaire
        return $this->render('admin.category.html.twig',[
            'categoryView'=>$form->createView()
        ]);
    }

    /**
     * @Route("admin/delete/category/{id}", name="delete_category")
     */
    public function deleteCategory(CategoryRepository $categoryRepository, $id, EntityManagerInterface $entityManager): \Symfony\Component\HttpFoundation\RedirectResponse
    {
        //je recupere mon entité correspondant a mon {id}
        $category=$categoryRepository->find($id);
        //j'utilise la méthode remove qui me permet de supprimé des données
        $entityManager->remove($category);

        //j'envoi en bdd
        $entityManager->flush();
        //j'affiche un message
        $this->addFlash(
            'success',
            'la categorie a été bien supprimé'
        );
        //je renvoie l'utilisateur à la page avec toutes les categories
        return $this->redirectToRoute('display_category');
    }

}