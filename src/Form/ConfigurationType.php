<?php

namespace App\Form;

use App\Entity\Token;
use App\Entity\Exchange;
use App\Entity\Configuration;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class ConfigurationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('start_date',
                DateType::class,
                [
                    'widget' => 'single_text',
                    'format' => 'yyyy-MM-dd',
                    'attr' => [
                        'class' => 'form-control'
                    ],
                    'required' => false,
                    'data' => new \DateTime('first day of January'),
                ])
            ->add('end_date',
                DateType::class,
                [
                    'widget' => 'single_text',
                    'format' => 'yyyy-MM-dd',
                    'attr' => [
                        'class' => 'form-control'
                    ],
                    'required' => false,
                    'data' => new \DateTime('last day of December'),
                ])
            ->add('token', 
                EntityType::class,
                    [
                        'class' => Token::class,
                        'choice_label' => 'name',
                        'placeholder' => 'All',
                        'empty_data' => '',
                        'attr' => [
                            'class' => 'form-control'
                        ],
                        'required' => false,
                        // multi selection
                    ])
            ->add('exchange',
                EntityType::class,
                [
                    'class' => Exchange::class,
                    'choice_label' => 'name',
                    'placeholder' => 'All',
                    'empty_data' => '',
                    'attr' => [
                        'class' => 'form-control'
                    ],
                    'required' => false
                ])
            // add Submit button with class btn btn-primary
            ->add('submit',
                SubmitType::class,
                [
                    'label' => 'Search',
                    'attr' => [
                        'class' => 'btn btn-primary'
                    ]
                ]);
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Configuration::class,
        ]);
    }
}
