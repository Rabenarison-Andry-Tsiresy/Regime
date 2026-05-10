create database regime;
use regime;

create table sexes (
    id int unsigned primary key auto_increment,
    label varchar(20) not null,
    created_at datetime null,
    updated_at datetime null,
    unique key uq_sexes_label (label)
) engine=InnoDB default charset=utf8mb4;

create table objectifs (
    id int unsigned primary key auto_increment,
    code varchar(30) not null,
    label varchar(100) not null,
    created_at datetime null,
    updated_at datetime null,
    unique key uq_objectifs_code (code)
) engine=InnoDB default charset=utf8mb4;

create table utilisateurs (
    id int unsigned primary key auto_increment,
    nom varchar(120) not null,
    email varchar(190) not null,
    password_hash varchar(255) not null,
    age int null,
    sexe_id int unsigned null,
    role varchar(20) not null default 'user',
    premium tinyint(1) not null default 0,
    created_at datetime null,
    updated_at datetime null,
    unique key uq_utilisateurs_email (email),
    key idx_utilisateurs_sexe (sexe_id),
    constraint fk_utilisateurs_sexe foreign key (sexe_id) references sexes(id) on delete set null on update cascade
) engine=InnoDB default charset=utf8mb4;

create table profil_sante (
    id int unsigned primary key auto_increment,
    user_id int unsigned not null,
    taille_cm decimal(5,2) not null,
    poids_kg decimal(5,2) not null,
    objectif_id int unsigned null,
    imc decimal(5,2) null,
    created_at datetime null,
    updated_at datetime null,
    unique key uq_profil_sante_user (user_id),
    key idx_profil_sante_objectif (objectif_id),
    constraint fk_profil_sante_user foreign key (user_id) references utilisateurs(id) on delete cascade on update cascade,
    constraint fk_profil_sante_objectif foreign key (objectif_id) references objectifs(id) on delete set null on update cascade
) engine=InnoDB default charset=utf8mb4;

create table regimes (
    id int unsigned primary key auto_increment,
    nom varchar(120) not null,
    description text null,
    duree_jours int not null,
    prix decimal(10,2) not null,
    variation_poids decimal(5,2) null,
    pourcentage_viande tinyint not null,
    pourcentage_poisson tinyint not null,
    pourcentage_volaille tinyint not null,
    objectif_id int unsigned null,
    created_at datetime null,
    updated_at datetime null,
    key idx_regimes_objectif (objectif_id),
    constraint fk_regimes_objectif foreign key (objectif_id) references objectifs(id) on delete set null on update cascade
) engine=InnoDB default charset=utf8mb4;

create table activites_sportives (
    id int unsigned primary key auto_increment,
    nom varchar(120) not null,
    description text null,
    objectif_id int unsigned null,
    intensite varchar(20) null,
    created_at datetime null,
    updated_at datetime null,
    key idx_activites_objectif (objectif_id),
    constraint fk_activites_objectif foreign key (objectif_id) references objectifs(id) on delete set null on update cascade
) engine=InnoDB default charset=utf8mb4;

create table portefeuilles (
    id int unsigned primary key auto_increment,
    user_id int unsigned not null,
    solde decimal(10,2) not null default 0,
    created_at datetime null,
    updated_at datetime null,
    unique key uq_portefeuilles_user (user_id),
    constraint fk_portefeuilles_user foreign key (user_id) references utilisateurs(id) on delete cascade on update cascade
) engine=InnoDB default charset=utf8mb4;

create table codes_rechargement (
    id int unsigned primary key auto_increment,
    code varchar(50) not null,
    valeur decimal(10,2) not null,
    date_expiration datetime null,
    actif tinyint(1) not null default 1,
    used_by int unsigned null,
    used_at datetime null,
    created_at datetime null,
    updated_at datetime null,
    unique key uq_codes_rechargement_code (code),
    key idx_codes_rechargement_used_by (used_by),
    constraint fk_codes_rechargement_user foreign key (used_by) references utilisateurs(id) on delete set null on update cascade
) engine=InnoDB default charset=utf8mb4;

create table abonnements_gold (
    id int unsigned primary key auto_increment,
    user_id int unsigned not null,
    date_debut date not null,
    date_fin date null,
    prix decimal(10,2) not null,
    actif tinyint(1) not null default 1,
    created_at datetime null,
    updated_at datetime null,
    key idx_abonnements_gold_user (user_id),
    constraint fk_abonnements_gold_user foreign key (user_id) references utilisateurs(id) on delete cascade on update cascade
) engine=InnoDB default charset=utf8mb4;

create table historique_regimes (
    id int unsigned primary key auto_increment,
    user_id int unsigned not null,
    regime_id int unsigned not null,
    date_debut date not null,
    date_fin date not null,
    prix_applique decimal(10,2) not null,
    remise_appliquee decimal(10,2) not null default 0,
    created_at datetime null,
    updated_at datetime null,
    key idx_historique_regimes_user (user_id),
    key idx_historique_regimes_regime (regime_id),
    constraint fk_historique_regimes_user foreign key (user_id) references utilisateurs(id) on delete cascade on update cascade,
    constraint fk_historique_regimes_regime foreign key (regime_id) references regimes(id) on delete cascade on update cascade
) engine=InnoDB default charset=utf8mb4;

create table paiements (
    id int unsigned primary key auto_increment,
    user_id int unsigned not null,
    type varchar(20) not null,
    montant decimal(10,2) not null,
    reference varchar(100) null,
    created_at datetime null,
    key idx_paiements_user (user_id),
    constraint fk_paiements_user foreign key (user_id) references utilisateurs(id) on delete cascade on update cascade
) engine=InnoDB default charset=utf8mb4;

create table parametres (
    id int unsigned primary key auto_increment,
    cle varchar(50) not null,
    valeur varchar(255) not null,
    created_at datetime null,
    updated_at datetime null,
    unique key uq_parametres_cle (cle)
) engine=InnoDB default charset=utf8mb4;

insert into sexes (label, created_at, updated_at) values
('Homme', now(), now()),
('Femme', now(), now()),
('Autre', now(), now());

insert into objectifs (code, label, created_at, updated_at) values
('gain', 'Augmenter le poids', now(), now()),
('loss', 'Reduire le poids', now(), now()),
('ideal', 'Atteindre IMC ideal', now(), now());

insert into parametres (cle, valeur, created_at, updated_at) values
('imc_underweight_max', '18.5', now(), now()),
('imc_normal_max', '24.9', now(), now()),
('imc_overweight_max', '29.9', now(), now()),
('gold_price', '50', now(), now()),
('gold_discount_percent', '15', now(), now());

