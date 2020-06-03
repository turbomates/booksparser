<?php
declare(strict_types=1);

namespace App\Application\Statistic\Query;

use App\Domain\Book\Book;
use App\Infrastructure\Query;
use Doctrine\ORM\EntityManagerInterface;

class DayBooksCountQuery implements Query
{
    public function get(EntityManagerInterface $em) {
        return $em->createQueryBuilder()
            ->select(["count(books.id)", "TO_CHAR(books.uploadedAt, 'DD-MM-YYYY') as day"])
            ->from(Book::class, "books")
            ->groupBy("day")
            ->getQuery()
            ->getArrayResult();
    }
}