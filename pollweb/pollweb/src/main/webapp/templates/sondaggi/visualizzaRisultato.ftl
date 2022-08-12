<#import "../globalTemplate.ftl" as globalTemplate>

<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html lang="it">
<head>
    <title>Visualizza risultati - Pollweb</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <@globalTemplate.style />
</head>
<body class="bg-light">
<@globalTemplate.navbar />
<div class="pt-5 pb-5">
    <div class="container">
        <h1 class="text-primary">Visualizza risultati del sondaggio ${sondaggio.getTitolo()}</h1>

        <#list ris as r>
            <div class="card">
                <div class="card-body mb-4">
                    <h5 class="card-title">Compilazione (${r.getEmail()})</h5>
                    <#list r.getRisposte() as key, risposta>
                        <p class="mb-0"><strong><#if key ??>${domande[key?string].getTesto()}<#else>Domanda</#if></strong></p>
                        <p>${risposta}</p>
                    </#list>
                </div>
            </div>
        </#list>


        <a href="/" class="btn btn-secondary mt-3">Torna alla dashboard</a>
    </div>
</div>

<@globalTemplate.script />

</body>
</html>