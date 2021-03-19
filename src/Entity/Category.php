<?php


namespace App\Entity;

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
}