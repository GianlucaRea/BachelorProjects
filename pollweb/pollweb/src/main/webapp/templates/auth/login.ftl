<#import "/globalTemplate.ftl" as globalTemplate>
<#assign title="Login">

<!DOCTYPE html>
<html lang="it">
<head>
    <title>${title} - Pollweb</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <@globalTemplate.style />
    <link rel="stylesheet" href="/css/login.css"/>
</head>
<body>
<div class="row">
    <div class="d-none d-md-block col-md-8 bg-login" id="login-left-side">
        <img src="/img/logo_bianco.png" alt="Pollweb logo"/>
        <h1>Benvenuto su PollWeb!</h1>
        <p>PollWeb è la piattaforma che darà vita ai tuoi sondaggi!</p>
        <p>Puoi creare sondaggi personalizzati scegliendo tra 6 tipologie di domande, condivisibili tramite link o
            tramite invito</p>
    </div>
    <div class="col-md-4" id="login-right-side">
        <div class="container">
            <#if error??>
                <@globalTemplate.error error />
            </#if>
            <h2 class="text-primary">Accedi al tuo account</h2>
            <form id="loginForm" method="post" onsubmit="return onSubmitLoginForm()">
                <div class="form-group">
                    <label for="emailInput">Indirizzo e-mail*</label>
                    <input id="emailInput" type="email" name="email" class="form-control"
                           placeholder="mario.rossi@email.it" required>
                </div>
                <div class="form-group">
                    <label for="passwordInput">Password*</label>
                    <input id="passwordInput" type="password" name="password" class="form-control"
                           placeholder="la tua password" required>
                </div>
                <div class="form-group">
                    <input type="checkbox" id="showPassword"> <label for="showPassword" class="font-weight-normal">Mostra password</label>
                </div>
                <div class="float-right">
                    <button type="submit" class="btn btn-primary btn-lg">Login <i class="fad fa-sign-in fa-fw"></i></button>
                </div>
            </form>
        </div>
    </div>
</div>

<@globalTemplate.script />


<script>
    $(function () {
        $("#showPassword").click(function () {
            console.log("CIAO");
            $(this).is(":checked") ? $("#passwordInput").attr("type", "text") : $("#passwordInput").attr("type", "password");
        });
    });

    function onSubmitLoginForm() {
        if ($('#emailInput').val().length === 0 || $('#passwordInput').val().length === 0) {
            alert('Devi riempire tutti i campi prima di effettuare il login');
            return false;
        }
        return true;
    };
</script>
</body>
</html>
