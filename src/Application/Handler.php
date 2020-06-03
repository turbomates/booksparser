<?php
declare(strict_types=1);

namespace App\Application;

use App\Application\Parser\Normalizer;
use App\Application\Parser\Parser;
use App\Domain\Book\Book;
use Doctrine\ORM\EntityManagerInterface;
use App\Infrastructure\File;

final class Handler
{
    private $uploader;
    private $parser;
    private $normalizer;
    private $downloader;
    private $em;

    public function __construct(
        Uploader $uploader,
        Parser $parser,
        Normalizer $normalizer,
        Downloader $downloader,
        EntityManagerInterface $em
    )
    {
        $this->uploader = $uploader;
        $this->parser = $parser;
        $this->normalizer = $normalizer;
        $this->downloader = $downloader;
        $this->em = $em;
    }

    public function upload(File $file): void {
        $location = $this->uploader->upload($file);
        $parsed = $this->parser->parse($file);

        $this->em->transactional(function ($em) use ($parsed, $location){
            $normalized = $this->normalizer->normalize($parsed);
            $em->persist($location);

            $book = Book::upload(
                $normalized->title,
                $normalized->author,
                $normalized->language,
                $location
            );
            $em->persist($book);
            $em->flush();
        });
    }

    public function download(string $title): File {
        $book = $this->em
            ->getRepository(Book::class)
            ->findOneBy(["title" => $title]);
        if ($book === null) {
            throw new \Exception("Book $title not found");
        }

        return $this->downloader->download($book->download());
    }
}