<?php

namespace App\DataFixtures;

use App\Entity\Auteur;
use App\Entity\Livres as LivresEntity;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class Livres extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $auteurs = [];
        $noms = [
            ['nom' => 'Hugo', 'prenom' => 'Victor'],
            ['nom' => 'Dumas', 'prenom' => 'Alexandre'],
            ['nom' => 'Verne', 'prenom' => 'Jules'],
        ];

        foreach ($noms as $nomComplet) {
            $auteur = new Auteur();
            $auteur->setNom($nomComplet['nom']);
            $auteur->setPrenom($nomComplet['prenom']);
            $manager->persist($auteur);
            $auteurs[] = $auteur;
        }

        $livres = [
            ['titre' => 'Les Misérables', 'resume' => 'Un roman de Victor Hugo qui explore les thèmes de la justice, de la rédemption et de l\'amour à travers les destins croisés de plusieurs personnages dans la France du XIXe siècle.', 'annee' => new \DateTime('1862-01-01'), 'auteur' => $auteurs[0]],
            ['titre' => 'Le Comte de Monte-Cristo', 'resume' => 'Un roman d\'Alexandre Dumas qui raconte l\'histoire d\'Edmond Dantès, un homme injustement emprisonné qui s\'évade et cherche à se venger de ceux qui l\'ont trahi.', 'annee' => new \DateTime('1844-01-01'), 'auteur' => $auteurs[1]],
            ['titre' => 'Vingt Mille Lieues sous les mers', 'resume' => 'Un roman de Jules Verne qui suit les aventures du professeur Aronnax, de son assistant Conseil et du harponneur Ned Land à bord du Nautilus, un sous-marin commandé par le mystérieux capitaine Nemo.', 'annee' => new \DateTime('1870-01-01'), 'auteur' => $auteurs[2]],
        ];

        foreach ($livres as $livreData) {
            $livre = new LivresEntity();
            $livre->setTitre($livreData['titre']);
            $livre->setResume($livreData['resume']);
            $livre->setAnnee($livreData['annee']);
            $livre->setAuteur($livreData['auteur']);
            $manager->persist($livre);
        }


        $manager->flush();
    }

}
