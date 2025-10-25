<?php

namespace App\Controller;

use App\Entity\Project;
use App\Entity\Page;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SitemapController extends AbstractController
{
    #[Route('/sitemap.xml', name: 'sitemap', defaults: ['_format' => 'xml'])]
    public function index(EntityManagerInterface $em): Response
    {
        $pages = $em->getRepository(Page::class)->findAll();
        $cases = $em->getRepository(Project::class)->findBy(['type' => 'case'], ['position' => 'ASC']);
        $urls = [];
        foreach ($pages as $page) {
            $urls[] = [
                'loc' => $this->generateUrl('page_show', ['slug' => ($page->getSlug() == '/' ? '' : $page->getSlug())], 0),
                'changefreq' => 'weekly',
                'priority' => '0.8',
            ];
        }
        foreach ($cases as $case) {
            $urls[] = [
                'loc' => $this->generateUrl('cases_show', ['slug' => $case->getSlug()], 0),
                'changefreq' => 'weekly',
                'priority' => '0.7',
            ];
        }
        return $this->render('sitemap/sitemap.xml.twig', [
            'urls' => $urls,
        ]);
    }
}
