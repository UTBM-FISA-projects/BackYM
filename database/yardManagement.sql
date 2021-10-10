drop table if exists notification;
drop table if exists type_notification;
drop table if exists proposition;
drop table if exists mission;
drop table if exists chantier;
drop table if exists disponibilite;
drop table if exists utilisateur;


-- UTILISATEUR
-- Décrit un utilisateur, client ou entreprise
create table utilisateur
(
    id_utilisateur bigint unsigned primary key auto_increment,
    nom            varchar(255)               not null,
    description    varchar(255),
    type           enum ('moa', 'ets', 'cdt') not null,
    mail           varchar(255) unique        not null,
    telephone      varchar(255),
    password       varchar(255)               not null,
    token          varchar(255),
    token_gentime  datetime,
    id_entreprise  bigint unsigned,
    constraint utilisateur_entreprise foreign key (id_entreprise) references utilisateur (id_utilisateur) on delete cascade
);


-- DISPONIBILITE
-- Disponibilités d'une entreprise
create table disponibilite
(
    id_disponibilite bigint unsigned primary key auto_increment,
    start            datetime        not null,
    end              datetime        not null,
    id_utilisateur   bigint unsigned not null,
    constraint disponibilite_utilisateur foreign key (id_utilisateur) references utilisateur (id_utilisateur) on delete cascade
);


-- CHANTIER
-- Défini un chantier
create table chantier
(
    id_chantier bigint unsigned primary key auto_increment,
    nom         varchar(255)    not null,
    description varchar(255),
    deadline    datetime,
    archiver    bool,
    id_moa      bigint unsigned not null,
    id_cdt      bigint unsigned,
    constraint chantier_moa foreign key (id_moa) references utilisateur (id_utilisateur) on delete cascade,
    constraint chantier_cdt foreign key (id_cdt) references utilisateur (id_utilisateur) on delete set null
);


-- MISSION
-- Décrit une mission / tache d'un chantier
create table mission
(
    id_mission        bigint unsigned primary key auto_increment,
    titre             varchar(255)                   not null,
    description       varchar(255),
    etat              enum ('todo', 'doing', 'done') not null default 'todo',
    temps_estime      time,
    temps_passe       time,
    debut_date_prevu  date,
    fin_date_prevu    date,
    valider_cdt       bool,
    valider_executant bool,
    id_executant      bigint unsigned,
    id_chantier       bigint unsigned                not null,
    constraint mission_executant foreign key (id_executant) references utilisateur (id_utilisateur) on delete set null,
    constraint mission_chantier foreign key (id_chantier) references chantier (id_chantier) on delete cascade
);


-- PROPOSITION
-- Proposition de chantier pour une entreprise
create table proposition
(
    id_proposition  bigint unsigned primary key auto_increment,
    id_chantier     bigint unsigned not null,
    id_destinataire bigint unsigned not null,
    accepter        bool,
    constraint proposition_chantier foreign key (id_chantier) references chantier (id_chantier) on delete cascade,
    constraint proposition_destinataire foreign key (id_destinataire) references utilisateur (id_utilisateur) on delete cascade
);


-- TYPE_NOTIFICATION
create table type_notification
(
    id_type_notification bigint unsigned primary key auto_increment,
    titre                varchar(255) not null,
    template             varchar(255) not null
);

insert into type_notification(id_type_notification, titre, template)
VALUES (1, 'proposition', 'L\'entreprise ${entreprise} vous propose le chantier ${chantier}.'),
       (2, 'proposition_mission',
        'L\'entreprise ${entreprise} vous propose la mission ${mission} sur le chantier ${chantier}.'),
       (3, 'overtime', 'La mission ${mission} à dépassée son temps estimé.');


-- NOTIFICATION
create table notification
(
    id_notification      bigint unsigned primary key auto_increment,
    creation             datetime        not null default CURRENT_TIMESTAMP,
    is_read              bool,
    id_destinataire      bigint unsigned not null,
    id_type_notification bigint unsigned not null,
    constraint notification_destinataire foreign key (id_destinataire) references utilisateur (id_utilisateur) on delete cascade,
    constraint type_notification foreign key (id_type_notification) references type_notification (id_type_notification) on delete cascade
);
