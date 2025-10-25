<?php

namespace App\Controller\Admin;

use App\Entity\Page;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;

class PageCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Page::class;
    }

    public function configureFields(string $pageName): iterable
    {
        $templateField = ChoiceField::new('template')
            ->setChoices([
                'Standaard' => 'default',
                'Service' => 'service',
            ]);

        $slugField = TextField::new('slug');

        $titleField = TextField::new('title');
        $text1Field = TextEditorField::new('text1')
            ->setTrixEditorConfig([
                'blockAttributes' => [
                    'default' => ['tagName' => 'p'],
                    'heading1' => ['tagName' => 'h2'],
                ],
            ]);

        $seoTitle = TextField::new('seoTitle')->hideOnIndex();
        $seoDescription = TextareaField::new('seoDescription')->hideOnIndex();

        $serviceFields = [
            TextField::new('subtitle1')->hideOnIndex(),
            $text1Field,
            TextField::new('subtitle2')->hideOnIndex(),
            TextEditorField::new('text2')->hideOnIndex()
                ->setTrixEditorConfig([
                    'blockAttributes' => [
                        'default' => ['tagName' => 'p'],
                        'heading1' => ['tagName' => 'h2'],
                    ],
                ]),
            TextField::new('subtitle3')->hideOnIndex(),
            TextEditorField::new('text3')->hideOnIndex()
                ->setTrixEditorConfig([
                    'blockAttributes' => [
                        'default' => ['tagName' => 'p'],
                        'heading1' => ['tagName' => 'h2'],
                    ],
                ]),
            TextField::new('subtitle4')->hideOnIndex(),
            TextEditorField::new('text4')->hideOnIndex()
                ->setTrixEditorConfig([
                    'blockAttributes' => [
                        'default' => ['tagName' => 'p'],
                        'heading1' => ['tagName' => 'h2'],
                    ],
                ]),
            TextField::new('subtitle5')->hideOnIndex(),
            TextEditorField::new('text5')->hideOnIndex()
                ->setTrixEditorConfig([
                    'blockAttributes' => [
                        'default' => ['tagName' => 'p'],
                        'heading1' => ['tagName' => 'h2'],
                    ],
                ]),
            TextField::new('subtitle6')->hideOnIndex(),
            TextEditorField::new('text6')->hideOnIndex()
                ->setTrixEditorConfig([
                    'blockAttributes' => [
                        'default' => ['tagName' => 'p'],
                        'heading1' => ['tagName' => 'h2'],
                    ],
                ]),
        ];

        $fields = [
            IdField::new('id')->onlyOnIndex(),
            $templateField,
            $titleField,
            $slugField,
        ];

        // Dynamisch afhankelijk van template (optioneel verder uitbreidbaar)
        $template = $this->getContext()?->getEntity()?->getInstance()?->getTemplate();

        if ($template === 'default') {
            $fields[] = $text1Field;
        } elseif ($template === 'service') {
            $fields = array_merge($fields, $serviceFields);
        }

        // SEO toevoegen onderaan
        $fields[] = $seoTitle;
        $fields[] = $seoDescription;

        return $fields;
    }
}
