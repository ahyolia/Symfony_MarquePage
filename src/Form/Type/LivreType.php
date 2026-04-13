<?php

namespace App\Form\Type;

use App\Entity\Auteur;
use App\Entity\Livres;
use App\Repository\AuteurRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Range;
use Symfony\Component\Validator\Constraints\Regex;

class LivreType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('titre', TextType::class)
            ->add('annee_saisie', IntegerType::class, [
                'mapped' => false,
                'label' => 'Année de publication',
                'data' => $options['annee_initiale'],
                'attr' => [
                    'min' => 1000,
                    'max' => 9999,
                    'step' => 1,
                    'placeholder' => 'ex: 2019',
                ],
                'constraints' => [
                    new NotBlank(['message' => 'L\'année est obligatoire.']),
                    new Regex([
                        'pattern' => '/^\d{4}$/',
                        'message' => 'Entrez une année sur 4 chiffres.',
                    ]),
                    new Range([
                        'min' => 1000,
                        'max' => 9999,
                        'notInRangeMessage' => 'L\'année doit etre comprise entre {{ min }} et {{ max }}.',
                    ]),
                ],
            ])
            ->add('resume', TextareaType::class, [
                'label' => 'Resume',
            ]);

        if ($options['include_auteur']) {
            $builder->add('auteur', EntityType::class, [
                'class' => Auteur::class,
                'label' => 'Auteur',
                'choice_label' => static fn (Auteur $auteur): string => sprintf('%s %s', $auteur->getPrenom(), $auteur->getNom()),
                'query_builder' => static fn (AuteurRepository $repository) => $repository->createQueryBuilder('a')
                    ->orderBy('a.nom', 'ASC')
                    ->addOrderBy('a.prenom', 'ASC'),
                'placeholder' => 'Selectionnez un auteur',
                'required' => true,
            ]);
        }

        if ($options['require_consent']) {
            $builder->add('accordCondUtil', CheckboxType::class, [
                'mapped' => false,
                'label' => 'J\'accepte les conditions d\'utilisation',
                'constraints' => [
                    new IsTrue(['message' => 'Vous devez accepter les conditions.']),
                ],
            ]);
        }

        $builder
            ->add('save', SubmitType::class, [
                'label' => 'Enregistrer',
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Livres::class,
            'annee_initiale' => null,
            'include_auteur' => true,
            'require_consent' => true,
        ]);
    }
}