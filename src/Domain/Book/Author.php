<?php
declare(strict_types=1);

namespace App\Domain\Book;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="authors", indexes={@ORM\Index(name="author_idx", columns={"unified_name"})})
 */
class Author
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;
    /**
     * @ORM\Column(type="string", length=255, unique=true)
     */
    private $name;
    /**
     * @ORM\Column(type="string", name="unified_name", length=255, unique=true)
     */
    private $unifiedName;

    public function __construct(string $name)
    {
        $this->name = $name;
        $this->unifiedName = self::unifyName($this->name);
    }

    public static function unifyName(string $name) {
        return strtolower(str_replace(" ", "", $name));
    }
}