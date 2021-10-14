drop table if exists notification;
drop table if exists notification_type;
drop table if exists proposal;
drop table if exists task;
drop table if exists yard;
drop table if exists availability;
drop table if exists user;


-- USER
-- Décrit un utilisateur, client ou entreprise
create table user
(
    id_user       bigint unsigned primary key auto_increment,
    name          varchar(255)                                       not null,
    description   varchar(255),
    type          enum ('project_owner', 'enterprise', 'supervisor') not null,
    email         varchar(255) unique                                not null,
    phone         varchar(255),
    password      varchar(255)                                       not null,
    token         varchar(255) unique,
    token_gentime datetime,
    id_enterprise bigint unsigned,
    constraint user_enterprise foreign key (id_enterprise) references user (id_user) on delete cascade
);


-- AVAILABILITY
-- Disponibilités d'une entreprise
create table availability
(
    id_availability bigint unsigned primary key auto_increment,
    start           datetime        not null,
    end             datetime        not null,
    id_user         bigint unsigned not null,
    constraint availability_user foreign key (id_user) references user (id_user) on delete cascade
);


-- YARD
-- Défini un chantier
create table yard
(
    id_yard          bigint unsigned primary key auto_increment,
    name             varchar(255)    not null,
    description      varchar(255),
    deadline         date,
    archived         bool,
    id_project_owner bigint unsigned not null,
    id_supervisor    bigint unsigned,
    constraint yard_project_owner foreign key (id_project_owner) references user (id_user) on delete cascade,
    constraint yard_supervisor foreign key (id_supervisor) references user (id_user) on delete set null
);


-- TASK
-- Décrit une mission / tache d'un chantier
create table task
(
    id_task              bigint unsigned primary key auto_increment,
    title                varchar(255)                   not null,
    description          varchar(255),
    state                enum ('todo', 'doing', 'done') not null default 'todo',
    estimated_time       time,
    time_spent           time,
    start_planned_date   date,
    end_planned_date     date,
    supervisor_validated bool,
    executor_validated   bool,
    id_executor          bigint unsigned,
    id_yard              bigint unsigned                not null,
    constraint task_executor foreign key (id_executor) references user (id_user) on delete set null,
    constraint task_yard foreign key (id_yard) references yard (id_yard) on delete cascade
);


-- PROPOSAL
-- Proposition de chantier pour une entreprise
create table proposal
(
    id_proposal  bigint unsigned primary key auto_increment,
    id_yard      bigint unsigned not null,
    id_recipient bigint unsigned not null,
    accepted     bool,
    constraint proposal_yard foreign key (id_yard) references yard (id_yard) on delete cascade,
    constraint proposal_recipient foreign key (id_recipient) references user (id_user) on delete cascade
);


-- NOTIFICATION_TYPE
create table notification_type
(
    id_notification_type bigint unsigned primary key auto_increment,
    title                varchar(255) not null,
    template             varchar(255) not null
);

insert into notification_type(id_notification_type, title, template)
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
    parameters           json            not null,
    id_recipient         bigint unsigned not null,
    id_notification_type bigint unsigned not null,
    constraint notification_recipient foreign key (id_recipient) references user (id_user) on delete cascade,
    constraint notification_type foreign key (id_notification_type) references notification_type (id_notification_type) on delete cascade
);
