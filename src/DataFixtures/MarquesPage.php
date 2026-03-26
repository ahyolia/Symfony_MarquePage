<?php

namespace App\DataFixtures;

use App\Entity\MarquePage;
use App\Entity\MotsCle;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class MarquesPage extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $liens = [
            [
                'url' => 'https://hsr.hoyoverse.com/fr-fr/',
                'commentaire' => 'Site officiel de Honkai Star Rail pour les actualités et informations sur le jeu.',
                'mots_cles' => ['honkai star rail', 'site officiel', 'actualites', 'mise a jour', 'personnages', 'events'],
            ],
            [
                'url' => 'https://www.nautiljon.com',
                'commentaire' => 'Nautiljon est une base de données complète pour les anime, manga et jeux vidéo, offrant des informations détaillées sur les personnages, les épisodes et les séries.',
                'mots_cles' => ['nautiljon', 'anime', 'manga', 'base de donnees', 'series', 'episodes'],
            ],
            [
                'url' => 'https://www.pinterest.com',
                'commentaire' => 'Pinterest est une plateforme de partage d\'images, idéale pour trouver des fan arts, des captures d\'écran et des inspirations visuelles liées à nos intérêts.',
                'mots_cles' => ['pinterest', 'fan art', 'captures ecran', 'inspirations visuelles', 'images', 'communaute'],
            ],
            [
                'url' => 'https://www.youtube.com',
                'commentaire' => 'YouTube est une plateforme de partage de vidéos.',
                'mots_cles' => ['youtube', 'guides', 'tier list', 'videos', 'gameplay', 'astuces'],
            ],
            [
                'url' => 'https://www.linkedin.com',
                'commentaire' => 'LinkedIn peut être utilisé pour suivre les professionnels.',
                'mots_cles' => ['linkedin', 'professionnels', 'industrie du jeu video', 'reseau', 'opportunites', 'veille'],
            ],
        ];

        $motsClesParNom = [];
        foreach ($liens as $lien) {
            foreach ($lien['mots_cles'] as $nom) {
                if (!isset($motsClesParNom[$nom])) {
                    $motCle = new MotsCle();
                    $motCle->setNom($nom);
                    $manager->persist($motCle);
                    $motsClesParNom[$nom] = $motCle;
                }
            }
        }

        foreach ($liens as $lien) {
            $marquePage = new MarquePage();
            $marquePage->setURL($lien['url']);
            $marquePage->setCommentaire($lien['commentaire']);
            $marquePage->setDateCreation(new \DateTime(sprintf('-%d days', random_int(0, 120))));

            $motsClesMelanges = $lien['mots_cles'];
            shuffle($motsClesMelanges);
            $nombreMots = random_int(2, min(5, count($motsClesMelanges)));

            for ($j = 0; $j < $nombreMots; $j++) {
                $marquePage->addMotsCle($motsClesParNom[$motsClesMelanges[$j]]);
            }

            $manager->persist($marquePage);
        }

        $manager->flush();
    }
}
