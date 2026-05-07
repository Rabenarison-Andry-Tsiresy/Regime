# To-Do List (TP Bibliotheque)

## 1) Setup et environnement
- [x] Configurer le fichier .env


## 2) Base de donnees

- [x] Creer la table categories
- [x] Creer la table livres
- [x] Creer la table emprunts
- [x] Ajouter les categories par defaut en base


## 3) Routage

- [x] Route liste des livres
- [x] Route detail livre avec id
- [x] Routes ajout livre (GET/POST)
- [x] Route suppression livre (POST)
- [x] Routes pret et retour (POST)


## 4) Modeles et validation

- [x] LivreModel avec regles de validation
- [x] Validation metier annee non future
- [x] Recherche par titre + categorie
- [x] Pagination 10 livres/page
- [x] EmpruntModel avec dernier emprunt
- [x] CategorieModel (categories en base)


## 5) Controleurs

- [x] Controleur Livres (index, show, create, store, delete)
- [x] Controleur Emprunts (pret, retour)
- [x] Gestion des redirections + flash messages


## 6) Vues et UI

- [x] Layout principal avec sections
- [x] Vue catalogue
- [x] Vue detail
- [x] Vue formulaire ajout
- [x] Champs harmonises (input/select/textarea)
- [x] Statuts visuels (disponible/prete)


## 7) Securite

- [x] CSRF active globalement
- [x] Jeton CSRF dans tous les formulaires POST
- [x] echappement esc() dans les vues


## 8) Tests fonctionnels (a faire)

- [x] Ajouter 1 livre valide
- [x] Ajouter un livre avec ISBN deja existant
- [x] Ajouter un livre avec annee future
- [x] Ajouter un livre avec image > 2 Mo
- [x] Verifier pagination a partir de 11 livres
- [x] Preter un livre disponible
- [x] Retourner un livre prete
- [x] Supprimer un livre

