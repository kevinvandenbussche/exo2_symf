<?php


namespace App\serviceFiles;

use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\String\Slugger\SluggerInterface;


class UploadFiles
{
        private $slugger;

        private $parameterBag;

        public function __construct(SluggerInterface $slugger, ParameterBagInterface $parameterBag)
        {
            $this->slugger = $slugger;
            $this->parameterBag = $parameterBag;
        }
        public function renameFiles( $imageFile, $category)
        {

            if ($imageFile) {
                //je recupere le nom de mon image
                $originalFilename = pathinfo($imageFile->getClientOriginalName(), PATHINFO_FILENAME);
                //je retire les caractere speciaux qui pourrait etre dans le nom de mon image
                $safeFilename = $this->slugger->slug($originalFilename);
                //je cree un nom unique de mon image
                $newFilename = $safeFilename . '-' . uniqid() . '.' . $imageFile->guessExtension();
                //si le telechargement se deroule correctement je deplace l'image le fichier brochures qui est
                //situé dans public
                try {
                    $imageFile->move(
                        $this->parameterBag->get('brochures_directory'),
                        $newFilename
                    );

                } catch (FileException $e) {
                    //si le telechargment ecoue j'affiche un message a l'utilisateur
                    throw new \Exception("le fichier n'a pas pu être enregistré");
                }

                $category->setImageFilename($newFilename);

            }
        }

}



