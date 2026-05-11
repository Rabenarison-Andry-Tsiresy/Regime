
SET FOREIGN_KEY_CHECKS = 0;

-- ============================================
-- SUPPRESSION DES TABLES EXISTANTES
-- ============================================
DROP TABLE IF EXISTS `parametres`;
DROP TABLE IF EXISTS `paiements`;
DROP TABLE IF EXISTS `historique_regimes`;
DROP TABLE IF EXISTS `abonnements_gold`;
DROP TABLE IF EXISTS `codes_gold`;
DROP TABLE IF EXISTS `codes_rechargement`;
DROP TABLE IF EXISTS `portefeuilles`;
DROP TABLE IF EXISTS `activites_sportives`;
DROP TABLE IF EXISTS `aliments`;
DROP TABLE IF EXISTS `regimes`;
DROP TABLE IF EXISTS `profil_sante`;
DROP TABLE IF EXISTS `utilisateurs`;
DROP TABLE IF EXISTS `objectifs`;
DROP TABLE IF EXISTS `sexes`;

-- ============================================
-- CRÉATION DES TABLES
-- ============================================

-- Table: sexes
CREATE TABLE `sexes` (
    `id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
    `label` VARCHAR(20) NOT NULL,
    `created_at` DATETIME DEFAULT NULL,
    `updated_at` DATETIME DEFAULT NULL,
    PRIMARY KEY (`id`),
    UNIQUE KEY `unique_label` (`label`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Table: objectifs
CREATE TABLE `objectifs` (
    `id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
    `code` VARCHAR(30) NOT NULL,
    `label` VARCHAR(100) NOT NULL,
    `created_at` DATETIME DEFAULT NULL,
    `updated_at` DATETIME DEFAULT NULL,
    PRIMARY KEY (`id`),
    UNIQUE KEY `unique_code` (`code`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Table: utilisateurs
CREATE TABLE `utilisateurs` (
    `id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
    `nom` VARCHAR(120) NOT NULL,
    `email` VARCHAR(190) NOT NULL,
    `password_hash` VARCHAR(255) NOT NULL,
    `age` INT(3) DEFAULT NULL,
    `sexe_id` INT(11) UNSIGNED DEFAULT NULL,
    `role` VARCHAR(20) DEFAULT 'user',
    `premium` TINYINT(1) DEFAULT 0,
    `created_at` DATETIME DEFAULT NULL,
    `updated_at` DATETIME DEFAULT NULL,
    PRIMARY KEY (`id`),
    UNIQUE KEY `unique_email` (`email`),
    KEY `idx_sexe_id` (`sexe_id`),
    CONSTRAINT `fk_utilisateurs_sexe` FOREIGN KEY (`sexe_id`) REFERENCES `sexes` (`id`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Table: profil_sante
CREATE TABLE `profil_sante` (
    `id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
    `user_id` INT(11) UNSIGNED NOT NULL,
    `taille_cm` DECIMAL(5,2) NOT NULL,
    `poids_kg` DECIMAL(5,2) NOT NULL,
    `objectif_id` INT(11) UNSIGNED DEFAULT NULL,
    `imc` DECIMAL(5,2) DEFAULT NULL,
    `created_at` DATETIME DEFAULT NULL,
    `updated_at` DATETIME DEFAULT NULL,
    PRIMARY KEY (`id`),
    UNIQUE KEY `unique_user_id` (`user_id`),
    KEY `idx_objectif_id` (`objectif_id`),
    CONSTRAINT `fk_profil_sante_user` FOREIGN KEY (`user_id`) REFERENCES `utilisateurs` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
    CONSTRAINT `fk_profil_sante_objectif` FOREIGN KEY (`objectif_id`) REFERENCES `objectifs` (`id`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Table: regimes
CREATE TABLE `regimes` (
    `id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
    `nom` VARCHAR(120) NOT NULL,
    `description` TEXT DEFAULT NULL,
    `duree_jours` INT(4) NOT NULL,
    `prix` DECIMAL(10,2) NOT NULL,
    `calories_cible` INT(6) NOT NULL,
    `variation_poids` DECIMAL(5,2) DEFAULT NULL,
    `pourcentage_viande` TINYINT(3) NOT NULL,
    `pourcentage_poisson` TINYINT(3) NOT NULL,
    `pourcentage_volaille` TINYINT(3) NOT NULL,
    `pourcentage_legumes_verts` TINYINT(3) NOT NULL,
    `pourcentage_fruits` TINYINT(3) NOT NULL,
    `pourcentage_feculents` TINYINT(3) NOT NULL,
    `objectif_id` INT(11) UNSIGNED DEFAULT NULL,
    `created_at` DATETIME DEFAULT NULL,
    `updated_at` DATETIME DEFAULT NULL,
    PRIMARY KEY (`id`),
    KEY `idx_objectif_id` (`objectif_id`),
    CONSTRAINT `fk_regimes_objectif` FOREIGN KEY (`objectif_id`) REFERENCES `objectifs` (`id`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Table: activites_sportives
CREATE TABLE `activites_sportives` (
    `id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
    `nom` VARCHAR(120) NOT NULL,
    `description` TEXT DEFAULT NULL,
    `objectif_id` INT(11) UNSIGNED DEFAULT NULL,
    `intensite` VARCHAR(20) DEFAULT NULL,
    `created_at` DATETIME DEFAULT NULL,
    `updated_at` DATETIME DEFAULT NULL,
    PRIMARY KEY (`id`),
    KEY `idx_objectif_id` (`objectif_id`),
    CONSTRAINT `fk_activites_sportives_objectif` FOREIGN KEY (`objectif_id`) REFERENCES `objectifs` (`id`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Table: aliments
CREATE TABLE `aliments` (
    `id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
    `nom` VARCHAR(120) NOT NULL,
    `categorie` VARCHAR(60) DEFAULT NULL,
    `description` TEXT DEFAULT NULL,
    `recommandation` TEXT DEFAULT NULL,
    `objectif_id` INT(11) UNSIGNED DEFAULT NULL,
    `actif` TINYINT(1) DEFAULT 1,
    `created_at` DATETIME DEFAULT NULL,
    `updated_at` DATETIME DEFAULT NULL,
    PRIMARY KEY (`id`),
    KEY `idx_objectif_id` (`objectif_id`),
    CONSTRAINT `fk_aliments_objectif` FOREIGN KEY (`objectif_id`) REFERENCES `objectifs` (`id`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Table: portefeuilles
CREATE TABLE `portefeuilles` (
    `id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
    `user_id` INT(11) UNSIGNED NOT NULL,
    `solde` DECIMAL(10,2) DEFAULT 0,
    `created_at` DATETIME DEFAULT NULL,
    `updated_at` DATETIME DEFAULT NULL,
    PRIMARY KEY (`id`),
    UNIQUE KEY `unique_user_id` (`user_id`),
    CONSTRAINT `fk_portefeuilles_user` FOREIGN KEY (`user_id`) REFERENCES `utilisateurs` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Table: codes_rechargement
CREATE TABLE `codes_rechargement` (
    `id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
    `code` VARCHAR(50) NOT NULL,
    `valeur` DECIMAL(10,2) NOT NULL,
    `date_expiration` DATETIME DEFAULT NULL,
    `actif` TINYINT(1) DEFAULT 1,
    `used_by` INT(11) UNSIGNED DEFAULT NULL,
    `used_at` DATETIME DEFAULT NULL,
    `created_at` DATETIME DEFAULT NULL,
    `updated_at` DATETIME DEFAULT NULL,
    PRIMARY KEY (`id`),
    UNIQUE KEY `unique_code` (`code`),
    KEY `idx_used_by` (`used_by`),
    CONSTRAINT `fk_codes_rechargement_user` FOREIGN KEY (`used_by`) REFERENCES `utilisateurs` (`id`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Table: codes_gold
CREATE TABLE `codes_gold` (
    `id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
    `code` VARCHAR(50) NOT NULL,
    `actif` TINYINT(1) DEFAULT 1,
    `used_by` INT(11) UNSIGNED DEFAULT NULL,
    `used_at` DATETIME DEFAULT NULL,
    `created_at` DATETIME DEFAULT NULL,
    `updated_at` DATETIME DEFAULT NULL,
    PRIMARY KEY (`id`),
    UNIQUE KEY `unique_code` (`code`),
    KEY `idx_used_by` (`used_by`),
    CONSTRAINT `fk_codes_gold_user` FOREIGN KEY (`used_by`) REFERENCES `utilisateurs` (`id`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Table: abonnements_gold
CREATE TABLE `abonnements_gold` (
    `id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
    `user_id` INT(11) UNSIGNED NOT NULL,
    `date_debut` DATE NOT NULL,
    `date_fin` DATE DEFAULT NULL,
    `prix` DECIMAL(10,2) NOT NULL,
    `actif` TINYINT(1) DEFAULT 1,
    `created_at` DATETIME DEFAULT NULL,
    `updated_at` DATETIME DEFAULT NULL,
    PRIMARY KEY (`id`),
    KEY `idx_user_id` (`user_id`),
    CONSTRAINT `fk_abonnements_gold_user` FOREIGN KEY (`user_id`) REFERENCES `utilisateurs` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Table: historique_regimes
CREATE TABLE `historique_regimes` (
    `id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
    `user_id` INT(11) UNSIGNED NOT NULL,
    `regime_id` INT(11) UNSIGNED NOT NULL,
    `date_debut` DATE NOT NULL,
    `date_fin` DATE NOT NULL,
    `prix_applique` DECIMAL(10,2) NOT NULL,
    `remise_appliquee` DECIMAL(10,2) DEFAULT 0,
    `created_at` DATETIME DEFAULT NULL,
    `updated_at` DATETIME DEFAULT NULL,
    PRIMARY KEY (`id`),
    KEY `idx_user_id` (`user_id`),
    KEY `idx_regime_id` (`regime_id`),
    CONSTRAINT `fk_historique_regimes_user` FOREIGN KEY (`user_id`) REFERENCES `utilisateurs` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
    CONSTRAINT `fk_historique_regimes_regime` FOREIGN KEY (`regime_id`) REFERENCES `regimes` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Table: paiements
CREATE TABLE `paiements` (
    `id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
    `user_id` INT(11) UNSIGNED NOT NULL,
    `type` VARCHAR(20) NOT NULL,
    `montant` DECIMAL(10,2) NOT NULL,
    `reference` VARCHAR(100) DEFAULT NULL,
    `created_at` DATETIME DEFAULT NULL,
    PRIMARY KEY (`id`),
    KEY `idx_user_id` (`user_id`),
    CONSTRAINT `fk_paiements_user` FOREIGN KEY (`user_id`) REFERENCES `utilisateurs` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Table: parametres
CREATE TABLE `parametres` (
    `id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
    `cle` VARCHAR(50) NOT NULL,
    `valeur` VARCHAR(255) NOT NULL,
    `created_at` DATETIME DEFAULT NULL,
    `updated_at` DATETIME DEFAULT NULL,
    PRIMARY KEY (`id`),
    UNIQUE KEY `unique_cle` (`cle`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================
-- INSERTION DES DONNÉES (SEEDER)
-- ============================================

-- Insertion dans sexes
INSERT INTO `sexes` (`id`, `label`, `created_at`, `updated_at`) VALUES
(1, 'Homme', NOW(), NOW()),
(2, 'Femme', NOW(), NOW()),
(3, 'Autre', NOW(), NOW());

-- Insertion dans objectifs
INSERT INTO `objectifs` (`id`, `code`, `label`, `created_at`, `updated_at`) VALUES
(1, 'perte_poids', 'Perte de poids', NOW(), NOW()),
(2, 'maintien', 'Maintien du poids', NOW(), NOW()),
(3, 'prise_muscle', 'Prise de muscle', NOW(), NOW()),
(4, 'secheresse', 'Sècheresse', NOW(), NOW());

-- Insertion dans regimes (quelques exemples)
INSERT INTO `regimes` (`id`, `nom`, `description`, `duree_jours`, `prix`, `calories_cible`, `variation_poids`, `pourcentage_viande`, `pourcentage_poisson`, `pourcentage_volaille`, `pourcentage_legumes_verts`, `pourcentage_fruits`, `pourcentage_feculents`, `objectif_id`, `created_at`, `updated_at`) VALUES
(1, 'Régime Protéiné', 'Régime riche en protéines pour la prise de muscle', 30, 49.99, 2500, 2.50, 40, 20, 20, 10, 5, 5, 3, NOW(), NOW()),
(2, 'Régime Équilibré', 'Régime équilibré pour maintenir son poids', 30, 29.99, 2000, 0.00, 25, 15, 20, 20, 15, 5, 2, NOW(), NOW()),
(3, 'Régime Hypocalorique', 'Régime faible en calories pour perdre du poids', 30, 39.99, 1500, -3.00, 20, 15, 15, 25, 15, 10, 1, NOW(), NOW());

-- Insertion dans activites_sportives
INSERT INTO `activites_sportives` (`id`, `nom`, `description`, `objectif_id`, `intensite`, `created_at`, `updated_at`) VALUES
(1, 'Cardio', 'Course, vélo, natation', 1, 'Modérée', NOW(), NOW()),
(2, 'Musculation', 'Développement musculaire', 3, 'Élevée', NOW(), NOW()),
(3, 'Yoga', 'Souplesse et bien-être', 2, 'Faible', NOW(), NOW());

-- Insertion dans aliments
INSERT INTO `aliments` (`id`, `nom`, `categorie`, `description`, `recommandation`, `objectif_id`, `actif`, `created_at`, `updated_at`) VALUES
(1, 'Poulet grillé', 'Viande', 'Source de protéines maigres', 'À consommer midi et soir', 3, 1, NOW(), NOW()),
(2, 'Saumon', 'Poisson', 'Riche en oméga-3', '2 fois par semaine', 2, 1, NOW(), NOW()),
(3, 'Brocoli', 'Légume vert', 'Riche en fibres et vitamines', 'À volonté', 1, 1, NOW(), NOW()),
(4, 'Quinoa', 'Féculent', 'Céréale complète', 'Portion contrôlée', 2, 1, NOW(), NOW());

-- Insertion dans parametres
INSERT INTO `parametres` (`id`, `cle`, `valeur`, `created_at`, `updated_at`) VALUES
(1, 'site_name', 'RegimeApp', NOW(), NOW()),
(2, 'site_email', 'contact@regimeapp.com', NOW(), NOW()),
(3, 'prix_abonnement_gold_mensuel', '19.99', NOW(), NOW()),
(4, 'prix_abonnement_gold_annuel', '199.99', NOW(), NOW());

-- ============================================
-- RÉACTIVATION DES CLÉS ÉTRANGÈRES
-- ============================================
SET FOREIGN_KEY_CHECKS = 1;