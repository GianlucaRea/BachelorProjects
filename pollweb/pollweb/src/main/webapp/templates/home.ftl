<#import "../templates/globalTemplate.ftl" as globalTemplate>

<!DOCTYPE html>
<html>
<head>
    <title>Login - Pollweb</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <@globalTemplate.style />

</head>
<body class="bg-light">
<@globalTemplate.navbar />
<div>
    <a class="block" href="/sondaggi/crea_sondaggio">Crea Sondaggio</a>
    ${request}
</div>
</body>