-- --------------------------------------------------------
-- Création de la structure pour la Carte Interactive
-- --------------------------------------------------------

-- 1. Table des catégories (Thématiques)
CREATE TABLE IF NOT EXISTS `categories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 2. Table des lieux (Points d'intérêt)
CREATE TABLE IF NOT EXISTS `lieux` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `latitude` decimal(10,8) NOT NULL,
  `longitude` decimal(11,8) NOT NULL,
  `image_url` varchar(255) DEFAULT NULL,
  `icone_custom` varchar(255) DEFAULT NULL,
  `site_web` varchar(255) DEFAULT NULL,
  `podcast_url` varchar(255) DEFAULT NULL,
  `actif` tinyint(1) NOT NULL DEFAULT 1,
  `categorie_id` int(11) DEFAULT NULL,
  `date_creation` timestamp DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `fk_categorie` (`categorie_id`),
  CONSTRAINT `fk_categorie` FOREIGN KEY (`categorie_id`) 
    REFERENCES `categories` (`id`) 
    ON DELETE SET NULL 
    ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;