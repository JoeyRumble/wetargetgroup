<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Validation;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class ContactController extends AbstractController
{
    private $httpClient;

    public function __construct(HttpClientInterface $httpClient)
    {
        $this->httpClient = $httpClient;
    }

    #[Route('/contact/submit', name: 'contact_form_submit', methods: ['POST'])]
    public function submit(Request $request): Response
    {
        $data = [
            'name' => $request->request->get('name'),
            'telephone' => $request->request->get('telephone'),
            'email' => $request->request->get('email'),
            'comment' => $request->request->get('comment'),
            'g-recaptcha-response' => $request->request->get('g-recaptcha-response'),
        ];

        $validator = Validation::createValidator();
        $violations = $validator->validate($data['name'], [new Assert\NotBlank()]);
        $violations->addAll($validator->validate($data['telephone'], [new Assert\NotBlank()]));
        $violations->addAll($validator->validate($data['email'], [new Assert\NotBlank(), new Assert\Email()]));

        $isProd = $this->getParameter('kernel.environment') === 'prod';
        // Validate reCAPTCHA only in production
        if ($isProd) {
            $recaptchaSecret = $_ENV['GOOGLE_RECAPTCHA_PRIVATE_KEY'] ?? getenv('GOOGLE_RECAPTCHA_PRIVATE_KEY');
            $recaptchaResponse = $data['g-recaptcha-response'];
            if (!$recaptchaResponse) {
                $violations->add(new \Symfony\Component\Validator\ConstraintViolation('reCAPTCHA validatie is verplicht.', '', [], '', 'g-recaptcha-response', null));
            } else {
                $response = $this->httpClient->request('POST', 'https://www.google.com/recaptcha/api/siteverify', [
                    'body' => [
                        'secret' => $recaptchaSecret,
                        'response' => $recaptchaResponse,
                        'remoteip' => $request->getClientIp(),
                    ],
                ]);
                $result = $response->toArray(false);
                if (empty($result['success'])) {
                    $violations->add(new \Symfony\Component\Validator\ConstraintViolation('reCAPTCHA validatie is mislukt.', '', [], '', 'g-recaptcha-response', null));
                }
            }
        }

        if (count($violations) > 0) {
            foreach ($violations as $violation) {
                $this->addFlash('error', $violation->getMessage());
            }
            return $this->redirectToRoute('contact');
        }

        // Use SendGrid package
        $sendgridApiKey = $_ENV['SENDGRID_API_KEY'] ?? getenv('SENDGRID_API_KEY');
        $to = 'info@wetarget.nl';
        $subject = 'Nieuw contactformulier ontvangen';
        $body = "Je hebt een nieuw bericht ontvangen via het contactformulier:\n\n" .
            "Naam: {$data['name']}\n" .
            "Telefoonnummer: {$data['telephone']}\n" .
            "E-mailadres: {$data['email']}\n" .
            "Opmerking: {$data['comment']}\n";

        try {
            $email = new \SendGrid\Mail\Mail();
            $email->setFrom('noreply@wetarget.nl', 'WeTarget Contact');
            $email->setReplyTo($data['email'], $data['name']);
            $email->setSubject($subject);
            $email->addTo($to);
            $email->addContent('text/plain', $body);

            $sendgrid = new \SendGrid($sendgridApiKey);
            $response = $sendgrid->send($email);

            if ($response->statusCode() === 202) {
                $this->addFlash('success', 'Bedankt voor je bericht! We nemen zo snel mogelijk contact met je op.');
            } else {
                $this->addFlash('error', 'Er is iets misgegaan met het verzenden van het formulier. Probeer het later opnieuw.');
            }
        } catch (\Exception $e) {
            dd($e->getMessage());
            $this->addFlash('error', 'Er is iets misgegaan met het verzenden van het formulier. Probeer het later opnieuw.');
        }

        return $this->redirectToRoute('contact');
    }
}
