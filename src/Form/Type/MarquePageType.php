<?php

namespace App\Form\Type;

use App\Entity\MarquePage;
use App\Entity\MotsCle;
use App\Repository\MotsCleRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MarquePageType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('URL', UrlType::class, [
                'label' => 'URL',
            ])
            ->add('date_creation', DateType::class, [
                'label' => 'Date de creation',
                'widget' => 'single_text',
            ])
            ->add('commentaire', TextareaType::class, [
                'label' => 'Commentaire',
                'required' => false,
            ])
            ->add('motsCles', EntityType::class, [
                'class' => MotsCle::class,
                'label' => 'Mots-cles',
                'choice_label' => 'nom',
                'multiple' => true,
                'expanded' => false,
                'required' => false,
                'attr' => [
                    'data-tag-select' => 'true',
                ],
                'query_builder' => static fn (MotsCleRepository $repository) => $repository->createQueryBuilder('m')
                    ->orderBy('m.nom', 'ASC'),
            ])
            ->add('save', SubmitType::class, [
                'label' => 'Enregistrer',
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => MarquePage::class,
        ]);
    }
}
