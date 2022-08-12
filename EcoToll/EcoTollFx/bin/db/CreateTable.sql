create database ecoTollDatabase;

use ecoTollDatabase;

create table veicolo(
	targa varchar(31) not null primary key,
    modello varchar(31) not null,
    marca varchar(31) not null,
    peso integer not null,
    n°assi integer not null,
    classeEuro integer,
    anno date not null,
    altezza double not null
    );
    
alter table veicolo add constraint assiOk check (n°assi not in (1));

create table autostrada(
	nome varchar(31) primary key
    );
    
create table amministratore(
    nome varchar(31),
    cognome varchar(31)
    );
    
create table tariffa(
	classeVeicolo integer not null,
	valore integer not null,
    nomeAutostrada varchar(31),
    foreign key (nomeAutostrada) references autostrada(nome) on update cascade on delete set null
    );
    
create table casello(
	nome varchar(31) primary key,
    kilometro integer not null,
	nomeAutostrada varchar(31),
    foreign key (nomeAutostrada) references autostrada(nome) on update cascade on delete set null
    );
    
create table percorso (
	codicePercorso varchar(31) primary key,
	nomeAutostrada varchar(31),
    caselloPartenza varchar(31),
    caselloArrivo varchar(31),
	foreign key (nomeAutostrada) references autostrada(nome) on update cascade on delete set null,
    foreign key (caselloPartenza) references casello(nome) on update cascade on delete set null,
    foreign key (caselloArrivo) references casello(nome) on update cascade on delete set null
    );
