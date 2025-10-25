<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\File\Exception\FileNotFoundException;
use Symfony\Component\Routing\Annotation\Route;

class EmailSignatureGifController
{
    #[Route('/assets/logos/email-signature.gif', name: 'email_signature_gif', methods: ['GET'])]
    public function __invoke(): Response
    {
        $projectDir = \dirname(__DIR__, 2); // goes to src/ then project root
        $filePath = $projectDir . '/public/images/logo/email-signature.gif';

        if (!is_file($filePath)) {
            throw new FileNotFoundException("Email signature GIF not found at $filePath");
        }

        $response = new BinaryFileResponse($filePath);
        $response->headers->set('Content-Type', 'image/gif');
        // Cache for 1 day; adjust as needed
        $response->setPublic();
        $response->setMaxAge(86400);
        $response->setSharedMaxAge(86400);

        return $response;
    }
}
