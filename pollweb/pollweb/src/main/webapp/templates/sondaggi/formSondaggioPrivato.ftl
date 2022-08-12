<#assign charset="UTF-8">
<#assign title="Sondaggio privato">

<#import "/globalTemplate.ftl" as globalTemplate>

<!DOCTYPE html>
<html>
<head>
    <title>${title}</title>
    <meta charset="${charset}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <@globalTemplate.style />
</head>
<body class="bg-light">
<@globalTemplate.navbar />

<div class="pt-5 pb-5">
    <div class="container">
        <#if success??>
            <@globalTemplate.success success />
        </#if>
        <#if error??>
            <@globalTemplate.error error />
        </#if>
        <div class="text-center">
            <h1>${title}</h1>
            <p class="lead">Questo sondaggio è privato. <br> Per compilarlo, inserisci il tuo indirizzo email.</p>
        </div>
        <div class="pt-3">
            <div class="row">
                <div class="col-md-6 offset-md-3">
                    <div class="card">
                        <div class="card-body">
                            <form id="formSondaggioPrivato" method="post">
                                <input type="hidden" name="id" value="${sondaggioId}">
                                <div class="form-group">
                                    <label for="inputEmail">Indirizzo email</label>
                                    <input type="email" name="email" id="inputEmail" class="form-control" placeholder="mario.rossi@email.it" />
                                </div>
                                <div class="form-group">
                                    <label for="inputPassword">Password</label>
                                    <input type="password" name="password" id="inputPassword" class="form-control" placeholder="Password">
                                </div>
                                <div class="float-right">
                                    <button type="submit" class="btn btn-primary btn-lg">Accedi al sondaggio <i class="fad fa-sign-in fa-fw"></i></button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<@globalTemplate.script />
</body>
</html>
