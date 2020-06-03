<?php

namespace App\Application;

use App\Infrastructure\Parser\EpubParser;
use App\Infrastructure\Parser\Fb2Parser;
use App\Infrastructure\File;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\Validator\Constraints as Assert;

final class Validator
{
    private const MAXSIZE = '30M';

    private $validator;
    public function __construct(ValidatorInterface $validator)
    {
        $this->validator = $validator;
    }

    public function validate(File $uploadedFile) {
        return $this->validator->validate(
            $uploadedFile,
            [
                new Assert\File([
                    'maxSize' => self::MAXSIZE,
                    'mimeTypes' => array_intersect(
                        EpubParser::supportedMimeTypes(),
                        Fb2Parser::supportedMimeTypes()
                    )
                ])
            ]
        );
    }
}