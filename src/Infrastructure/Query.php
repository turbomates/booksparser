<?php


namespace App\Infrastructure;

use Doctrine\ORM\EntityManagerInterface;

interface Query
{
    public function get(EntityManagerInterface $em);
}