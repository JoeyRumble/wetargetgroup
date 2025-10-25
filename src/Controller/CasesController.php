<?php

// src/Controller/DefaultController.php

namespace App\Controller;

use App\Repository\PageRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Project;
use Symfony\Component\HttpFoundation\Request;

class CasesController extends AbstractController
{
    #[Route('/cases', name: 'cases')]
    public function index(Request $request, EntityManagerInterface $em, PageRepository $repo): Response
    {
        $page = $repo->findOneBy(['slug' => 'cases']);

        if (!$page) {
            throw $this->createNotFoundException();
        }

        $category = $request->query->get('category');
        $cases = $em->getRepository(Project::class)->findBy(['type' => 'case'], ['position' => 'ASC']);
        if ($category) {
            $cases = array_filter($cases, function ($case) use ($category) {
                $categories = $case->getCategories();
                return is_array($categories) && in_array($category, $categories);
            });
        }
        return $this->render('default/cases.html.twig', [
            'page' => $page,
            'cases' => $cases,
        ]);
    }

    #[Route('/cases/{slug}', name: 'cases_show')]
    public function show(Project $project): Response
    {
        return $this->render('default/case_show.html.twig', [
            'case' => $project,
            'page' => [
                'title' => $project->getTitle() . ' | WeTarget',
                'seoDescription' => $project->getSubpageTextFirst() ?: 'Details about the case.',
            ]
        ]);
    }
}
