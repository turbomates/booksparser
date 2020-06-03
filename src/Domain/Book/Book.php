<?php
declare(strict_types=1);

namespace App\Domain\Book;

use App\Domain\Book\FileLocation\FileLocation;
use Doctrine\ORM\Mapping as ORM;
/**
 * @ORM\Entity
 * @ORM\Table(name="books")
 */
class Book
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;
    /**
     * @ORM\Column(type="string", length=255)
     */
    private $title;
    /**
     * @ORM\ManyToOne(targetEntity="Author")
     * @ORM\JoinColumn(name="author", referencedColumnName="id")
     */
    private $author;
    /**
     * @ORM\ManyToOne(targetEntity="Language")
     * @ORM\JoinColumn(name="language", referencedColumnName="id")
     */
    private $language;
    /**
     * @ORM\OneToOne(targetEntity="App\Domain\Book\FileLocation\FileLocation")
     * @ORM\JoinColumn(name="location", referencedColumnName="id")
     */
    private $location;
    /**
     * @ORM\Column(type="datetime")
     */
    private $uploadedAt;

    private function __construct(string $title, Author $author, Language $language, FileLocation $location) {
        $this->title = $title;
        $this->author = $author;
        $this->language = $language;
        $this->location = $location;
        $this->uploadedAt = new \DateTime();
    }

    public static function upload(string $title, Author $author, Language $language, FileLocation $location): Book {
        return new Book($title, $author, $language, $location);
    }

    public function download(): FileLocation {
        return $this->location;
    }
}