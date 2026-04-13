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
            ['nom' => 'Levy', 'prenom' => 'Marc'],
            ['nom' => 'Kafka', 'prenom' => 'Franz'],
            ['nom' => 'Dostoïevski', 'prenom' => 'Fiodor '],
        ];

        foreach ($noms as $nomComplet) {
            $auteur = new Auteur();
            $auteur->setNom($nomComplet['nom']);
            $auteur->setPrenom($nomComplet['prenom']);
            $manager->persist($auteur);
            $auteurs[] = $auteur;
        }

        $livres = [
            [ 'titre' => 'Ghost in Love', 'resume' => 'Un roman joyeux et tendre sur les relations entre père et fils. ', 'annee' => 2019, 'auteur' => $auteurs[0] ],
            ['titre' => 'La métamorphose', 'resume' => 'Un homme se réveille un matin transformé en un insecte géant, explorant les thèmes de l’aliénation et de l’identité.', 'annee' => 1915, 'auteur' => $auteurs[1] ],
            [ 'titre' => 'Les nuits blanches', 'resume' => 'Un jeune homme rêveur rencontre une femme mystérieuse lors de nuits blanches à Saint-Pétersbourg.', 'annee' => 1848, 'auteur' => $auteurs[2] ],
        ];

        foreach ($livres as $livreData) {
            $livre = new LivresEntity();
            $livre->setTitre($livreData['titre']);
            $livre->setResume($livreData['resume']);
            $livre->setAnnee(new \DateTime(sprintf('', $livreData['annee'])));
            $livre->setAuteur($livreData['auteur']);
            $manager->persist($livre);
        }


        $manager->flush();
    }

}
