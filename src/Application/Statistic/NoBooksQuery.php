<?php
declare(strict_types=1);

namespace App\Application\Statistic\Query;

use App\Application\Statistic\DTO\NoBooks;
use App\Domain\Book\Author;
use App\Domain\Book\Book;
use App\Infrastructure\Query;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Query\Expr\Join;

class NoBooksQuery implements Query
{
    public function get(EntityManagerInterface $em) {
        return $em->createQueryBuilder()
            ->select("authors.name")
            ->from(Author::class, "authors")
            ->leftJoin(Book::class, "books", Join::WITH, "authors.id=books.author")
            ->where("books.id is null")
            ->getQuery()
            ->getArrayResult();
    }
}