<?php

namespace App\Form;

use App\Entity\Token;
use App\Entity\Trade;
use App\Entity\Action;
use App\Entity\Exchange;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class TradeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            // add custom default value 'all' to action 
            ->add('action',
                EntityType::class,
                [
                    'class' => Action::class,
                    'choice_label' => 'name',
                    'placeholder' => 'All',
                    'empty_data' => '',
                    'attr' => [
                        'class' => 'form-control'
                    ],
                    'required' => false,
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
                    'required' => false,
                ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Trade::class,
        ]);
    }
}
