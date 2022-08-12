<#assign charset="UTF-8">
<#assign title="Modifica password">

<#import "/globalTemplate.ftl" as globalTemplate>

<!DOCTYPE html>
<html>
<head>
    <title>${title} - Pollweb</title>
    <meta charset="${charset}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <@globalTemplate.style />
</head>
<body>
<@globalTemplate.navbar />

<div class="bg-light pt-5 pb-5">
    <div class="container">
        <#if success??>
            <@globalTemplate.success success />
        </#if>
        <#if error??>
            <@globalTemplate.error error />
        </#if>
        <h1>${title}</h1>
        <div class="pt-3">
            <div class="alert alert-error d-none" id="alertValidaPassword">Le nuova password e quella di verifica non corrispondono</div>
            <form action="/utenti/password/modifica" method="post" name="modificaPasswordForm" onsubmit="return validaPassword();">

                <div class="form-group">
                    <label for="vecchiaPassword">Vecchia password</label>
                    <input type="password" id="vecchiaPassword" name="vecchiaPassword" class="form-control" required>
                </div>

                <div class="form-group">
                    <label for="nuovaPassword">Nuova password</label>
                    <input type="password" id="nuovaPassword" name="nuovaPassword" class="form-control" required>
                </div>

                <div class="form-group">
                    <label for="verificaPassword">Ripeti la nuova password</label>
                    <input type="password" id="verificaPassword" name="verificaPassword" class="form-control" required>
                </div>

                <p class="small">* attributo obbligatorio</p>

                <div class="form-group text-right">
                    <input type="submit" id="salvaForm" value="Salva" class="btn btn-primary btn-lg" />
                </div>
            </form>
        </div>
    </div>
</div>

<@globalTemplate.script />

<script>
    function validaPassword() {
        if($("#nuovaPassword").val() !== $("#verificaPassword").val()) {
            $("#alertValidaPassword").show();
            return false;
        }
        return true;
    }

    $("#nuovaPassword").on('keyup', function() {
        $("#alertValidaPassword").hide();
    })

    $("#verificaPassword").on('keyup', function() {
        $("#alertValidaPassword").hide();
    })
</script>
</body>
</html>
