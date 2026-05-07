CREATE DATABASE IF NOT EXISTS bibliotheque
CHARACTER SET utf8mb4
COLLATE utf8mb4_unicode_ci;

USE bibliotheque;

CREATE TABLE IF NOT EXISTS categories (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(100) NOT NULL UNIQUE,
    created_at DATETIME NULL,
    updated_at DATETIME NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


CREATE TABLE IF NOT EXISTS livres (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    titre VARCHAR(255) NOT NULL,
    auteur VARCHAR(255) NOT NULL,
    isbn VARCHAR(20) NOT NULL UNIQUE,
    annee_publication SMALLINT NOT NULL,
    categorie VARCHAR(100) NOT NULL,
    resume TEXT NULL,
    couverture VARCHAR(255) NULL,
    statut VARCHAR(20) NOT NULL DEFAULT 'disponible',
    created_at DATETIME NULL,
    updated_at DATETIME NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS emprunts (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    livre_id INT UNSIGNED NOT NULL,
    emprunteur VARCHAR(255) NOT NULL,
    date_emprunt DATE NOT NULL,
    date_retour DATE NULL,
    created_at DATETIME NULL,
    updated_at DATETIME NULL,
    INDEX idx_emprunts_livre_id (livre_id),
    CONSTRAINT fk_emprunts_livres FOREIGN KEY (livre_id)
        REFERENCES livres(id)
        ON DELETE CASCADE
        ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
