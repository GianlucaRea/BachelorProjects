<#assign charset="UTF-8">
<#assign title="Nuovo responsabile">

<#import "/templates/globalTemplate.ftl" as globalTemplate>

<!DOCTYPE html>
<html>
    <head>
        <title>${title}</title>
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
                
            </div>
        </div>
        
        <@globalTemplate.script />
    </body>
</html>
