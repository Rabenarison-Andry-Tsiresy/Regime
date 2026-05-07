# TP CodeIgniter 4 - Gestion de Bibliotheque

Ce document explique l'installation et l'utilisation de l'application de gestion de bibliotheque realisee avec CodeIgniter 4.

## 1. Prerequis

- PHP 8.1+
- Composer
- MySQL/MariaDB
- Extension PHP `mysqli`

## 2. Base de donnees MySQL

Deux options sont possibles.

### Option A - Script SQL direct

1. Importer le script SQL:

```bash
mysql -u root -p < database/bibliotheque.sql
```

2. Cela cree:
- la base `bibliotheque`
- la table `categories`
- la table `livres`
- la table `emprunts`

### Option B - Migrations CodeIgniter

1. Creer la base vide:

```sql
CREATE DATABASE bibliotheque CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

2. Lancer les migrations:

```bash
php spark migrate
```

## 3. Configuration de la connexion

Configurer la connexion MySQL dans le fichier `.env` (copie de `env`):

```bash
cp env .env
```

Puis modifier:

```ini
database.default.hostname = localhost
database.default.database = bibliotheque
database.default.username = root
database.default.password =
database.default.DBDriver = MySQLi
database.default.port = 3306
```

## 4. Lancer l'application

Depuis la racine du projet:

```bash
composer install
php spark serve
```

Application accessible sur: `http://localhost:8001`

## 5. Routes implementees

- `GET /` : liste des livres (catalogue + pagination)
- `GET /livres` : liste des livres
- `GET /livres/{id}` : fiche detaillee d'un livre
- `GET /livres/create` : formulaire d'ajout
- `POST /livres/store` : enregistrement d'un livre
- `POST /livres/delete/{id}` : suppression d'un livre
- `POST /livres/pret/{id}` : pret d'un livre
- `POST /livres/retour/{id}` : retour d'un livre

## 6. Justification des methodes HTTP

- `GET` est utilise pour la lecture (liste, detail, formulaire).
- `POST` est utilise pour les modifications de donnees (ajout, suppression, pret, retour) afin de respecter la semantique HTTP et d'eviter des actions destructives via simple lien.

## 7. Fonctionnalites couvertes (TP)

- Routage simple/complexe avec parametres
- Modeles `LivreModel` et `EmpruntModel`
- Modele `CategorieModel` (categories en base)
- Validation modele + messages FR
- Validation metier (annee non future)
- Upload couverture (jpeg/png/webp, max 2 Mo)
- Protection CSRF active globalement
- Layout + sections (templating CI4)
- `esc()` dans toutes les vues
- Recherche (titre + categorie)
- Pagination (10 livres/page)
- CRUD + gestion pret/retour

## 8. Structure des fichiers ajoutes/modifies

- `app/Config/Routes.php`
- `app/Config/Filters.php`
- `app/Controllers/BaseController.php`
- `app/Controllers/Livres.php`
- `app/Controllers/Emprunts.php`
- `app/Models/LivreModel.php`
- `app/Models/EmpruntModel.php`
- `app/Models/CategorieModel.php`
- `app/Database/Migrations/2026-04-20-000001_CreateLivresTable.php`
- `app/Database/Migrations/2026-04-20-000002_CreateEmpruntsTable.php`
- `app/Database/Migrations/2026-04-20-000003_CreateCategoriesTable.php`
- `app/Views/layouts/main.php`
- `app/Views/livres/index.php`
- `app/Views/livres/show.php`
- `app/Views/livres/create.php`
- `database/bibliotheque.sql`

## 9. Verifications conseillees

1. Ajouter au moins 11 livres pour verifier la pagination.
2. Tester upload invalide (PDF ou > 2 Mo) pour valider les erreurs.
3. Tester flux complet: disponible -> prete -> retournee (statut de nouveau disponible).
4. Verifier que tous les formulaires POST contiennent bien le jeton CSRF.
