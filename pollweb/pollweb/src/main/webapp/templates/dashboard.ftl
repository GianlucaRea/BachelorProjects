<#import "/globalTemplate.ftl" as globalTemplate>
<#assign title="Dashboard">

<!DOCTYPE html>
<html lang="it">
<head>
    <title>${title} - PollWeb</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <@globalTemplate.style />
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.22/css/jquery.dataTables.min.css">
</head>
<body>
<@globalTemplate.navbar />

<div class="bg-light pt-5 pb-5">
    <div class="container">
        <#if success ??>
            <@globalTemplate.success success />
        </#if>

        <#if error ??>
            <@globalTemplate.error error />
        </#if>
        <div class="row">
            <div class="col-md-8">
                <h1 class="text-primary">La tua dashboard</h1>
            </div>
            <div class="col-md-4">
                <div class="float-right">
                    <a href="/utenti/password/modifica" class="btn btn-primary">Modifica la tua password <i class="fad fa-key fa-fw"></i></a>
                    <a href="/logout" class="btn btn-primary">Esci <i class="fad fa-sign-out-alt fa-fw"></i></a>

                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-8">
                        <h2>Lista sondaggi</h2>
                    </div>
                    <div class="col-md-4">
                        <div class="float-right">
                            <a href="/sondaggi/crea_sondaggio" class="btn btn-primary">Nuovo sondaggio <i
                                        class="fas fa-plus fa-fw"></i></a>
                        </div>
                    </div>
                </div>
                <div class="row mt-5">
                    <#list sondaggi as sondaggio>
                        <div class="col-md-4 mt-4">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title">${sondaggio.getTitolo()} <span class="float-right" data-toggle="tooltip" data-placement="top" title="<#if sondaggio.getVisibilita()==1>Sondaggio pubblico</#if> <#if sondaggio.getVisibilita()==2>Sondaggio privato</#if>"><i
                                                    class="fad text-primary <#if sondaggio.getVisibilita()==1>fa-lock-open</#if> <#if sondaggio.getVisibilita()==2>fa-lock</#if> fa-fw"></i></span>
                                    </h5>
                                    <p>
                                        <span class="badge <#if sondaggio.getStato()==0>badge-secondary</#if> <#if sondaggio.getStato()==1>badge-info</#if> <#if sondaggio.getStato()==2>badge-success</#if>">
                                            ${sondaggio.getNomeStato()}
                                        </span>
                                    </p>
                                    <p>
                                        <#if sondaggio.getStato() == 0>
                                            <a href="/sondaggi/riepilogo?id=${sondaggio.getId()}"
                                               class="btn btn-primary"><i class="fad fa-edit fa-fw"></i> Vai al
                                                riepilogo</a>
                                        </#if>
                                        <#if sondaggio.getStato() == 1>
                                            <a href="/sondaggi/chiudi?id=${sondaggio.getId()}"
                                               class="btn btn-primary"><i class="fad fa-do-not-enter fa-fw"></i> Chiudi
                                                il sondaggio</a> <br><a href="/sondaggi/compilazione?id=${sondaggio.getId()}">Link per la compilazione</a>
                                        </#if>
                                        <#if sondaggio.getStato() == 2>
                                            <a href="/sondaggi/risultato?id=${sondaggio.getId()}"
                                               class="btn btn-primary"><i class="fad fa-poll fa-fw"></i> Visualizza
                                                risultati</a>
                                            <a href="/sondaggi/esportazione?id=${sondaggio.getId()}"
                                               class="btn btn-secondary"><i class="fad fa-file-csv fa-fw"></i> CSV</a>
                                        </#if>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </#list>
                </div>
            </div>
        </div>
        <#if responsabili != null>
            <div class="card mt-3">
                <div class="card-body">
                    <div class="row mb-5">
                        <div class="col-md-8">
                            <h2>Lista responsabili</h2>
                        </div>
                        <div class="col-md-4">
                            <div class="float-right">
                                <a href="/utenti/nuovo_responsabile" class="btn btn-primary">Nuovo responsabile <i
                                            class="fas fa-plus fa-fw"></i></a>
                            </div>
                        </div>
                    </div>
                    <table class="display hover mt-5" id="datatable">
                        <thead>
                        <tr>
                            <th>Nome</th>
                            <th>Cognome</th>
                            <th>Email</th>
                        </tr>
                        </thead>
                        <tbody>
                        <#list responsabili as responsabile>
                            <tr>
                                <td>${responsabile.getNome()}</td>
                                <td>${responsabile.getCognome()}</td>
                                <td>${responsabile.getEmail()}</td>
                            </tr>
                        </#list>
                        </tbody>
                    </table>
                </div>
            </div>
        </#if>

    </div>
</div>

<@globalTemplate.script />
<script src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js"></script>
<script>
    $(document).ready(function () {
        $("#datatable").DataTable({
            "order": []
        });
    });
</script>
</body>
</html>
