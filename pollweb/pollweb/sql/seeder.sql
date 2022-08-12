INSERT INTO `pollweb`.`Utente`(`email`,`nome`,`cognome`,`ruolo_id`,`password`)VALUES('amministratore@email.it','amministratoreNome','amministratoreCognome','3','2IehbF5176j9p7zbdMdmEod7kIi+piia');
INSERT INTO `pollweb`.`Utente`(`email`,`nome`,`cognome`,`ruolo_id`,`password`)VALUES('responsabile@email.it','responsabileNome','responsabileCognome','2','password');
INSERT INTO `pollweb`.`Utente`(`email`,`nome`,`cognome`,`ruolo_id`,`password`)VALUES('utente@email.it','utenteN','utenteC','1','2IehbF5176j9p7zbdMdmEod7kIi+piia');
INSERT INTO `pollweb`.`Utente`(`email`,`nome`,`cognome`,`ruolo_id`,`password`)VALUES('utente1@email.it','utente1N','utente1C','1','2IehbF5176j9p7zbdMdmEod7kIi+piia');
INSERT INTO `pollweb`.`Utente`(`email`,`nome`,`cognome`,`ruolo_id`,`password`)VALUES('utente2@email.it','utente2N','utente2C','1','2IehbF5176j9p7zbdMdmEod7kIi+piia');
INSERT INTO `pollweb`.`Utente`(`email`,`nome`,`cognome`,`ruolo_id`,`password`)VALUES('utente3@email.it','utente3N','utente3C','1','2IehbF5176j9p7zbdMdmEod7kIi+piia');


INSERT INTO `pollweb`.`Sondaggio`(`utente_id`, `titolo`, `testoiniziale`, `testofinale`, `stato`, `visibilita`)
VALUES(1, 'titoloSondaggio1', 'testoIniziale1', 'testoFinale1', 0, 1);

INSERT INTO `pollweb`.`Sondaggio`(`utente_id`, `titolo`, `testoiniziale`, `testofinale`, `stato`, `visibilita`)
VALUES(1, 'titoloSondaggioPubblico2', 'testoInizialePubblico2', 'testoFinalePubblico2', 0, 1);

INSERT INTO `pollweb`.`Sondaggio`(`utente_id`, `titolo`, `testoiniziale`, `testofinale`, `stato`, `visibilita`)
VALUES(1, 'titoloSondaggioPrivato3', 'testoInizialePrivato3', 'testoFinalePrivato3', 0, 2);

INSERT INTO `pollweb`.`Sondaggio`(`utente_id`, `titolo`, `testoiniziale`, `testofinale`, `stato`, `visibilita`)
VALUES(1, 'Il mio titolo del sondaggio � questo', 'testoIniziale', 'testoFinale', 1, 1);

INSERT INTO `pollweb`.`Domanda`(`sondaggio_id`, `testo`, `nota`, `obbligo`, `ordine`, `tipologia`, `vincoli`)VALUES
(1, 'testoDomanda1', 'nota1', false, 1,'scelta singola', '{}');

INSERT INTO `pollweb`.`Domanda`(`sondaggio_id`, `testo`, `nota`, `obbligo`, `ordine`, `tipologia`, `vincoli`)VALUES
(3, 'testoDomanda2', 'nota2', false, 2, 'scelta singola', '{}');

INSERT INTO `pollweb`.`Domanda`(`sondaggio_id`, `testo`, `nota`, `obbligo`, `ordine`, `tipologia`, `vincoli`)VALUES
(1, 'testoDomanda3', 'nota3', false, 3,'scelta singola', '{}');



INSERT INTO `pollweb`.`Domanda`(`sondaggio_id`, `testo`, `nota`, `obbligo`, `ordine`, `tipologia`, `vincoli`)VALUES
(4, 'Domanda1', 'nota1', true , 1,'testo_breve', '{"max_length":123}');

INSERT INTO `pollweb`.`Domanda`(`sondaggio_id`, `testo`, `nota`, `obbligo`, `ordine`, `tipologia`, `vincoli`)VALUES
(4, 'Domanda2', 'nota2', true , 2, 'numero', '{"min_num":150,"max_num":200}');

INSERT INTO `pollweb`.`Domanda`(`sondaggio_id`, `testo`, `nota`, `obbligo`, `ordine`, `tipologia`, `vincoli`)VALUES
(4, 'Domanda3', 'nota3', true , 3,'scelta_multipla', '{"min_chooses":1,"max_chooses":2,"chooses":["Opzione 1","Opzione 2","Opzione 3","Opzione 4"]}');

INSERT INTO `pollweb`.`Domanda`(`sondaggio_id`, `testo`, `nota`, `obbligo`, `ordine`, `tipologia`, `vincoli`)VALUES
(4, 'Domanda4', 'nota4', false, 4,'scelta_singola', '{"chooses":["Opzione 4","Opzione 5","Opzione6"]}');


INSERT INTO `pollweb`.`Compilazione`(`sondaggio_id`, `utente_id`)VALUES(3, '3');

INSERT INTO `pollweb`.`CompilazioneDomanda`(`compilazione_id`, `domanda_id`, `risposta`)VALUES(1, 2, '{"value": "test"}');