<?php

namespace App\Repository;

use App\Entity\Article;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Article|null find($id, $lockMode = null, $lockVersion = null)
 * @method Article|null findOneBy(array $criteria, array $orderBy = null)
 * @method Article[]    findAll()
 * @method Article[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ArticleRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Article::class);
    }
//je creer une methode findSearch qui a en parametres $search
    public function findSearch($search)
    {
//        j'utilise la methode createQueryBuilder qui me permet travailler avec la base de donné
//        je le met dans une variables
//        'a' est le nom de ma table
        $queryBuilder = $this->createQueryBuilder('a');
//je creer une requete avec doctrine, une fois ma requete creé et executé je la mets dans une variable
        $query = $queryBuilder
//           je selectionne dans ma table
            ->select('a')
//            je met des condition et je cherche dans mon champ content
            ->where('a.content LIKE :search')
//            setParameter permet de proteger ma base de donné car elle enleve tout les caractere qui pourrait etre
//            dangereux pour la base de donnée
            ->setParameter( 'search', '%'.$search.'%')
//            je recupere la requete
            ->getQuery();

//je renvoi ma requete
        return $query->getresult();
    }
}
