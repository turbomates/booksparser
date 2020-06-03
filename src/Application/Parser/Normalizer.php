<?php


namespace App\Application\Parser;


use App\Domain\Book\Author;
use App\Domain\Book\Language;
use Doctrine\ORM\EntityManagerInterface;

final class Normalizer
{
    private $em;
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function normalize(ParsedBookAttributes $attributes): NormalizedBookAttributes {

        return new NormalizedBookAttributes(
            $this->normalizeAuthor($attributes),
            $attributes->title,
            $this->normalizeLanguage($attributes)
        );
    }

    public function normalizeAuthor(ParsedBookAttributes $attributes): Author
    {
        $author = $this->em
            ->getRepository(Author::class)
            ->findOneBy(["unifiedName" => Author::unifyName($attributes->author)]);
        if ($author === null) {
            $author = new Author($attributes->author);
            $this->em->persist($author);
        }

        return $author;
    }

    public function normalizeLanguage(ParsedBookAttributes $attributes): Language
    {
        $code = $attributes->language;
        $language = $this->em
            ->getRepository(Language::class)
            ->findOneBy(["code" => $code]);
        if ($language === null) {
            $language = new Language($code);
            $this->em->persist($language);
        }

        return $language;
    }
}