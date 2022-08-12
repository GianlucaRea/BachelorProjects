use ecotolldatabase;

#veicoli
insert into veicolo (targa, modello, marca, peso, n°assi, anno, altezza) value ("FR345AY", "barchetta", "FIAT", 1400, 2, '2006-00-00', 1.22);
insert into veicolo value ("TR153XP", "seicento", "FIAT",  810, 2, 3, '2010-00-00', 1.42);

#admin
insert into amministratore (nome, cognome) value ("Daniele", "Fossemò");
insert into amministratore (nome, cognome) value ("Gianluca", "Rea");
insert into amministratore (nome, cognome) value ("Davide", "Ricci");

#autostrade
insert into autostrada value ("A14");
insert into autostrada value ("A55");

#caselli A14
insert into casello value ("Atina", 300, "A14");
insert into casello value ("Sora", 317, "A14");
insert into casello value ("Neuto", 340, "A14");

#caselli A55
insert into casello value ("provuno",  257, "A55");
insert into casello value ("provue",  223, "A55");
insert into casello value ("prové",  260, "A55");

#tariffe A14
insert into tariffa value (1, 1.5, "A14");
insert into tariffa value (2, 2.5, "A14");
insert into tariffa value (3, 3.5, "A14");
insert into tariffa value (4, 4.5, "A14");
insert into tariffa value (5, 5.5, "A14");

#tariffe A55
insert into tariffa value (1, 1.5, "A55");
insert into tariffa value (2, 2.0, "A55");
insert into tariffa value (3, 3.5, "A55");
insert into tariffa value (4, 4.75, "A55");
insert into tariffa value (5, 5.25, "A55");

insert into percorso value ("P1","A14", "Atina", "Sora");
insert into percorso value ("P2","A55", "provuno", "provue");