<#import "../globalTemplate.ftl" as globalTemplate>
<#assign title="Riepilogo sondaggio">
<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html lang="it">
<head>
    <title>${title} - Pollweb</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <@globalTemplate.style />
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.22/css/jquery.dataTables.min.css">
</head>
<body class="bg-light">
<@globalTemplate.navbar />
<div class="pt-5 pb-5">
    <div class="container">
        <#if success ??>
            <@globalTemplate.success success />
        </#if>
        <#if error ??>
            <@globalTemplate.error error />
        </#if>
        <h1 class="text-primary">Riepilogo "${sondaggio.getTitolo()}"</h1>
        <div class="card">
            <div class="card-body">
                <ul class="nav nav-tabs" id="tabModificaSondaggio" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="impostazioni-tab" data-toggle="tab" href="#impostazioni"
                           role="tab" aria-controls="impostazioni" aria-selected="true">Impostazioni sondaggio</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="invita-tab" data-toggle="tab" href="#invita" role="tab"
                           aria-controls="invita" aria-selected="false">Invita utenti</a>
                    </li>
                </ul>
                <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade show mt-2 active" id="impostazioni" role="tabpanel"
                         aria-labelledby="impostazioni-tab">
                        <form action="/sondaggi/modifica?id=${sondaggio.getId()}" method="post">
                            <div class="form-group">
                                <label for="titolo">Titolo</label>
                                <input type="text" name="titolo" id="titolo" class="form-control"
                                       value="${sondaggio.getTitolo()}">
                            </div>

                            <div class="form-group">
                                <label for="testoiniziale">Testo iniziale</label>
                                <input type="text" name="testoiniziale" id="testoiniziale" class="form-control"
                                       value="${sondaggio.getTestoiniziale()}">
                            </div>

                            <div class="form-group">
                                <label for="testofinale">Testo finale</label>
                                <input type="text" name="testofinale" id="testofinale" class="form-control"
                                       value="${sondaggio.getTestofinale()}">
                            </div>

                            <div class="clearfix"></div>
                            <div class="float-right mt-2">
                                <button type="submit" class="btn btn-success">Salva modifiche <i class="fad fa-save fa-fw"></i></button>
                            </div>
                        </form>

                    </div>
                    <div class="tab-pane fade mt-5" id="invita" role="tabpanel" aria-labelledby="invita-tab">
                        <form action="/sondaggi/invita_utenti?id=${sondaggio.getId()}" method="post"
                              enctype="multipart/form-data">
                            <div class="form-group">
                                <label for="visibilitaSondaggio">Visibilità del sondaggio</label>
                                <select name="visibilitaSondaggio" id="visibilitaSondaggio" class="form-control"
                                        onchange="changeVisibility()">
                                    <option value="1" <#if sondaggio.getVisibilita()==1>selected</#if> >Pubblico</option>
                                    <option value="2" <#if sondaggio.getVisibilita()==2>selected</#if>>Privato</option>
                                </select>
                            </div>
                            <div id="invitoSondaggioPrivato"
                                 <#if sondaggio.getVisibilita()==1>style="display:none"</#if>>

                                <div class="row">
                                    <div class="col-md-6">
                                        <label for="invitaTramiteEmail">Invita tramite email</label>
                                        <br>
                                        <button type="button" id="invitaTramiteEmail" onclick="aggiungiInvitato()"
                                                class="btn btn-primary">Aggiungi utente <i class="fad fa-plus"></i>
                                        </button>
                                    </div>
                                </div>

                                <div class="row" id="listaInvitati">

                                </div>

                                <div class="mt-2">
                                    <h5>Lista utenti già invitati</h5>

                                    <div class="row mt-2">
                                        <#list invitati as invitato>
                                            <#if invitato.getNome() != "">
                                                <div class="col-md-3 mt-2">
                                                    <p class="small"><i class="fad fa-user"></i> ${invitato.getEmail()}
                                                    </p>
                                                </div>
                                            </#if>
                                        </#list>
                                    </div>
                                </div>
                            </div>

                            <div id="divInvitaTramiteCSV" <#if sondaggio.getVisibilita()==1>style="display:none"</#if>>
                                <label for="invitaTramiteCSV">Puoi invitare una lista di utenti tramite CSV</label>
                                <input type="file" id="invitaTramiteCSV" name="invitatiCSV" class="form-file">
                                <p class="small">Ogni utente deve essere nella forma "nome;email;password"</p>

                                <div class="float-right">
                                    <button type="submit" class="btn btn-success">Salva modifiche <i class="fas fa-save"></i></button>
                                </div>
                            </div>

                        </form>
                    </div>
                </div>


            </div>

        </div>
        <div class="card mt-5">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <h2>Domande</h2>
                    </div>
                    <div class="col-md-6">
                        <div class="float-right">
                            <a href="/sondaggi/domande/crea?id=${sondaggio.getId()}" class="btn btn-primary"><i
                                        class="fas fa-plus"></i> Nuova domanda</a>
                        </div>
                    </div>
                </div>
                <table class="display hover mt-5" id="datatable">
                    <thead>
                    <tr>
                        <th>Nome</th>
                        <th>Tipologia</th>
                        <th>Obbligatoria</th>
                        <th>Azioni</th>
                        <th>Sposta</th>
                    </tr>
                    </thead>
                    <tbody>
                    <#list domande as domanda>
                        <tr class="rowDomanda" id="rowDomanda${domanda.getId()}"
                            data-numero-domanda="${domanda.getId()}">
                            <input type="hidden" id="domandaOrdine${domanda.getId()}"
                                   name="domanda[${domanda.getId()}][ordine]" value="${domanda.getOrdine()}">
                            <td><strong>${domanda.getTesto()}</strong></td>
                            <td>${domanda.getTipologia()}</td>
                            <td>${domanda.getNomeObbligo()}</td>
                            <td>
                                <a href="/sondaggi/domande/modifica?domanda_id=${domanda.getId()}"
                                   class="btn btn-primary btn-sm">Modifica</a>
                                <a href="/sondaggi/domande/elimina?id=${sondaggio.getId()}&domanda_id=${domanda.getId()}"
                                   class="btn btn-primary btn-sm">Rimuovi</a>
                            </td>
                            <td>
                                <button type="button" class="btn btn-secondary btn-sm"
                                        onclick="spostaDomanda(${domanda.getId()}, 'sopra')"><i
                                            class="fas fa-arrow-up"></i></button>
                                <button type="button" class="btn btn-secondary btn-sm"
                                        onclick="spostaDomanda(${domanda.getId()}, 'sotto')"><i
                                            class="fas fa-arrow-down"></i></button>
                            </td>
                        </tr>
                    </#list>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="row mt-5">
            <div class="col-md-6">
                <a href="/" class="btn btn-secondary">
                    Torna alla dashboard
                </a>
            </div>
            <div class="col-md-6">
                <div class="float-right">
                    <a href="/sondaggi/pubblica?id=${sondaggio.getId()}" class="btn btn-success btn-lg">
                        Attiva sondaggio <i class="fas fa-globe-europe"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<@globalTemplate.script />
