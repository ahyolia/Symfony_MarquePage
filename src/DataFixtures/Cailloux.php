<?php

namespace App\DataFixtures;

use App\Entity\Cailloux as CaillouxEntity;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class Cailloux extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $elements = [
            [
                'titre' => 'Cagou',
                'description' => 'Le cagou est un oiseau endemique de Nouvelle-Caledonie, connu pour son plumage gris et son incapacite a voler.',
                'categorie' => 'Faune',
                'images' => 'cagou.jpg',
            ],
            [
                'titre' => 'Trico-raye',
                'description' => 'Le trico-raye est un oiseau endemique de Nouvelle-Caledonie, reconnaissable a son plumage raye noir et blanc.',
                'categorie' => 'Faune',
                'images' => 'trico_raye.jpg',
            ],
            [
                'titre' => 'Niaouli',
                'description' => 'Le niaouli est un arbre endemique de Nouvelle-Caledonie, apprecie pour son bois et ses proprietes medicinales.',
                'categorie' => 'Flore',
                'images' => 'niaouli.jpg',
            ],
            [
                'titre' => 'Hibiscus de Nouvelle-Caledonie',
                'description' => 'L\'hibiscus de Nouvelle-Caledonie est une plante endemique, celebre pour ses grandes fleurs colorees.',
                'categorie' => 'Flore',
                'images' => 'hibiscus.jpg',
            ],
        ];

        foreach ($elements as $element) {
            $cailloux = new CaillouxEntity();
            $cailloux->setTitre($element['titre']);
            $cailloux->setDescription($element['description']);
            $cailloux->setCategorie($element['categorie']);
            $cailloux->setImages($element['images']);

            $manager->persist($cailloux);
        }

        $manager->flush();
    }
}
