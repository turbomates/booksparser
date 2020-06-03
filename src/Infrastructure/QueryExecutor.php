<?php


namespace App\Infrastructure;

use Doctrine\ORM\EntityManagerInterface;

final class QueryExecutor
{
    private $em;
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function execute(Query $query) {
        return $this->em->transactional(
            function ($em) use ($query) {
             return $query->get($em);
        }
        );
    }
}