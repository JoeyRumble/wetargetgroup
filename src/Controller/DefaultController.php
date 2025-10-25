<?php

// src/Controller/DefaultController.php

namespace App\Controller;

use App\Entity\Project;
use App\Repository\PageRepository;
use App\Repository\ProjectRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends AbstractController
{
    #[Route('/', name: 'homepage')]
    public function index(PageRepository $repo, ProjectRepository $projectRepo): Response
    {
        $page = $repo->findOneBy(['slug' => '/']);

        if (!$page) {
            throw $this->createNotFoundException();
        }

        $businessCase = $projectRepo->findHomepageProjectForCategory('Business');
        $peopleCase = $projectRepo->findHomepageProjectForCategory('People');
        $eventsCase = $projectRepo->findHomepageProjectForCategory('Events');

        return $this->render('default/homepage.html.twig', [
            'page' => $page,
            'businessCase' => $businessCase,
            'peopleCase' => $peopleCase,
            'eventsCase' => $eventsCase,
        ]);
    }

    #[Route('/people', name: 'people')]
    public function people(PageRepository $repo): Response
    {
        $page = $repo->findOneBy(['slug' => 'people']);

        if (!$page) {
            throw $this->createNotFoundException();
        }


        return $this->render('default/people.html.twig', [
            'page' => $page,
        ]);
    }

    #[Route('/business', name: 'business')]
    public function business(PageRepository $repo): Response
    {
        $page = $repo->findOneBy(['slug' => 'business']);

        if (!$page) {
            throw $this->createNotFoundException();
        }


        return $this->render('default/business.html.twig', [
            'page' => $page,
        ]);
    }

    #[Route('/events', name: 'events')]
    public function events(PageRepository $repo): Response
    {
        $page = $repo->findOneBy(['slug' => 'events']);

        if (!$page) {
            throw $this->createNotFoundException();
        }


        return $this->render('default/events.html.twig', [
            'page' => $page,
        ]);
    }

    #[Route('/jobmarketing', name: 'jobmarketing')]
    public function jobmarketing(PageRepository $repo, EntityManagerInterface $em): Response
    {
        $page = $repo->findOneBy(['slug' => 'jobmarketing']);

        if (!$page) {
            throw $this->createNotFoundException();
        }
        $cases = $em->getRepository(Project::class)->findBy(['type' => 'jobmarketing'], ['position' => 'ASC']);

        return $this->render('default/jobmarketing.html.twig', [
            'page' => $page,
            'cases' => $cases,
        ]);
    }

    #[Route('/contact', name: 'contact')]
    public function contact(PageRepository $repo): Response
    {
        $page = $repo->findOneBy(['slug' => 'contact']);

        if (!$page) {
            throw $this->createNotFoundException();
        }

        return $this->render('default/contact.html.twig', [
            'page' => $page,
        ]);
    }

    #[Route('/assets/Algemene-voorwaarden-wetarget.pdf', name: 'algemene_voorwaarden_pdf')]
    public function algemeneVoorwaardenPdf(): Response
    {
        $filePath = $this->getParameter('kernel.project_dir') . '/public/Algemene-voorwaarden-wetarget.pdf';

        if (!file_exists($filePath)) {
            throw $this->createNotFoundException('PDF file not found');
        }

        return new BinaryFileResponse($filePath);
    }

    // Catch-all for CMS-like pages. Restricted to a single segment (no slashes)
    // and excludes reserved words & the 'assets' prefix so static/dynamic asset
    // routes (e.g. /assets/logos/email-signature.gif) are not swallowed.
    #[Route(
        '/{slug}',
        name: 'page_show',
        requirements: ['slug' => '^(?!login$|admin$|sitemap\.xml$|assets$)[^/]+$']
    )]
    public function show(PageRepository $repo, string $slug): Response
    {
        $page = $repo->findOneBy(['slug' => $slug]);

        if (!$page) {
            throw $this->createNotFoundException();
        }

        return $this->render('default/index.html.twig', [
            'page' => $page,
        ]);
    }
}
