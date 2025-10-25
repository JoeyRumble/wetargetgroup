<?php

namespace App\Controller\Admin;

use App\Entity\Project;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\SlugField;
use EasyCorp\Bundle\EasyAdminBundle\Field\Field;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use Vich\UploaderBundle\Form\Type\VichImageType;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use EasyCorp\Bundle\EasyAdminBundle\Context\AdminContext;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use Symfony\Component\Routing\RouterInterface;
use FOS\CKEditorBundle\Form\Type\CKEditorType;

class ProjectCrudController extends AbstractCrudController
{
    private EntityManagerInterface $em;
    private RouterInterface $router;

    public function __construct(EntityManagerInterface $em, RouterInterface $router)
    {
        $this->em = $em;
        $this->router = $router;
    }

    public static function getEntityFqcn(): string
    {
        return Project::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('title'),
            ChoiceField::new('type')
                ->setChoices([
                    'Case' => 'case',
                    'Jobmarketing' => 'jobmarketing',
                ])
                ->renderExpanded(false)
                ->setRequired(false),
            IdField::new('id')->onlyOnIndex(),
            SlugField::new('slug')->setTargetFieldName('title'),
            TextField::new('tags')->hideOnIndex(),
            Field::new('imageFile')->setFormType(VichImageType::class)->onlyOnForms(),
            ImageField::new('imageFileName')
                ->setBasePath('/uploads')
                ->setUploadDir('uploads/')
                ->onlyOnDetail(),
            TextField::new('subpageTitleFirst')->hideOnIndex(),
            TextEditorField::new('subpageTextFirst')
                ->hideOnIndex()
                ->setTrixEditorConfig([
                    'blockAttributes' => [
                        'default' => ['tagName' => 'p'],
                        'heading1' => ['tagName' => 'h2'],
                    ],
                ]),
            TextField::new('subpageTitleSecond')->hideOnIndex(),
            TextEditorField::new('subpageTextSecond')
                ->hideOnIndex()
                ->setTrixEditorConfig([
                    'blockAttributes' => [
                        'default' => ['tagName' => 'p'],
                        'heading1' => ['tagName' => 'h2'],
                    ],
                ]),
            Field::new('subpageImageSecondFile')->setFormType(VichImageType::class)->onlyOnForms(),
            ImageField::new('subpageImageSecondFileName')
                ->setBasePath('/uploads')
                ->setUploadDir('uploads/')
                ->onlyOnDetail(),
            TextField::new('subpageTitleThird')->hideOnIndex(),
            TextEditorField::new('subpageTextThird')
                ->hideOnIndex()
                ->setTrixEditorConfig([
                    'blockAttributes' => [
                        'default' => ['tagName' => 'p'],
                        'heading1' => ['tagName' => 'h2'],
                    ],
                ]),
            Field::new('subpageImageThirdFile')->setFormType(VichImageType::class)->onlyOnForms(),
            ImageField::new('subpageImageThirdFileName')
                ->setBasePath('/uploads')
                ->setUploadDir('uploads/')
                ->onlyOnDetail(),
            TextField::new('subpageTitleFourth')->hideOnIndex(),
            TextEditorField::new('subpageTextFourth')
                ->hideOnIndex()
                ->setTrixEditorConfig([
                    'blockAttributes' => [
                        'default' => ['tagName' => 'p'],
                        'heading1' => ['tagName' => 'h2'],
                    ],
                ]),
            Field::new('subpageImageFourthFile')->setFormType(VichImageType::class)->onlyOnForms(),
            Field::new('logoFile')->setFormType(VichImageType::class)->onlyOnForms(),
            ChoiceField::new('categories')
                ->setChoices([
                    'Business' => 'Business',
                    'People' => 'People',
                    'Events' => 'Events',
                ])
                ->allowMultipleChoices()
                ->renderExpanded()
                ->onlyOnForms(),
            ChoiceField::new('categories')
                ->formatValue(fn ($value) => is_array($value) ? implode(', ', $value) : $value)
                ->onlyOnIndex(),
            TextField::new('tags')->onlyOnIndex(),
            Field::new('showOnHomepage', 'Show on homepage')->setFormTypeOption('attr.class', 'form-switch'),
            Field::new('position')->setSortable(true)->onlyOnIndex(),
        ];
    }

    // public function configureActions(Actions $actions): Actions
    // {
    //     $duplicate = Action::new('duplicate', 'Duplicate')
    //         ->linkToCrudAction('duplicateProject')
    //         ->setCssClass('btn btn-info');
    //     return $actions
    //         ->add(Action::INDEX, $duplicate)
    //         ->add(Action::DETAIL, $duplicate);
    // }

    // public function duplicateProject(AdminContext $context): RedirectResponse
    // {
    //     /** @var Project $project */
    //     $project = $context->getEntity()->getInstance();
    //     $clone = clone $project;
    //     $clone->setTitle($project->getTitle() . ' (Copy)');
    //     $clone->setSlug($project->getSlug() . '-copy-' . uniqid());
    //     $this->em->persist($clone);
    //     $this->em->flush();
    //     $url = $this->router->generate('admin', [
    //         'crudAction' => 'edit',
    //         'crudControllerFqcn' => self::class,
    //         'entityId' => $clone->getId(),
    //     ]);
    //     return new RedirectResponse($url);
    // }
}
