<?php

namespace App\Controller\Admin;

use App\Entity\Token;
use Vich\UploaderBundle\Form\Type\VichImageType;
use EasyCorp\Bundle\EasyAdminBundle\Config\Assets;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class TokenCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Token::class;
    }

    
    public function configureFields(string $pageName): iterable
    {
        return [
          
            TextField::new('name'),
          
            TextField::new('imageFile')->setFormType(VichImageType::class)->onlyOnForms(),
            ImageField::new('file')->setBasePath('/uploads/logos/')->onlyOnindex(),
            TextField::new('fullName'),
            // Fill fiel with random number
            NumberField::new('randomNumber')->hideOnIndex()->addCssClass('random-number'),
            // Set date of day creation/update
            // DateField::new('updated_at'),

        ];
    }
    

}
