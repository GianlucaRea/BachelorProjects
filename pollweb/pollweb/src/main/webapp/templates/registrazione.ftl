<div class="col card rows-card">
    <form class="needs-validation" id="formRegistrazione" action="Registrazione" method="post">
        <div class="row">
            <div class="col-lg-6 form-group">
                <label for="inputNome" class="col-lg-12 field-title"><i class="fas fa-user" ></i>Nome</label>
                <div class="col">
                    <input type="text" id="inputNome" name="inputNome" <#if (error??) && (! inputNome??)>class="form-control is-invalid" aria-invalid="true" aria-describedby="inputNomeTitolareA-error"<#else>class="form-control"</#if> required="required" placeholder="Nome" <#if inputNome??> value="${inputNomeS}"</#if>>
                    <#if (error??) && (! inputNome??)>
                        <div id="inputNome-error" class="error invalid-feedback d-block">Inserire almeno due caratteri</div>
                    </#if>
                </div>
            </div>
            <div class="col-lg-6 form-group">
                <label for="inputCognome" class="col-lg-12 field-title"><i class="fas fa-user" ></i>Cognome</label>
                <div class="col">
                    <input type="text" id="inputCognome" name="inputCognome" required="required" <#if (error??) && (! inputCognome??)>class="form-control is-invalid" aria-invalid="true" aria-describedby="inputNomeTitolareA-error"<#else>class="form-control"</#if> placeholder="Cognome" <#if inputCognome??> value="${inputCognome}"</#if>>
                    <#if (error??) && (! inputCognome??)>
                        <div id="inputCognome-error" class="error invalid-feedback d-block">Inserire almeno due caratteri</div>
                    </#if>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-6 form-group">
                <label for="inputEmail" class="col-lg-12 field-title"><i class="fas fa-envelope"></i>Email</label>
                <div class="col">
                    <input type="email" id="inputEmail" required="required" name="inputEmail" <#if (error??) && (! inputEmail??)>class="form-control is-invalid" aria-invalid="true" aria-describedby="inputNomeTitolareA-error"<#else>class="form-control"</#if> placeholder="Email" <#if inputEmail??> value="${inputEmail}"</#if>>
                    <#if (error??) && (! inputEmail??)>
                        <div id="inputEmail-error" class="error invalid-feedback d-block">Email obbligatoria</div>
                    </#if>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-6 form-group">
                <label for="inputPassword" class="col-lg-12 field-title"><i class="fas fa-key"></i>Password</label>
                <div class="col">
                    <input type="password" id="inputPassword" required="required" name="inputPassword" <#if (error??) && (! inputNomeTitolareA??)>class="form-control is-invalid" aria-invalid="true" aria-describedby="inputNomeTitolareA-error"<#else>class="form-control"</#if> placeholder="Password" <#if inputPassword??> value="${inputPassword}"</#if>>
                    <#if (error??) && (! inputEmail??)>
                        <div id="inputPassword-error" class="error invalid-feedback d-block">Password obbligatoria: 8 caratteri, 1 minuscola, 1 maiuscola ed 1 simbolo speciale</div>
                    </#if>
                </div>
            </div>
            <div class="col-lg-6 form-group">
                <label for="inputRepeatPassword" class="col-lg-12 field-title"><i class="fas fa-key"></i>Ripeti password</label>
                <div class="col">
                    <input type="password" id="inputRepeatPassword" name="inputRepeatPassword" <#if (error??) && (! inputRepeatPassword??)>class="form-control is-invalid" aria-invalid="true" aria-describedby="inputNomeTitolareA-error"<#else>class="form-control"</#if> placeholder="Ripeti Password" <#if inputRepeatPassword??> value="${inputRepeatPassword}"</#if>>
                    <#if (error??) && (! inputTelefonoS??)>
                        <div id="inputRepeatPassword-error" class="error invalid-feedback d-block">Password obbligatoria: 8 caratteri, 1 minuscola, 1 maiuscola ed 1 simbolo speciale</div>
                    </#if>
                </div>
            </div>


        </div>
        <div class="row">
            <div class="col-lg-6 form-group">
                <label for="inputResponsabile" class="col-lg-12 field-title"><i class="fas fa-wheelchair"></i>Creazione Sondaggi</label>
                <div class="col">
                    <select <#if (error??) && (! inputResponsabile??)>class="form-control is-invalid appearanceDeactive" aria-invalid="true" aria-describedby="inputNomeTitolareA-error"<#else>class="form-control appearanceDeactive"</#if> id="inputResponsabile" name="inputResponsabile" required="required">

                        <#if inputResponsabile?? && inputResponsabile == "true">
                            <option value="si" selected="selected">SI</option>
                            <option value="no">NO</option>
                        <#else>
                            <option value="no" selected="selected">NO</option>
                            <option value="si">SI</option>
                        </#if>
                    </select>
                    <#if (error??) && (! inputResponsabile??)>
                        <div id="inputResponsabile-error" class="error invalid-feedback d-block">Campo non valorizzato o non valido: SI/NO</div>
                    </#if>
                </div>
            </div>
        </div>
        <div class="cardfoot row justify-content-end">
            <button type="submit" value="utente" class="btn btn-sm btn-primary col-2 align-self-end" id="register" name="register">Registrami</button>
        </div>
    </form>
