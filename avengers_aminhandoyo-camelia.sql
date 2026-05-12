-- SQL dump generated from project entities and fixtures
-- Import this file into phpMyAdmin (choose or create database first)

SET FOREIGN_KEY_CHECKS = 0;

DROP TABLE IF EXISTS marque_page_mots_cle;
DROP TABLE IF EXISTS livres;
DROP TABLE IF EXISTS marque_page;
DROP TABLE IF EXISTS mots_cle;
DROP TABLE IF EXISTS cailloux;
DROP TABLE IF EXISTS employe;
DROP TABLE IF EXISTS adresse;
DROP TABLE IF EXISTS auteur;

-- Table: auteur
CREATE TABLE auteur (
  id INT AUTO_INCREMENT PRIMARY KEY,
  nom VARCHAR(255) NOT NULL,
  prenom VARCHAR(255) NOT NULL,
  slug VARCHAR(191) NOT NULL UNIQUE,
  created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  updated_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Table: mots_cle
CREATE TABLE mots_cle (
  id INT AUTO_INCREMENT PRIMARY KEY,
  nom VARCHAR(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Table: marque_page
CREATE TABLE marque_page (
  id INT AUTO_INCREMENT PRIMARY KEY,
  url VARCHAR(255) NOT NULL,
  date_creation DATE NOT NULL,
  commentaire VARCHAR(255) DEFAULT NULL,
  mots_cles VARCHAR(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Join table: marque_page_mots_cle
CREATE TABLE marque_page_mots_cle (
  marque_page_id INT NOT NULL,
  mots_cle_id INT NOT NULL,
  PRIMARY KEY (marque_page_id, mots_cle_id),
  INDEX IDX_MP (marque_page_id),
  INDEX IDX_MC (mots_cle_id),
  CONSTRAINT FK_MP FOREIGN KEY (marque_page_id) REFERENCES marque_page(id) ON DELETE CASCADE,
  CONSTRAINT FK_MC FOREIGN KEY (mots_cle_id) REFERENCES mots_cle(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Table: adresse
CREATE TABLE adresse (
  id INT AUTO_INCREMENT PRIMARY KEY,
  rue VARCHAR(255) NOT NULL,
  code_postal VARCHAR(20) NOT NULL,
  ville VARCHAR(255) NOT NULL,
  pays VARCHAR(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Table: employe
CREATE TABLE employe (
  id INT AUTO_INCREMENT PRIMARY KEY,
  nom VARCHAR(255) NOT NULL,
  prenom VARCHAR(255) NOT NULL,
  email VARCHAR(255) NOT NULL,
  adresse_id INT NOT NULL UNIQUE,
  CONSTRAINT FK_EMP_ADR FOREIGN KEY (adresse_id) REFERENCES adresse(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Table: cailloux
CREATE TABLE cailloux (
  id INT AUTO_INCREMENT PRIMARY KEY,
  titre VARCHAR(255) NOT NULL,
  images VARCHAR(255) DEFAULT NULL,
  description VARCHAR(255) DEFAULT NULL,
  categorie VARCHAR(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Table: livres
CREATE TABLE livres (
  id INT AUTO_INCREMENT PRIMARY KEY,
  titre VARCHAR(255) NOT NULL,
  annee DATE NOT NULL,
  auteur_id INT NOT NULL,
  resume VARCHAR(255) NOT NULL,
  slug VARCHAR(191) NOT NULL UNIQUE,
  created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  updated_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  CONSTRAINT FK_LIV_AUTEUR FOREIGN KEY (auteur_id) REFERENCES auteur(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- INSERT sample data from fixtures

-- Auteurs
INSERT INTO auteur (id, nom, prenom, slug, created_at, updated_at) VALUES
(1, 'Levy', 'Marc', 'marc-levy', NOW(), NOW()),
(2, 'Kafka', 'Franz', 'franz-kafka', NOW(), NOW()),
(3, 'Dostoïevski', 'Fiodor', 'fiodor-dostoievski', NOW(), NOW());

-- Livres (annee set to Jan 1 of year)
INSERT INTO livres (id, titre, annee, auteur_id, resume, slug, created_at, updated_at) VALUES
(1, 'Ghost in Love', '2019-01-01', 1, 'Un roman joyeux et tendre sur les relations entre père et fils.', 'ghost-in-love', NOW(), NOW()),
(2, 'La métamorphose', '1915-01-01', 2, 'Un homme se réveille un matin transformé en un insecte géant, explorant les thèmes de l’aliénation et de l’identité.', 'la-metamorphose', NOW(), NOW()),
(3, 'Les nuits blanches', '1848-01-01', 3, 'Un jeune homme rêveur rencontre une femme mystérieuse lors de nuits blanches à Saint-Pétersbourg.', 'les-nuits-blanches', NOW(), NOW());

-- Cailloux
INSERT INTO cailloux (id, titre, description, categorie, images) VALUES
(1, 'Cagou', 'Le cagou est un oiseau endemique de Nouvelle-Caledonie, connu pour son plumage gris et son incapacite a voler.', 'Faune', 'cagou.jpg'),
(2, 'Trico-raye', 'Le trico-raye est un oiseau endemique de Nouvelle-Caledonie, reconnaissable a son plumage raye noir et blanc.', 'Faune', 'trico_raye.jpg'),
(3, 'Niaouli', 'Le niaouli est un arbre endemique de Nouvelle-Caledonie, apprecie pour son bois et ses proprietes medicinales.', 'Flore', 'niaouli.jpg'),
(4, 'Hibiscus de Nouvelle-Caledonie', 'L\'hibiscus de Nouvelle-Caledonie est une plante endemique, celebre pour ses grandes fleurs colorees.', 'Flore', 'hibiscus.jpg');

-- Mots cle (unique keywords from fixtures)
INSERT INTO mots_cle (id, nom) VALUES
(1, 'honkai star rail'),
(2, 'site officiel'),
(3, 'actualites'),
(4, 'mise a jour'),
(5, 'personnages'),
(6, 'events'),
(7, 'nautiljon'),
(8, 'anime'),
(9, 'manga'),
(10, 'base de donnees'),
(11, 'series'),
(12, 'episodes'),
(13, 'pinterest'),
(14, 'fan art'),
(15, 'captures ecran'),
(16, 'inspirations visuelles'),
(17, 'images'),
(18, 'communaute'),
(19, 'youtube'),
(20, 'guides'),
(21, 'tier list'),
(22, 'videos'),
(23, 'gameplay'),
(24, 'astuces'),
(25, 'linkedin'),
(26, 'professionnels'),
(27, 'industrie du jeu video'),
(28, 'reseau'),
(29, 'opportunites'),
(30, 'veille');

-- MarquePage entries
INSERT INTO marque_page (id, url, date_creation, commentaire, mots_cles) VALUES
(1, 'https://hsr.hoyoverse.com/fr-fr/', '2026-05-01', 'Site officiel de Honkai Star Rail pour les actualités et informations sur le jeu.', NULL),
(2, 'https://www.nautiljon.com', '2026-04-20', 'Nautiljon est une base de données complète pour les anime, manga et jeux vidéo, offrant des informations détaillées sur les personnages, les épisodes et les séries.', NULL),
(3, 'https://www.pinterest.com', '2026-03-15', 'Pinterest est une plateforme de partage d\'images, idéale pour trouver des fan arts, des captures d\'écran et des inspirations visuelles liées à nos intérêts.', NULL),
(4, 'https://www.youtube.com', '2026-01-10', 'YouTube est une plateforme de partage de vidéos.', NULL),
(5, 'https://www.linkedin.com', '2025-12-01', 'LinkedIn peut être utilisé pour suivre les professionnels.', NULL);

-- Associations marque_page <-> mots_cle (manuellement chosen to reflect fixtures)
INSERT INTO marque_page_mots_cle (marque_page_id, mots_cle_id) VALUES
(1, 1),(1,2),(1,3),(1,5),(1,6),
(2, 7),(2,8),(2,9),(2,10),(2,11),(2,12),
(3, 13),(3,14),(3,15),(3,16),(3,17),(3,18),
(4, 19),(4,20),(4,21),(4,22),(4,23),(4,24),
(5, 25),(5,26),(5,27),(5,28),(5,29),(5,30);

SET FOREIGN_KEY_CHECKS = 1;

-- End of dump
