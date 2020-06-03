<?php
declare(strict_types=1);

namespace App\Domain\Book\FileLocation;

use Doctrine\ORM\Mapping as ORM;
/**
 * @ORM\Entity
 * @ORM\InheritanceType("SINGLE_TABLE")
 * @ORM\DiscriminatorColumn(name="discr", type="string")
 * @ORM\DiscriminatorMap({"filesystem" = "Filesystem"})
 * @ORM\Table(name="file_locations")
 */
abstract class FileLocation
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
    private $path;

    public function __construct(string $path)
    {
        $this->path = $path;
    }

    public function path(): String
    {
        return $this->path;
    }
}