</div>


<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.1/dist/jquery.validate.js"></script>

<script>
    $( document ).ready( function () {
        jQuery.validator.addMethod("lowerCase", function(value, element) {
            // allow any non-whitespace characters as the host part
            return this.optional( element ) || /(?=.*[a-z])/.test( value );
        }, 'Inserire almeno una lettera minuscola');
        jQuery.validator.addMethod("upperCase", function(value, element) {
            // allow any non-whitespace characters as the host part
            return this.optional( element ) || /(?=.*[A-Z])/.test( value );
        }, 'Inserire almeno una lettera maiuscola');
        jQuery.validator.addMethod("carattereSpeciale", function(value, element) {
            // allow any non-whitespace characters as the host part
            return this.optional( element ) || /(?=.*[#$^+=!*()@%&])/.test( value );
        }, 'Inserire almeno un carattere speciale: #,$,^,+,=,!,*,@,%,&');




        $( "#formStudenteRegistrazione").validate( {
            rules: {
                inputNome: "required",
                inputCognome: "required",
                inputEmail: {
                    required:true,
                    email: true,
                    remote: {
                        type: "POST",
                        url: 'DynamicValidation',

                        data: {
                            'inputEmail': function() {
                                return $( "#inputEmail").val();
                            }
                        },
                    }
                },
                inputPassword: {
                    required: true,
                    minlength: 8,
                    maxlength: 30,
                    lowerCase: true,
                    upperCase: true,
                    carattereSpeciale: true

                },
                inputRepeatPassword: {
                    required: true,
                    minlength: 8,
                    equalTo: "#inputPassword"
                },
                inputResponsabile: "required",
            },
            messages: {
                inputNome: "Inserisci il tuo nome",
                inputCognome: "Inserisci il tuo cognome",
                inputEmail: {
                    required: "Email obbligatoria",
                    email: "Inserire una mail valida",
                    remote: "L'indirizzo {0} è già in uso"
                },
                inputPassword: {
                    required: "Password Obbligatoria",
                    lowerCase: "Inserire almeno una lettera minuscola",
                    upperCase: "Inserire almeno una lettera maiuscola",
                    minlength: "Inserire almeno 8 caratteri",
                    maxlength: "Inserire al massimo 30 caratteri",
                    carattereSpeciale: "Inserire almeno un carattere speciale: #,$,^,+,=,!,*,@,%,&"

                },
                inputRepeatPassword: {
                    required: "Password Obbligatoria",
                    minlength: "Inserire almeno 5 caratteri",
                    equalTo: "Le Password non corrispondono"
                },
                inputResponsabile: "Capo obbligatorio",
            },
            errorElement: "div",
            errorPlacement: function ( error, element ) {
                // Add the `help-block` class to the error element
                error.addClass( "invalid-feedback" );

                if ( element.prop( "type" ) === "checkbox" ) {
                    error.insertAfter( element.parent( "label" ) );
                } else {
                    error.insertAfter( element );
                }
            },
            highlight: function ( element, errorClass, validClass ) {
                $( element ).addClass( "is-invalid" ).removeClass( "is-valid" );
            },
            unhighlight: function (element, errorClass, validClass) {
                $( element ).addClass( "is-valid" ).removeClass( "is-invalid" );
            }
        } );
    });
</script>