delete from livres;/*  */

-- Insertion des catégories
INSERT INTO categories (nom, created_at, updated_at) VALUES
('Roman', NOW(), NOW()),
('Science-Fiction', NOW(), NOW()),
('Policier', NOW(), NOW()),
('Fantasy', NOW(), NOW()),
('Biographie', NOW(), NOW()),
('Sciences', NOW(), NOW());

-- Insertion des livres
INSERT INTO livres (titre, auteur, isbn, annee_publication, categorie, resume, couverture, statut, created_at, updated_at) VALUES
('Le Petit Prince', 'Antoine de Saint-Exupéry', '9782070612758', 1943, 'Roman', 'Un aviateur rencontre un petit prince venu d''une autre planète.', '1cJ54x7vS1vb3AUMqA8U7VV0uMlE45Nrd_9d7abe0c-27a6-4b9d-82fc-5559c747255d.webp', 'disponible', NOW(), NOW()),

('1984', 'George Orwell', '9780451524935', 1949, 'Science-Fiction', 'Une société totalitaire où la liberté individuelle est bannie.', '_93815906_gettyimages-632691254.jpg.webp', 'disponible', NOW(), NOW()),

('Les Misérables', 'Victor Hugo', '9782253096337', 1862, 'Roman', 'L''histoire de Jean Valjean dans la France du XIXe siècle.', '4E7D5B8E-41A1-4065-91D6EDEC7386CA67.avif', 'emprunté', NOW(), NOW()),

('Le Nom de la Rose', 'Umberto Eco', '9782253038726', 1980, 'Policier', 'Une enquête criminelle dans une abbaye médiévale.', '1cJ54x7vS1vb3AUMqA8U7VV0uMlE45Nrd_9d7abe0c-27a6-4b9d-82fc-5559c747255d.webp', 'disponible', NOW(), NOW()),

('Harry Potter à l''école des sorciers', 'J.K. Rowling', '9782070584628', 1997, 'Fantasy', 'Un jeune sorcier découvre le monde magique.', '4E7D5B8E-41A1-4065-91D6EDEC7386CA67.avif', 'disponible', NOW(), NOW()),

('Dune', 'Frank Herbert', '9782266288606', 1965, 'Science-Fiction', 'Sur la planète désertique Arrakis, le contrôle de l''épice.', '_93815906_gettyimages-632691254.jpg.webp', 'disponible', NOW(), NOW()),

('Le Parfum', 'Patrick Süskind', '9782253006817', 1985, 'Roman', 'L''histoire d''un tueur obsédé par les odeurs.', '1776692310_e5bd197f960600e7f4f8.png', 'disponible', NOW(), NOW()),

('Le Trône de Fer - L''épée de feu', 'George R.R. Martin', '9782290337035', 1998, 'Fantasy', 'Les sept royaumes sont en guerre pour le trône.', '1cJ54x7vS1vb3AUMqA8U7VV0uMlE45Nrd_9d7abe0c-27a6-4b9d-82fc-5559c747255d.webp', 'emprunté', NOW(), NOW()),

('L''Étranger', 'Albert Camus', '9782070360024', 1942, 'Roman', 'Meursault, un homme détaché des conventions sociales.', '4E7D5B8E-41A1-4065-91D6EDEC7386CA67.avif', 'disponible', NOW(), NOW()),

('Steve Jobs', 'Walter Isaacson', '9782266207171', 2011, 'Biographie', 'La biographie officielle du fondateur d''Apple.', '_93815906_gettyimages-632691254.jpg.webp', 'disponible', NOW(), NOW()),

('Une brève histoire du temps', 'Stephen Hawking', '9782081412150', 1988, 'Sciences', 'L''univers expliqué par le célèbre astrophysicien.', '1776692310_e5bd197f960600e7f4f8.png', 'disponible', NOW(), NOW()),

('Fondation', 'Isaac Asimov', '9782070360536', 1951, 'Science-Fiction', 'La chute d''un empire galactique et le projet secret de Hari Seldon.', 'livre1.jpg', 'disponible', NOW(), NOW()),

('Da Vinci Code', 'Dan Brown', '9782709628887', 2003, 'Policier', 'Une course contre la montre entre symboles, secrets et sociétés occultes.', 'livre2.jpg', 'disponible', NOW(), NOW()),

('Sapiens', 'Yuval Noah Harari', '9782226257017', 2015, 'Sciences', 'Une histoire de l''humanité des chasseurs-cueilleurs à l''ère moderne.', 'livre3.jpg', 'disponible', NOW(), NOW()),

('Le Hobbit', 'J.R.R. Tolkien', '9782266285414', 1937, 'Fantasy', 'Bilbo Sacquet part à l''aventure pour reprendre un royaume perdu.', 'livre4.jpg', 'disponible', NOW(), NOW()),

('L''Alchimiste', 'Paulo Coelho', '9782290333631', 1988, 'Roman', 'Le voyage initiatique d''un jeune berger à la recherche de sa légende personnelle.', 'livre5.jpg', 'disponible', NOW(), NOW()),

('Marie Curie', 'Eve Curie', '9782070416981', 1937, 'Biographie', 'Le portrait d''une scientifique pionnière et double prix Nobel.', 'livre6.jpg', 'disponible', NOW(), NOW());

-- Insertion d'un emprunt d'exemple (optionnel)
INSERT INTO emprunts (livre_id, emprunteur, date_emprunt, date_retour, created_at, updated_at) VALUES
(3, 'Jean Dupont', '2026-04-15', NULL, NOW(), NOW()),
(8, 'Marie Martin', '2026-04-10', NULL, NOW(), NOW());