<#import "../globalTemplate.ftl" as globalTemplate>

<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
<head>
    <title>Compila sondaggio - Pollweb</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <@globalTemplate.style />
</head>
<body>
<@globalTemplate.navbar />
<div class="bg-light pt-5 pb-5">
    <div class="container" id="creationForm">
        <#if error ??>
            <div class="alert alert-danger">Si è verificato un errore con l'inserimento della compilazione. I campi non
                sono stati compilati correttamente.
            </div>
        </#if>
        <div class="alert alert-danger" style="display: none" id="alertErroreCompilazione">Controlla di aver inserito tutti i campi correttamente
        </div>

        <form id="formCompilazione" method="post" action="/sondaggi/inserisci_compilazione" name="formCompilazione" onsubmit="return validaForm();">
            <input type="hidden" name="sondaggioId" value="${sondaggio.getId()}">
            <#if utente_id ??>
                <input type="hidden" name="utente_id" value="${utente_id}">
            </#if>
            <div class="card mb-3">
                <div class="card-body">
                    <h2 class="text-primary">${sondaggio.getTitolo()}</h2>
                    <p class="lead">${sondaggio.getTestoiniziale()}</p>
                    <#list domande as domanda>

                        <div class="mb-5">
                            <h4 class="mb-0">${domanda.getTesto()}</h4>
                            <p class="mb-0">${domanda.getNota()}</p>
                            <#switch domanda.getTipologia()>
                                <#case "testo_breve">
                                    <input type="text" name="domande[${domanda.getId()}]" class="form-control"
                                            <#if domanda.getVincoli().has("min_length")> minlength="${domanda.getMin_length()}" </#if>
                                            <#if domanda.getVincoli().has("max_length")> maxlength="${domanda.getMax_length()}"</#if>
                                            <#if domanda.getVincoli().has("pattern")> pattern="${domanda.getPattern()}" </#if>
                                            <#if domanda.getObbligo()==1>required</#if> >
                                    <p class="small">
                                        <#if domanda.getVincoli().has("min_length")> Lunghezza minima: ${domanda.getMin_length()}
                                            <br> </#if>
                                        <#if domanda.getVincoli().has("max_length")> Lunghezza massima: ${domanda.getMax_length()}
                                            <br></#if>
                                        <#if domanda.getVincoli().has("pattern")>Pattern: "${domanda.getPattern()}" </#if>
                                    </p>
                                    <#break>
                                <#case "testo_lungo">
                                    <textarea name="domande[${domanda.getId()}]" class="form-control"
                                              cols="30" rows="10"
                                            <#if domanda.getVincoli().has("min_length")> min="${domanda.getMin_length()}" </#if>
                                            <#if domanda.getVincoli().has("max_length")> maxlength="${domanda.getMax_length()}"</#if>
                                            <#if domanda.getVincoli().has("pattern")> pattern="${domanda.getPattern()}" </#if>
                                            <#if domanda.getObbligo()==1>required</#if>></textarea>
                                    <p class="small">
                                        <#if domanda.getVincoli().has("min_length")> Lunghezza minima: ${domanda.getMin_length()}
                                            <br> </#if>
                                        <#if domanda.getVincoli().has("max_length")> Lunghezza massima: ${domanda.getMax_length()}
                                            <br></#if>
                                        <#if domanda.getVincoli().has("pattern")>Pattern: "${domanda.getPattern()}" </#if>
                                    </p>
                                    <#break>
                                <#case "numero">
                                    <input type="number" class="form-control" name="domande[${domanda.getId()}]"
                                           <#if domanda.getVincoli().has("min_num")>min="${domanda.getMin_num()}"</#if>
                                            <#if domanda.getVincoli().has("max_num")>max="${domanda.getMax_num()}"</#if>
                                            <#if domanda.getObbligo()==1>required</#if>>
                                    <p class="small">
                                        <#if domanda.getVincoli().has("min_num")>Numero minimo: ${domanda.getMin_num()}
                                            <br></#if>
                                        <#if domanda.getVincoli().has("max_num")>Numero massimo: ${domanda.getMax_num()}</#if>
                                    </p>
                                    <#break>
                                <#case "data">
                                    <input type="date" class="form-control" name="domande[${domanda.getId()}]"
                                           <#if domanda.getObbligo()==1>required</#if>>
                                    <#break>
                                <#case "scelta_singola">
                                    <select class="form-control" name="domande[${domanda.getId()}]"
                                            <#if domanda.getObbligo()==1>required</#if>>
                                        <#list domanda.getChoosesArrayList() as choose>
                                            <option value="${choose}">${choose}</option>
                                        </#list>
                                    </select>
                                    <#break>
                                <#case "scelta_multipla">
                                    <select class="form-control select-multipla" name="domande[${domanda.getId()}]" multiple
                                            <#if domanda.getVincoli().has("min_chooses")>data-min-chooses="${domanda.getMin_chooses()}"</#if> <#if domanda.getVincoli().has("max_chooses")>data-max-chooses="${domanda.getMax_chooses()}"</#if> <#if domanda.getObbligo()==1>required</#if> >
                                        <#list domanda.getChoosesArrayList() as choose>
                                            <option value="${choose}">${choose}</option>
                                        </#list>
                                    </select>
                                    <p class="small"><#if domanda.getVincoli().has("min_chooses")>Numero scelte minime: ${domanda.getMin_chooses()}
                                            <br></#if> <#if domanda.getVincoli().has("max_chooses")>Numero scelte massime: ${domanda.getMax_chooses()}</#if>
                                    </p>
                                    <#break>
                            </#switch>
                        </div>

                    </#list>
                    <div class="float-right">
                        <button type="submit" class="btn btn-success btn-lg">Invia compilazione <i
                                    class="fas fa-upload"></i></button>
                    </div>
                    <p class="lead">${sondaggio.getTestofinale()}</p>
                </div>
            </div>
        </form>
    </div>
</div>

<@globalTemplate.script />
<script>
    function validaForm() {
        let valido = true;
        $("#alertErroreCompilazione").css("display", "none");
        $(".select-multipla").each(function () {
            if ($(this).val().length < $(this).data("min-chooses") || $(this).val().length > $(this).data("max-chooses")) {
                $("#alertErroreCompilazione").css("display", "block");
                $(this).css("border", "1px solid red");
                valido = false;
            } else {
                $(this).css("border", "none");
            }
        });
        return valido;
    }

</script>
</body>

</html>