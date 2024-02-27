<?php

namespace App\Form;

use App\Form\DataModel\PostuloModel;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PostuloType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('search', ChoiceType::class, [
                'choices' => [
                    'Alternance' => PostuloModel::SEARCH_ALTERNANCE,
                    'Contrat normal' => PostuloModel::SEARCH_CDI
                ]
            ])
            ->add('localisation', ChoiceType::class, [
                'choices' => [
                    'Aix en Provence' => PostuloModel::LOCALISATION_AIX,
                    'Pélissanne' => PostuloModel::LOCALISATION_PELISSANNE
                ]
            ])
            ->add('enterpriseName', TextType::class, [
                'required' => false
            ])
            ->add('enterpriseEmail', TextType::class, [
                'required' => false
            ])
            ->add('emailContentEnterpriseParaph', TextareaType::class, [
                'required' => false
            ])
            ->add('motivationLetterEnterpriseParaph', TextareaType::class, [
                'required' => false
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => PostuloModel::class
        ]);
    }
}
