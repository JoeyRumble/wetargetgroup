<?php

namespace App\Repository;

use App\Entity\Project;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Project>
 */
class ProjectRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Project::class);
    }

    /**
     * Get the top project for a category to show on homepage
     */
    public function findHomepageProjectForCategory(string $category): ?Project
    {
        $qb = $this->createQueryBuilder('p')
            ->andWhere('p.showOnHomepage = true')
            ->orderBy('p.position', 'DESC')
            ->addOrderBy('p.id', 'DESC');
        // Filter in PHP due to JSON/array
        $projects = $qb->getQuery()->getResult();
        foreach ($projects as $project) {
            if (is_array($project->getCategories()) && in_array($category, $project->getCategories())) {
                return $project;
            }
        }
        return null;
    }
}
