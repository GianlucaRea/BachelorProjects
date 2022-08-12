# noinspection SqlNoDataSourceInspectionForFile

DROP DATABASE IF exists pollweb;
CREATE DATABASE pollweb;
USE pollweb;

DROP TABLE IF EXISTS `Compilazione`;
DROP TABLE IF EXISTS `Domanda`;
DROP TABLE IF EXISTS `Sondaggio`;
DROP TABLE IF EXISTS `Utente`;
DROP TABLE IF EXISTS `Ruolo`;
DROP TABLE IF EXISTS `CompilazioneDomanda`;

CREATE TABLE Ruolo(
id INT auto_increment PRIMARY KEY,
nome_ruolo VARCHAR(255) NOT NULL
);

CREATE TABLE Utente (
id BIGINT auto_increment NOT NULL PRIMARY KEY,
email VARCHAR(255)NOT NULL,
nome VARCHAR(255) NOT NULL,
cognome VARCHAR(255),
ruolo_id INT NOT NULL,
password VARCHAR(255) NOT NULL,
FOREIGN KEY (ruolo_id) REFERENCES Ruolo(id) on update cascade on delete cascade

);


CREATE TABLE Sondaggio(
id BIGINT auto_increment NOT NULL PRIMARY KEY,
utente_id BIGINT NOT NULL,
titolo VARCHAR(255) NOT NULL,
testoiniziale LONGTEXT NOT NULL,
testofinale LONGTEXT NOT NULL,
stato INT default 0, /* 0=non attivo, 1=attivo, 2=chiuso */
visibilita INT default 1, /* 1=pubblico, 2=privato */
created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
FOREIGN KEY (utente_id) REFERENCES Utente(id) on update cascade on delete cascade
);

CREATE TABLE Domanda(
id BIGINT auto_increment PRIMARY KEY,
sondaggio_id BIGINT NOT NULL,
testo VARCHAR(255) NOT NULL,
nota VARCHAR(255),
obbligo BOOLEAN default true, /* togliere default a obbligo , ordine tipologia*/
ordine INT NOT NULL default 0, 
tipologia VARCHAR(255) NOT NULL, /*testo breve, testo lungo, numero, data, scelta singolo, scelta multipla*/
vincoli VARCHAR(255),
FOREIGN KEY (sondaggio_id) REFERENCES Sondaggio(id) on update cascade on delete cascade
);

CREATE TABLE Compilazione (
id BIGINT auto_increment PRIMARY KEY,
sondaggio_id BIGINT NOT NULL,
utente_id BIGINT,
FOREIGN KEY (sondaggio_id) REFERENCES Sondaggio(id) on update cascade on delete cascade,
FOREIGN KEY(utente_id) REFERENCES Utente(id) on update cascade on delete cascade,
UNIQUE(sondaggio_id, utente_id)
);

CREATE TABLE CompilazioneDomanda (
compilazione_id BIGINT NOT NULL,
domanda_id BIGINT NOT NULL,
risposta JSON,
PRIMARY KEY(compilazione_id, domanda_id),
FOREIGN KEY(compilazione_id) REFERENCES Compilazione(id) on update cascade on delete cascade,
FOREIGN KEY(domanda_id) REFERENCES Domanda(id) on update cascade on delete cascade
);

INSERT INTO `pollweb`.`ruolo`(`id`,`nome_ruolo`)VALUES('1','utente');
INSERT INTO `pollweb`.`ruolo`(`id`,`nome_ruolo`)VALUES('2','responsabile');
INSERT INTO `pollweb`.`ruolo`(`id`,`nome_ruolo`)VALUES('3','amministratore');



