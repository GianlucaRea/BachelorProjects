<#import "/globalTemplate.ftl" as globalTemplate>

<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
<head>
    <title>Riepilogo sondaggio</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <@globalTemplate.style />
</head>
<body class="bg-light">
<@globalTemplate.navbar />
<div class="pt-5 pb-5">
    <div class="container">
        <h1>Nuova domanda</h1>
        <form action="/sondaggi/domande/inserisci?id=${sondaggio.getId()}" method="post">
            <div class=" rowDomanda" id="rowDomanda">
                <div class="domanda mt-3 mb-3 card" id="domanda">
                    <div class="card-body">
                        <h2 id="titoloDomanda">Domanda</h2>
                        <div class="collapse show" id="collapseDomanda">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="testoDomanda">Testo Della domanda</label>
                                        <input id="testoDomanda" type="text" name="testo" onkeyup="cambiaTitoloDomanda()" class="form-control" placeholder="La mia Domanda" required=""></div>
                                    <div class="form-group">
                                        <label for="notaDomanda">Nota</label>
                                        <input id="notaDomanda" type="text" name="nota" class="form-control" placeholder="Una nota" required=""></div>
                                    <div class="form-group">
                                        <label for="tipologiaDomanda">Tipologia</label>
                                        <select id="tipologiaDomanda" name="tipologia" class="form-control" onchange="updateVincoli()" required="">
                                            <option value="null" selected="" disabled="">Seleziona un'opzione...</option>
                                            <option value="testo_breve">Testo breve</option>
                                            <option value="testo_lungo">Testo lungo</option>
                                            <option value="numero">Numero</option>
                                            <option value="data">Data</option>
                                            <option value="scelta_singola">Scelta singola</option>
                                            <option value="scelta_multipla">Scelta multipla</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <input type="checkbox" name="obbligo">
                                        <label>&nbsp;Domanda obbligatoria</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="vincoliSelect" id="vincoliSelect"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <div class="row">
            <div class="col-md-6">
                <a href="/sondaggi/riepilogo?id=${sondaggio.getId()}" class="btn btn-secondary"><i class="fas fa-chevron-left fa-fw"></i> Torna indietro</a>
            </div>
            <div class="col-md-6">
                <div class="float-right">
                    <button type="submit" class="btn btn-success btn-lg">Salva domanda <i class="fad fa-save fa-fw"></i></button>
                </div>
            </div>
        </div>
        </form>
    </div>
</div>
<@globalTemplate.script />

<script>
    function cambiaTitoloDomanda() {
        $("#titoloDomanda").text($("#testoDomanda").val());
    }

    function updateVincoli() {

        let selectValue = $("#tipologiaDomanda").val();
        let vincoliSelect = $("#vincoliSelect");

        switch (selectValue) {
            case "testo_breve":
                vincoliSelect.html('<div class="domanda" id="vincoloDomanda">' +
                    '<div class="form-group">' +
                    '<label for="LunghezzaMassimaTestoBreve">Lunghezza Massima Testo Breve</label>' +
                    '<input id="LunghezzaMassimaTestoBreve" type="number" name="LunghezzaMassimaTestoBreve" class="form-control" placeholder="250">' +
                    '</div>' +
                    '<div class="form-group">' +
                    '<label for="PatternTestoBreve">PatternTestoBreve</label>' +
                    '<input id="PatternTestoBreve" type="text" name="PatternTestoBreve" class="form-control" placeholder="Pattern">' +
                    '</div>' +
                    '</div>'
                );
                break;
            case "testo_lungo":
                vincoliSelect.html('<div class="domanda" id="vincoloDomanda">' +
                    '<div class="form-group">' +
                    '<label for="LunghezzaMinimaTestoLungo">Lunghezza Minima Testo Lungo</label>' +
                    '<input id="LunghezzaMinimaTestoLungo" type="number" name="LunghezzaMinimaTestoLungo" class="form-control" placeholder="Lunghezza Minima Testo Lungo">' +
                    '</div>' +
                    '<div class="form-group">' +
                    '<label for="LunghezzaMassimaTestoLungo">Lunghezza Massima Testo Lungo</label>' +
                    '<input id="LunghezzaMassimaTestoLungo" type="number" name="LunghezzaMassimaTestoLungo" class="form-control" placeholder="Lunghezza Massima Testo Lungo">' +
                    '</div>' +
                    '<div class="form-group">' +
                    '<label for="PatternTestoLungo">Pattern Testo Lungo</label>' +
                    '<input id="PatternTestoLungo" type="text" name="PatternTestoLungo" class="form-control" placeholder="Pattern Testo Lungo">' +
                    '</div>' +
                    '</div>'
                );
                break;
            case "numero":
                vincoliSelect.html('<div class="domanda" id="vincoloDomanda">' +
                    '<div class="form-group">' +
                    '<label for="Numerominimo">Numero minimo</label>' +
                    '<input id="Numerominimo" type="number" name="Numerominimo" class="form-control" placeholder="Numero Minimo">' +
                    '</div>' +
                    '<div class="form-group">' +
                    '<label for="Numeromassimo">Numero massimo</label>' +
                    '<input id="Numeromassimo" type="number" name="Numeromassimo" class="form-control" placeholder="Numero Massimo">' +
                    '</div>' +
                    '</div>'
                );
                break;
            case "data":
                vincoliSelect.html('');
                break;
            case "scelta_singola":
                text = "Inserisci le varie opzioni separate dalla virgola";
                vincoliSelect.html('<div class="domanda" id="vincoloDomanda">' +
                    '<div class="form-group">' +
                    '<label for="sceltasingola">Scelta Singola</label>' +
                    '<input id="sceltasingola" type="text" name="sceltasingola" class="form-control" placeholder="Opzione1,Opzione2,...">' +
                    '</div>' +
                    '</div>'
                );
                break;
            case "scelta_multipla":
                text = "Inserisci le varie opzioni separate dalla virgola";
                vincoliSelect.html('<div class="domanda" id="vincoloDomanda">' +
                    '<div class="form-group">' +
                    '<label for="sceltamultipla">Scelta Multipla</label>' +
                    '<input id="sceltamultipla" type="text" name="sceltamultipla" class="form-control" placeholder="Opzione1,Opzione2,...">' +
                    '</div>' +
                    '<div class="form-group">' +
                    '<label for="Numerominimoscelte">Numero minimo</label>' +
                    '<input id="Numerominimoscelte" type="number" name="Numerominimoscelte" class="form-control" placeholder="es.1">' +
                    '</div>' +
                    '<div class="form-group">' +
                    '<label for="Numeromassimoscelte">Numero massimo</label>' +
                    '<input id="Numeromassimoscelte" type="number" name="Numeromassimoscelte" class="form-control" placeholder="es.4">' +
                    '</div>' +
                    '</div>'
                );
                break;
            default:
        }
    }

</script>
</body>
</html>