<script src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js"></script>
<script>
    let countNuoviInvitati = 0;

    $(document).ready(function () {
        $("#datatable").DataTable({
            "order": []
        });
    });

    function aggiungiInvitato() {
        countNuoviInvitati++;
        $("#listaInvitati").append('' +
            '<div class="col-md-4 mt-2" id="nuovoInvitatoNome' + countNuoviInvitati + '">' +
            '<input type="text" name="nuovoInvitato[' + countNuoviInvitati + '][nome]" class="form-control" placeholder="Nome utente" />' +
            '</div>' +
            '<div class="col-md-4 mt-2" id="nuovoInvitato' + countNuoviInvitati + '">' +
            '<input type="email" name="nuovoInvitato[' + countNuoviInvitati + '][email]" class="form-control" placeholder="esempio@email.it" />' +
            '</div>' +
            '<div class="col-md-4 mt-2" id="nuovoInvitato' + countNuoviInvitati + '">' +
            '<input type="password" name="nuovoInvitato[' + countNuoviInvitati + '][password]" class="form-control" placeholder="Password" />' +
            '</div>' +
            '');
    }

    function changeVisibility() {
        let $visibilitaSondaggio = $("#visibilitaSondaggio");
        if ($visibilitaSondaggio.val() == 1) {
            $("#invitoSondaggioPrivato").hide();
            $("#divInvitaTramiteCSV").hide();
        }
        if ($visibilitaSondaggio.val() == 2) {
            $("#invitoSondaggioPrivato").show();
            $("#divInvitaTramiteCSV").show();
        }

    }

    function spostaDomanda(numeroDomanda, direzione) {
        let rowAttuale = $("#rowDomanda" + numeroDomanda);
        let rowScambio;
        console.log(direzione);
        if (direzione == 'sopra') {
            rowScambio = rowAttuale.prev();
        }
        if (direzione == 'sotto') {
            rowScambio = rowAttuale.next();
        }

        if (rowScambio.hasClass("rowDomanda")) {
            let appRowAttuale = rowAttuale.clone();
            let appRowScambio = rowScambio.clone();

            let idRowAttuale = rowAttuale.data("numero-domanda");
            let idRowScambio = rowScambio.data("numero-domanda");

            rowScambio.replaceWith(appRowAttuale);
            rowAttuale.replaceWith(appRowScambio);

            //modifica ordine
            let valOrdineRowAttuale = $("#domandaOrdine" + idRowAttuale).val();
            let valOrdineRowScambio = $("#domandaOrdine" + idRowScambio).val();


            //swap valore ordine input hidden
            $("input[id=domandaOrdine" + idRowAttuale + "]").val(valOrdineRowScambio);
            $("input[id=domandaOrdine" + idRowScambio + "]").val(valOrdineRowAttuale);

            fetch('http://localhost:8080/sondaggi/domande/modifica_ordine?id=${sondaggio.getId()}&domanda_id1=' + idRowAttuale + '&domanda_id2=' + idRowScambio)
                .then(response => response.json())
                .then(data => console.log(data));
        }

    }
</script>
</body>
</html>

