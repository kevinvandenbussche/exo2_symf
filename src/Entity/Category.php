<?php


namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 *
 */

class Category
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column (type="integer")
     */
    private $id;

    /**
     * @ORM\Column (type="string", length=50)
     */
    private $title;

    /**
     * @ORM\Column (type="text", nullable=true)
     */
    private $description;
    /**
     * @ORM\Column (type="date")
     */
    private $createAt;
    /**
     * @ORM\Column(type="boolean")
     */
    private $IsPlubished;
//je dis a doctrine d'aller chercher l'entity article et avec les cardinalités j'utilise oneToMany (1category peut avoir
//plusieurs article), le mapped by indique a doctrine la propriété de l'entité article qui possede le manyToOne
    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Article", mappedBy="category")
     */
    private $articles;

    public function __construct()
//        je creer un tableau pour ne pas ecraser les données articles
    {
        $this->articles = new ArrayCollection();
    }


    public function getArticles()
    {
        return $this->articles;
    }

    public function setArticles($articles)
    {
        $this->articles = $articles;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id): void
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param mixed $title
     */
    public function setTitle($title): void
    {
        $this->title = $title;
    }

    /**
     * @return mixed
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param mixed $description
     */
    public function setDescription($description): void
    {
        $this->description = $description;
    }

    /**
     * @return mixed
     */
    public function getCreateAt()
    {
        return $this->createAt;
    }

    /**
     * @param mixed $createAt
     */
    public function setCreateAt($createAt): void
    {
        $this->createAt = $createAt;
    }

    /**
     * @return mixed
     */
    public function getIsPlubished()
    {
        return $this->IsPlubished;
    }

    /**
     * @param mixed $IsPlubished
     */
    public function setIsPlubished($IsPlubished): void
    {
        $this->IsPlubished = $IsPlubished;
    }

    /**
     * @return mixed
     */
    public function getArticle()
    {
        return $this->article;
    }

    /**
     * @param mixed $article
     */
    public function setArticle($article): void
    {
        $this->article = $article;
    }


}