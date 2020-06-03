<?php
declare(strict_types=1);

namespace App\Application\Statistic;

use App\Domain\Book\Book;
use App\Infrastructure\Query;
use Doctrine\ORM\EntityManagerInterface;

class CountByAuthorQuery implements Query
{
    public function get(EntityManagerInterface $em) {
        return $em->createQueryBuilder()
            ->select(["count(books.id) as count", "authors.name as author"])
            ->from(Book::class, "books")
            ->innerJoin("books.author", "authors")
            ->groupBy("authors.id")
            ->getQuery()
            ->getArrayResult();
    }
}