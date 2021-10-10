drop table if exists notification;
drop table if exists type_notification;
drop table if exists proposition;
drop table if exists mission;
drop table if exists chantier;
drop table if exists disponibilite;
drop table if exists user;


-- USER
-- Décrit un utilisateur, client ou entreprise
create table user
(
    id_user       int unsigned primary key auto_increment,
    nom           text                       not null,
    description   text,
    type          enum ('moa', 'ets', 'cdt') not null,
    mail          varchar(100) unique        not null,
    telephone     text,
    password      text                       not null,
    token         text,
    token_gentime datetime,
    id_entreprise int unsigned,
    constraint user_entreprise foreign key (id_entreprise) references user (id_user) on delete cascade
);


-- DISPONIBILITE
-- Disponibilités d'une entreprise
create table disponibilite
(
    id_disponibilite int unsigned primary key auto_increment,
    start            datetime     not null,
    end              datetime     not null,
    id_user          int unsigned not null,
    constraint disponibilite_user foreign key (id_user) references user (id_user) on delete cascade,
    constraint date_range check ( start < end )
);


-- CHANTIER
-- Défini un chantier
create table chantier
(
    id_chantier int unsigned primary key auto_increment,
    nom         text,
    description text,
    deadline    datetime,
    archiver    bool,
    id_moa      int unsigned not null,
    id_cdt      int unsigned,
    constraint chantier_moa foreign key (id_moa) references user (id_user) on delete cascade,
    constraint chantier_cdt foreign key (id_cdt) references user (id_user) on delete set null
);


-- MISSION
-- Décrit une mission / tache d'un chantier
create table mission
(
    id_mission        int unsigned primary key auto_increment,
    titre             text                           not null,
    description       text,
    etat              enum ('todo', 'doing', 'done') not null default 'todo',
    temps_estime      time,
    temps_passe       time,
    debut_date_prevu  date,
    fin_date_prevu    date,
    valider_cdt       bool,
    valider_executant bool,
    id_executant      int unsigned,
    id_chantier       int unsigned                   not null,
    constraint mission_executant foreign key (id_executant) references user (id_user) on delete set null,
    constraint mission_chantier foreign key (id_chantier) references chantier (id_chantier) on delete cascade,
    constraint period_prevu check ( debut_date_prevu < fin_date_prevu )
);


-- PROPOSITION
-- Proposition de chantier pour une entreprise
create table proposition
(
    id_proposition  int unsigned primary key auto_increment,
    id_chantier     int unsigned,
    id_destinataire int unsigned,
    accepter        bool,
    constraint proposition_chantier foreign key (id_chantier) references chantier (id_chantier) on delete cascade,
    constraint proposition_destinataire foreign key (id_destinataire) references user (id_user) on delete cascade
);


-- TYPE_NOTIFICATION
create table type_notification
(
    id_type_notification int unsigned primary key auto_increment,
    titre                text,
    template             text
);

insert into type_notification(id_type_notification, titre, template)
VALUES (1, 'proposition', 'L\'entreprise ${entreprise} vous propose le chantier ${chantier}.'),
       (2, 'proposition_mission',
        'L\'entreprise ${entreprise} vous propose la mission ${mission} sur le chantier ${chantier}.'),
       (3, 'overtime', 'La mission ${mission} à dépassée son temps estimé.');


-- NOTIFICATION
create table notification
(
    id_notification      int unsigned primary key auto_increment,
    creation             datetime,
    is_read              bool,
    id_destinataire      int unsigned not null,
    id_type_notification int unsigned not null,
    constraint notification_destinataire foreign key (id_destinataire) references user (id_user) on delete cascade,
    constraint type_notification foreign key (id_type_notification) references type_notification (id_type_notification) on delete cascade
);
