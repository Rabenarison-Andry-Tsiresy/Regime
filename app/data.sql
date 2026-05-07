create database regime;
use regime;

create table regime_user(
    id int primary key auto_increment,
    nom varchar(20),
    age int,
    email varchar(50),
    poids decimal(5,2),
    id_sexe int,
    taille decimal(5,2),
    password varchar(20),
    premium boolean default false
);

create table regime_sexe(
    id int primary key auto_increment,
    sexe varchar(10)
);
create table regime_aliment(
    id int primary key auto_increment,
    nom varchar(20),
    calories int
);
create table regime_plan(
    id int primary key auto_increment,
    nom varchar(20),
    description text
);

create table regime_plan_user(
    id int primary key auto_increment,
    id_user int,
    id_plan int,
    date_debut date,
    date_fin date,
    foreign key (id_user) references regime_user(id),
    foreign key (id_plan) references regime_plan(id)
);

create table regime_token(
    id int primary key auto_increment,
    token varchar(255),
    valeur decimal(10,2),
    date_expiration datetime
);
create table regime_solde(
    id int primary key auto_increment,
    id_user int,
    montant decimal(10,2),
    foreign key (id_user) references regime_user(id)
);

